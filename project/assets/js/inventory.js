let inventoryCurrentSearch = '';
let inventoryDebounceTimer;
jQuery(function(){
    listOfSales(1, '');
    setInterval(function(){
        getTotalSales();
    }, 30000);
    getTotalSales();

    $('#inventory-sales-data-tab').on('click', function(){
        getTotalSales();
    });

    $(document).on('click', '.inventory-page-link', function(e) {
        e.preventDefault();
        let page = $(this).data('page');
        listOfSales(page, inventoryCurrentSearch);
    });

    $('#searchInventorySalesOrderNumber').on('keyup', function() {
        clearTimeout(inventoryDebounceTimer);
        let searchQuery = $(this).val();

        inventoryDebounceTimer = setTimeout(() => {
            inventoryCurrentSearch = searchQuery;
            listOfSales(1, searchQuery);
        }, 500);
    });

    $('#filterSalesByDate').on('change', function(){
        const date = $(this).val();
        getSalesByDate($, date)
    });
})

function listOfSales(page, searchQuery){
      jQuery.ajax({
        url: './controller/ListOfSalesController.php',
        type: 'GET',
        data: { page: page, search: searchQuery },
        dataType: 'json',
        success: function(response) {
            jQuery('#inventory-sales-data-container').empty();
            for (let i = 0; i < response.data.length; i++){
                jQuery('#inventory-sales-data-container').append(`<tr>
                    <td>${response.data[i].order_number}</td>
                    <td>${response.data[i].quantity}</td>
                    <td>${response.data[i].product_name}</td>
                    <td>${formatCurrency(response.data[i].price)}</td>
                    <td class="text-capitalize">${response.data[i].unit_of_price}</td>
                    <td>${formatCurrency(response.data[i].tax_amount)}</td>
                    <td>${formatCurrency(response.data[i].total)}</td>
                    <td>${new Date(response.data[i].created_at).toDateString()}</td>
                    <td class="flex flex-row justify-content-between text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="18" id="viewOrderDetail" data-id="${response.data[i].id}" data-bs-toggle="modal" data-bs-target="#viewOrderDetail" data-bs-auto-close="false"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" id="confirmationDeletionModal" data-id="${response.data[i].id}" data-bs-toggle="modal" data-bs-target="#confirmationDeletionModal" data-bs-auto-close="false" class="d-none"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M170.5 51.6L151.5 80l145 0-19-28.4c-1.5-2.2-4-3.6-6.7-3.6l-93.7 0c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80 368 80l48 0 8 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-8 0 0 304c0 44.2-35.8 80-80 80l-224 0c-44.2 0-80-35.8-80-80l0-304-8 0c-13.3 0-24-10.7-24-24S10.7 80 24 80l8 0 48 0 13.8 0 36.7-55.1C140.9 9.4 158.4 0 177.1 0l93.7 0c18.7 0 36.2 9.4 46.6 24.9zM80 128l0 304c0 17.7 14.3 32 32 32l224 0c17.7 0 32-14.3 32-32l0-304L80 128zm80 64l0 208c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-208c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0l0 208c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-208c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0l0 208c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-208c0-8.8 7.2-16 16-16s16 7.2 16 16z"/></svg>
                        </td>
                </tr>`)
            }

            // Generate pagination links
            jQuery('#inventory-sales-data-pagination-links').empty();

            // Previous Button
            jQuery('#inventory-sales-data-pagination-links').append(`
                <li class="page-item ${page === 1 ? 'disabled' : ''}">
                    <a class="page-link inventory-page-link" href="#" data-page="${page - 1}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            `);
            
            // Page Numbers
            for (let i = 1; i <= response.total_pages; i++) {
                jQuery('#inventory-sales-data-pagination-links').append(`
                    <li class="page-item ${i === page ? 'active' : ''}">
                        <a class="page-link inventory-page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `);
            }

            // Next Button
            jQuery('#inventory-sales-data-pagination-links').append(`
                <li class="page-item ${page === response.total_pages ? 'disabled' : ''}">
                    <a class="page-link inventory-page-link" href="#" data-page="${page + 1}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            `);
        },
        error: function() {
            console.error('Error loading data');
        }
    });
}

function getTotalSales(){
      jQuery.ajax({
        url: './controller/SalesController.php',
        type: 'GET',
        dataType: 'json',
        success: function(response){
            if(response.status === 'success'){
                if(response.data.weekly){
                    const weeklySales = {
                        target: response.data.weekly[0]?.total_sales || 0,          
                        element: '#inventoryWeeklySales', 
                        duration: 2000,         
                        prefix: '₱',            
                        suffix: '',              
                        separator: ',',         
                        decimals: 0,            
                        easing: 'linear'        
                    };
                    animateCounter(weeklySales);
                }

                if(response.data.monthly){
                    const monthlySales = {
                        target: response.data.monthly[0]?.total_sales || 0,          
                        element: '#inventoryMonthlySales', 
                        duration: 2000,         
                        prefix: '₱',            
                        suffix: '',             
                        separator: ',',         
                        decimals: 0,            
                        easing: 'linear'        
                    };
                    animateCounter(monthlySales);
                }

                if(response.data.yearly) {
                    const yearlySales = {
                        target: response.data.yearly[0]?.total_sales || 0,          
                        element: '#inventoryYearlySales', 
                        duration: 2000,         
                        prefix: '₱',            
                        suffix: '',             
                        separator: ',',         
                        decimals: 0,            
                        easing: 'linear'        
                    };
                    animateCounter(yearlySales);
                }

                if(response.data.yearly) {
                    const totalSales = {
                        target: response.data.yearly[0]?.total_sales,          
                        element: '#dashboardTotalSales', 
                        duration: 2000,         
                        prefix: '₱',            
                        suffix: '',             
                        separator: ',',         
                        decimals: 0,            
                        easing: 'linear'        
                    };
                    animateCounter(totalSales);
                }

            }else{
                Swal.fire({
                    title: 'Warning!',
                    text: response.message,
                    icon: 'warning',
                })
            }
        }
    })
}

function getSalesByDate($, date){
        jQuery.ajax({
        url: './controller/FilterSalesByDateController.php',
        type: 'GET',
        data: { date },
        dataType: 'json',
        success: function(response){
            $('#inventory-sales-data-container').empty();
            if(response.status === 'success'){ 
                for (let i = 0; i < response.data.length; i++){
                    jQuery('#inventory-sales-data-container').append(`<tr>
                        <td>${response.data[i].order_number}</td>
                        <td>${response.data[i].quantity}</td>
                        <td>${response.data[i].product_name}</td>
                        <td>${formatCurrency(response.data[i].price)}</td>
                        <td class="text-capitalize">${response.data[i].unit_of_price}</td>
                        <td>${formatCurrency(response.data[i].tax_amount)}</td>
                        <td>${formatCurrency(response.data[i].total)}</td>
                        <td>${new Date(response.data[i].created_at).toDateString()}</td>
                        <td class="flex flex-row justify-content-between text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="18" id="viewOrderDetail" data-id="${response.data[i].id}" data-bs-toggle="modal" data-bs-target="#viewOrderDetail" data-bs-auto-close="false"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" id="confirmationDeletionModal" data-id="${response.data[i].id}" data-bs-toggle="modal" data-bs-target="#confirmationDeletionModal" data-bs-auto-close="false" class="d-none"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M170.5 51.6L151.5 80l145 0-19-28.4c-1.5-2.2-4-3.6-6.7-3.6l-93.7 0c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80 368 80l48 0 8 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-8 0 0 304c0 44.2-35.8 80-80 80l-224 0c-44.2 0-80-35.8-80-80l0-304-8 0c-13.3 0-24-10.7-24-24S10.7 80 24 80l8 0 48 0 13.8 0 36.7-55.1C140.9 9.4 158.4 0 177.1 0l93.7 0c18.7 0 36.2 9.4 46.6 24.9zM80 128l0 304c0 17.7 14.3 32 32 32l224 0c17.7 0 32-14.3 32-32l0-304L80 128zm80 64l0 208c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-208c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0l0 208c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-208c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0l0 208c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-208c0-8.8 7.2-16 16-16s16 7.2 16 16z"/></svg>
                            </td>
                    </tr>`)
                }
            }
        }
    })
}

function formatCurrency(price){
    const php = new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP'
    })

    return php.format(price);
}

function formatNumber(num, opts) {
  const fixedNum = num.toFixed(opts.decimals);
  const parts = fixedNum.split('.');
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, opts.separator);
  return opts.prefix + parts.join('.') + opts.suffix;
}

function animateCounter(opts) {
    const $el = $(opts.element);
    let startTimestamp = null;
    
    const step = (timestamp) => {
      if (!startTimestamp) startTimestamp = timestamp;
      const progress = Math.min((timestamp - startTimestamp) / opts.duration, 1);
      
      const easedProgress = opts.easing === 'linear' ? progress : 
                           Math.sin(progress * Math.PI/2);
      
      const value = easedProgress * (opts.target - 0) + 0;
      $el.text(formatNumber(value, opts));
      
      if (progress < 1) {
        window.requestAnimationFrame(step);
      }
    };
    
  window.requestAnimationFrame(step);
}
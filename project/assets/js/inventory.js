let inventoryCurrentSearch = '';
let inventoryDebounceTimer;
let salesFilterState = {
    startDate: null,
    endDate: null,
    page: 1,
    items_per_page: 10
};

jQuery(function(){
    listOfSales(1, '');
    setInterval(function(){
        getTotalSales();
    }, 30000);
    getTotalSales();

    $('#inventory-sales-data-tab').on('click', function(){
        getTotalSales();
    });

    $('#loadAllData').on('click', function() {
        $('#filterSalesByDate').val('');
        listOfSales(1, '');
    });

    $(document).on('click', '.inventory-page-link', function() {
        let page = $(this).data('page');
        listOfSales(page, inventoryCurrentSearch);
    });

    $(document).on('click', '.date-range-page-link', function() {
        const page = parseInt($(this).data('page'));

        if (page < 1 || (page > totalPages && totalPages > 0)) return;

        const newPayload = {
            ...salesFilterState,
            page: page
        };

        salesFilterState.page = page;

        getSalesByDate($, newPayload);
    });

    $('#searchInventorySalesOrderNumber').on('keyup', function() {
        clearTimeout(inventoryDebounceTimer);
        let searchQuery = $(this).val();

        inventoryDebounceTimer = setTimeout(() => {
            inventoryCurrentSearch = searchQuery;
            listOfSales(1, searchQuery);
        }, 500);
    });

    $('#filterSalesByDate').daterangepicker({
        opens: 'left',
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    }, function(start, end, label) {
        $('#filterSalesByDate').val(start.format('MM/DD/YYYY') + ' - ' + end.format('MM/DD/YYYY'));

        salesFilterState.startDate = start.format('YYYY-MM-DD');
        salesFilterState.endDate = end.format('YYYY-MM-DD');
        salesFilterState.page = 1;

        getSalesByDate($, { ...salesFilterState });
    });

    $(document).on('click', '.view-order-detail', function() {
        const orderId = $(this).data('id');
        getOrderDetail(orderId);
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
                        <button
                            class="btn btn-sm view-order-detail"
                            data-id="${response.data[i].id}"
                        >
                        <i class="fas fa-eye"></i>
                        </button>
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
            for (let i = 1; i <= response.pagination.total_pages; i++) {
                jQuery('#inventory-sales-data-pagination-links').append(`
                    <li class="page-item ${i === page ? 'active' : ''}">
                        <a class="page-link inventory-page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `);
            }

            // Next Button
            jQuery('#inventory-sales-data-pagination-links').append(`
                <li class="page-item ${page === response.pagination.total_pages ? 'disabled' : ''}">
                    <a class="page-link inventory-page-link" href="#" data-page="${page + 1}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            `);

            $('#totalSalesAmount').text(formatCurrency(response.total_amount || 0));
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

function getSalesByDate($, payload) {
    jQuery.ajax({
        url: './controller/FilterSalesByDateController.php',
        type: 'GET',
        data: payload,
        dataType: 'json',
        success: function(response) {
            $('#inventory-sales-data-container').empty();

            if (response.status === 'success') {
                response.data.forEach(item => {
                    jQuery('#inventory-sales-data-container').append(`
                        <tr>
                            <td>${item.order_number}</td>
                            <td>${item.quantity}</td>
                            <td>${item.product_name}</td>
                            <td>${formatCurrency(item.price)}</td>
                            <td class="text-capitalize">${item.unit_of_price}</td>
                            <td>${formatCurrency(item.tax_amount)}</td>
                            <td>${formatCurrency(item.total)}</td>
                            <td>${new Date(item.created_at).toLocaleDateString()}</td>
                            <td class="flex flex-row justify-content-between text-center">
                                <button class="btn btn-sm view-order-detail" data-id="${item.id}">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    `);
                });

                $('#totalSalesAmount').text(formatCurrency(response.summary.total_sales || 0));

                const $paginationContainer = $('#inventory-sales-data-pagination-links');
                $paginationContainer.empty();

                const currentPage = payload.page;
                const totalPages = response.pagination.total_pages;

                // Previous Button
                $paginationContainer.append(`
                    <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link date-range-page-link" href="#" data-page="${currentPage - 1}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                `);

                const maxVisible = 5;
                let startPage = Math.max(1, currentPage - Math.floor(maxVisible / 2));
                let endPage = startPage + maxVisible - 1;

                if (endPage > totalPages) {
                    endPage = totalPages;
                    startPage = Math.max(1, endPage - maxVisible + 1);
                }

                for (let i = startPage; i <= endPage; i++) {
                    $paginationContainer.append(`
                        <li class="page-item ${i === currentPage ? 'active' : ''}">
                            <a class="page-link date-range-page-link" href="#" data-page="${i}">${i}</a>
                        </li>
                    `);
                }

                // Next Button
                $paginationContainer.append(`
                    <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                        <a class="page-link date-range-page-link" href="#" data-page="${currentPage + 1}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                `);

                $('.date-range-page-link').on('click', function(e) {
                    e.preventDefault();
                    const page = parseInt($(this).data('page'));

                    if (page < 1 || (page > totalPages && totalPages > 0)) return;

                    const newPayload = {
                        ...salesFilterState,
                        page: page
                    };

                    salesFilterState.page = page;

                    getSalesByDate($, newPayload);
                });
            }
        },
        error: function() {
            $('#inventory-sales-data-container').html(`
                <tr><td colspan="9" class="text-center">Failed to load data.</td></tr>
            `);
        }
    });
}
function getOrderDetail(orderId){
    jQuery.ajax({
        url: './controller/ViewOrderDetailController.php',
        type: 'GET',
        data: { id: orderId },
        dataType: 'json',
        success: function(response){
            if(response.success){
                jQuery('#viewOrderNumber').val(response.order.order_number);
                jQuery('#viewOrderQuantity').val(response.order.quantity);
                jQuery('#viewOrderProductName').val(response.order.product_name);
                jQuery('#viewOrderPrice').val(formatCurrency(response.order.price));
                jQuery('#viewUnitOfPrice').val(response.order.unit_of_price);
                jQuery('#viewTaxAmount').val(formatCurrency(response.order.tax_amount));
                jQuery('#viewOrderDateSold').val(new Date(response.order.created_at).toDateString());
                const modal = new bootstrap.Modal(document.getElementById('viewOrderDetailModal'));
                modal.show();
            }else{
                console.error(response.message);
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
let salesChart = null;

jQuery(function($){
  setInterval(function(){
    fetchOrders();
  }, 30000);
  fetchOrders();
});


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
  
function formatNumber(num, opts) {
  const fixedNum = num.toFixed(opts.decimals);
  const parts = fixedNum.split('.');
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, opts.separator);
  return opts.prefix + parts.join('.') + opts.suffix;
}

function fetchOrders(){
  jQuery.ajax({
        url: './controller/SalesController.php',
        type: 'GET',
        dataType: 'json',
        success: function(response){
          const products = response.data.yearly[0]?.products.map((value) => value.product_name);
          const sales = response.data.yearly[0]?.products.map((value) => value.total_sales);
            if(response.status === 'success'){
              const ctx = $('#salesChart')[0].getContext('2d');

              if (salesChart !== null) {
                  salesChart.destroy();
              }
              
              salesChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                      labels: products,
                      datasets: [{
                          label: 'Hot Sales',
                          data: sales,
                          backgroundColor: [
                          'rgba(54, 162, 235, 0.2)',
                          'rgba(255, 99, 132, 0.2)',
                          'rgba(255, 159, 64, 0.2)',
                          'rgba(255, 205, 86, 0.2)',
                          'rgba(75, 192, 192, 0.2)'
                          ],
                          borderColor: [
                          'rgb(54, 162, 235)',
                          'rgb(255, 99, 132)',
                          'rgb(255, 159, 64)',
                          'rgb(255, 205, 86)',
                          'rgb(75, 192, 192)'
                          ],
                          borderWidth: 1,
                          hoverOffset: 4
                      }]
                  },
                  options: {
                      responsive: true,
                      plugins: {
                          legend: {
                              display: true,
                              position: 'top',
                          },
                          tooltip: {
                              enabled: true,
                          }
                      },
                      indexAxis: 'x',
                      scales: {
                          y: {
                              beginAtZero: true
                          }
                      }
                  }
              });

              if(response.data.weekly){
                    const weeklySales = {
                        target: response.data.weekly[0]?.total_sales || 0,          
                        element: '#weeklySales', 
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
                        element: '#monthlySales', 
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
                        element: '#yearlySales', 
                        duration: 2000,         
                        prefix: '₱',            
                        suffix: '',             
                        separator: ',',         
                        decimals: 0,            
                        easing: 'linear'        
                    };
                    animateCounter(yearlySales);
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
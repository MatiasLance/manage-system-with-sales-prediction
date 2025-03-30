
// Sample data
const products = ["Choco", "Milk", "Cow", "Goat", "Fish"];
const salesData = [120, 90, 150, 80, 200];

// Chart.js for Sales Graph
const ctx = $('#salesChart')[0].getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: products, // Product names as labels
        datasets: [{
            label: 'Sales Count',
            data: salesData,
            backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(255, 205, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(54, 162, 235, 0.2)'
            ],
            borderColor: [
            'rgb(255, 99, 132)',
            'rgb(255, 159, 64)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(54, 162, 235)'
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
        indexAxis: 'y',
        scales: {
            x: {
                beginAtZero: true
            }
        }
    }
});

jQuery(function($){
    const weeklySales = {
        target: 70000,          // Your target number
        element: '#weeklySales', // Display selector
        duration: 2000,         // Animation duration (ms)
        prefix: '$',            // Optional prefix
        suffix: '',             // Optional suffix
        separator: ',',         // Thousand separator
        decimals: 0,            // Decimal places
        easing: 'linear'        // Easing function
      };

      const monthlySales = {
        target: 100000,          // Your target number
        element: '#monthlySales', // Display selector
        duration: 2000,         // Animation duration (ms)
        prefix: '$',            // Optional prefix
        suffix: '',             // Optional suffix
        separator: ',',         // Thousand separator
        decimals: 0,            // Decimal places
        easing: 'linear'        // Easing function
      };

      const yearlySales = {
        target: 10000000,          // Your target number
        element: '#yearlySales', // Display selector
        duration: 2000,         // Animation duration (ms)
        prefix: '$',            // Optional prefix
        suffix: '',             // Optional suffix
        separator: ',',         // Thousand separator
        decimals: 0,            // Decimal places
        easing: 'linear'        // Easing function
      };
      
      animateCounter(weeklySales);
      animateCounter(monthlySales);
      animateCounter(yearlySales);
});


function animateCounter(opts) {
    const $el = $(opts.element);
    let startTimestamp = null;
    
    const step = (timestamp) => {
      if (!startTimestamp) startTimestamp = timestamp;
      const progress = Math.min((timestamp - startTimestamp) / opts.duration, 1);
      
      // Apply easing if needed
      const easedProgress = opts.easing === 'linear' ? progress : 
                           Math.sin(progress * Math.PI/2); // easeOutSine example
      
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
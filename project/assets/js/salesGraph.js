
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
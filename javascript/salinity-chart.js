var chart;

function renderChart(timeFrame) {
    let categories = [];
    let temperatures = [];

    // Fetch data from the server
    fetch(`getDataTemp.php?timeFrame=${timeFrame}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }

            categories = data.categories;
            temperatures = data.temperatures;

            // Update chart options
            const options = {
                series: [{
                    name: "Temperature",
                    data: temperatures
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: { enabled: false }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth' },
                title: { text: 'Salinity Analytics', align: 'left' },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'],
                        opacity: 0.5
                    }
                },
                xaxis: { 
                    categories: categories,
                    labels: {
                        rotate: -45, // Optional: rotates the labels for better visibility
                        style: {
                            fontSize: '12px',
                            fontWeight: 'bold',
                        }
                    }
                },
                yaxis: {
                    min: 0,
                    max: 40, // Adjust the max value based on typical temperature ranges
                    title: { text: 'Salinity (ppt)' },
                    labels: { formatter: value => value.toFixed(2) }
                },
                tooltip: {
                    y: {
                        formatter: function (value) {
                            return `${value.toFixed(2)} °C`; // Format the tooltip value
                        }
                    }
                }
            };

            // Destroy existing chart before rendering a new one
            if (chart) {
                chart.destroy();
            }

            // Create and render the chart
            chart = new ApexCharts(document.querySelector("#line-chart"), options);
            chart.render();
        })
        .catch(error => console.error("Error fetching data:", error));
}

// Call renderChart with the default time frame (7D) when the page loads
renderChart('7D');

// Add event listeners for time frame buttons
document.querySelector('.btn-24h-header').addEventListener('click', () => renderChart('24H'));
document.querySelector('.btn-7D-header').addEventListener('click', () => renderChart('7D'));
document.querySelector('.btn-1M-header').addEventListener('click', () => renderChart('1M'));
document.querySelector('.btn-3M-header').addEventListener('click', () => renderChart('3M'));
document.querySelector('.btn-1Y-header').addEventListener('click', () => renderChart('1Y'));

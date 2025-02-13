/*var chart;

function renderChart(timeFrame) {
    let categories = [];
    let phLevels = [];

    // Fetch data from the server
    fetch(`getData.php?timeFrame=${timeFrame}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }

            categories = data.categories;
            phLevels = data.phLevels;

            // Update chart options
            const options = {
                series: [{
                    name: "pH Levels",
                    data: phLevels
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: { enabled: false }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth' },
                title: { text: 'pH Analytics', align: 'left' },
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
                    max: 15,
                    title: { text: 'pH Level' },
                    labels: { formatter: value => value.toFixed(2) }
                },
                tooltip: {
                    y: {
                        formatter: function (value) {
                            return `${value.toFixed(2)} pH`; // Format the tooltip value
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
*/ 

var chart;

function renderChart(timeFrame) {
    let categories = [];
    let phLevels = [];

    // Fetch data from the server
    fetch(`getDataPh.php?timeFrame=${timeFrame}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }

            categories = data.categories; // For '1M', these will be 4-day intervals
            phLevels = data.phLevels; // Corresponding average pH levels

            // Update chart options
            const options = {
                series: [{
                    name: "pH Levels",
                    data: phLevels
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: { enabled: false }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth' },
                title: { text: 'pH Analytics', align: 'left' },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'],
                        opacity: 0.5
                    }
                },
                xaxis: { 
                    categories: categories, // 4-day intervals for '1M'
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
                    max: 15,
                    title: { text: 'pH Level' },
                    labels: { formatter: value => value.toFixed(2) }
                },
                tooltip: {
                    y: {
                        formatter: function (value) {
                            return `${value.toFixed(2)} pH`; // Format the tooltip value
                        }
                    }
                }
            };

            // Destroy existing chart before rendering a new one
            if (chart) {
                chart.destroy();  
            }

            // Create and render the chart
            chart = new ApexCharts(document.querySelector("#predict-chart"), options);
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

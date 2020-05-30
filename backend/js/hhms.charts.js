jQuery(document).ready(function($) {
    // =============================================
    // Payments Chart
    var salesChartCanvas  = $('#salesChart').get(0).getContext('2d');
    var salesChartOptions = {
        maintainAspectRatio : false,
        responsive : true,
        legend: {
            display: true
        },
        scales: {
            xAxes: [{
                gridLines : {
                    display : false,
                }
            }],
            yAxes: [{
                gridLines : {
                    display : false,
                }
            }]
        }
    }

    // This will get the first returned node in the jQuery collection.
    var salesChart = new Chart(salesChartCanvas, { 
        type: 'line', 
        data: salesChartData, 
        options: salesChartOptions
    }); 
    // Payments Chart
    // =============================================

 
    // =============================================
    // Next week bookings Chart

    var nextWeekChartCanvas = $('#next_weekChart').get(0).getContext('2d')

    var nextWeekChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    var nextWeekChart = new Chart(nextWeekChartCanvas, {
      type: 'bar', 
      data: nextWeekChartData,
      options: nextWeekChartOptions
    })
    // Next week bookings Chart
    // =============================================
});

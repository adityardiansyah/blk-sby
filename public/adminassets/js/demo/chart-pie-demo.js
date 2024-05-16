// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

var baseUrl = $('meta[name="base-url"]').attr('content')
   // Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
   type: 'pie',
   data: {
      labels: ["Belum Bekerja", "Sudah Bekerja", "Wirausaha", "Melanjutkan"],
      datasets: [{
         data: [0, 0, 0, 0],
         backgroundColor: ['#e74a3b', '#1cc88a', '#36b9cc', '#4e73df'],
         hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#07c'],
         hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
   },
   options: {
      maintainAspectRatio: false,
      tooltips: {
         backgroundColor: "rgb(255,255,255)",
         bodyFontColor: "#858796",
         borderColor: '#dddfeb',
         borderWidth: 1,
         xPadding: 15,
         yPadding: 15,
         displayColors: false,
         caretPadding: 10,
      },
      legend: {
         display: false
      },
      cutoutPercentage: 80,
   },
});
let pieStatus = [];
let pieTotals = [];
let pieYear = null;

ajaxPie(pieYear);
$('.filterPieYear').on('click', function() {
   pieYear = $(this).text();
   ajaxPie(pieYear);
})

function ajaxPie() {
   $.ajax({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: baseUrl + '/admin/dashboard' + '/get-data-pie-chart',
      type: 'GET',
      data: { year: pieYear },
      success: function(responses) {
         if (responses.length === 0) {
            Swal.fire({
               position: 'center',
               type: 'error',
               title: 'Gagal',
               text: "Tidak ada data pada tahun " + pieYear,
               showConfirmButton: false,
               timer: 2000,
            })
         }
         pieStatus = []
         pieTotals = []
         pieYear = null;
         $.each(responses, function(key, value) {
            pieStatus.push(value.status)
            pieTotals.push(value.total)
         })
         $('#titlePie').text('Status Alumni ' + responses[0].year)

         updateChart(myPieChart, pieStatus, pieTotals)
      },
      error: function(exception) {
         Swal.fire({
            position: 'center',
            type: 'error',
            title: 'Gagal',
            text: "Gagal memuat data chart",
            showConfirmButton: false,
            timer: 2000,
         })
      }
   });
}

function updateChart(myPieChart, pieStatus, pieTotals) {
   let data = {
      labels: pieStatus,
      datasets: [{
         data: pieTotals,
         backgroundColor: ['#e74a3b', '#1cc88a', '#36b9cc', '#4e73df'],
         hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#07c'],
         hoverBorderColor: "rgba(234, 236, 244, 1)",
      }]
   }
   myPieChart.data.labels = data.labels;
   myPieChart.data.datasets = data.datasets;
   myPieChart.update()
}
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["Open", "Pending","Resolved", "Closed"],
    datasets: [{
      data: [openTicketCount, pendingTicketCount, resolvedTicketCount, closedTicketCount],
      // data: [openTicketCount, pendingTicketCount, resolvedTicketCount, closedTicketCount],
      backgroundColor: ['#4e73df', '#fca92b', '#1cc88a', '#ee3d3d'],
      hoverBackgroundColor: ['#4e73df', '#ff8a00','#1cc88a', '#ed0404'],
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

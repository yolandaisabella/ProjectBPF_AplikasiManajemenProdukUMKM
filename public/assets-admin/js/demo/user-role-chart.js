// User Role Pie Chart
var ctx = document.getElementById("userRoleChart");
if (ctx) {
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: userRoleLabels || ["Admin", "Staff", "Guest"],
            datasets: [{
                data: userRoleData || [1, 1, 1],
                backgroundColor: ['#e74a3b', '#f6c23e', '#36b9cc'],
                hoverBackgroundColor: ['#c0392b', '#e6b800', '#2c9faf'],
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
}

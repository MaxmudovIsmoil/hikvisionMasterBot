var ctx = document.getElementById('lineChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: "O'rnatishlar",
            data: [2050, 1900, 2100, 2800, 1800, 2000, 2500, 2600, 2450, 1950, 2300, 2900],
            backgroundColor: [
                'rgb(41, 155, 99)'

            ],
            borderColor: 'rgb(41, 155, 99)',

            borderWidth: 1
        },
            {
                label: 'Servislar',
                data: [2000, 1950, 2050, 2570, 1670, 2200, 2100, 2700, 2590, 1700, 2100, 2720],
                backgroundColor: [
                    'rgb(167, 75, 76, 1)'

                ],
                borderColor: 'rgb(167, 75, 76, 1)',

                borderWidth: 1
            }
            ]
    },
    options: {
        responsive: true
    }
});

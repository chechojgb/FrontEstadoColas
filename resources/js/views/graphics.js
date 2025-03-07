// document.addEventListener("DOMContentLoaded", function () {
//     console.log("Datos recibidos en el JS:", chartData);

//     if (typeof chartData === "string") {
//         chartData = JSON.parse(chartData);
//     }

//     Highcharts.chart('containerGraphics', {
//         chart: {
//             type: 'pie'
//         },
//         title: {
//             text: 'percentage of calls answered'
//         },
//         tooltip: {
//             valueSuffix: '%'
//         },
//         subtitle: {
//             text: 'Source:<a href="https://www.mdpi.com/2072-6643/11/3/684/htm" target="_default">MDPI</a>'
//         },
//         plotOptions: {
//             series: {
//                 allowPointSelect: true,
//                 cursor: 'pointer',
//                 dataLabels: [{
//                     enabled: true,
//                     distance: 20,
//                     format: '{point.name}: {point.y} ({point.percentage:.1f}%)'
//                 }, {
//                     enabled: true,
//                     distance: -40,
//                     format: '{point.percentage:.1f}%',
//                     style: {
//                         fontSize: '1.2em',
//                         textOutline: 'none',
//                         opacity: 0.7
//                     },
//                     filter: {
//                         operator: '>',
//                         property: 'percentage',
//                         value: 10
//                     }
//                 }]
//             }
//         },
//         series: [{
//             name: 'Percentage',
//             colorByPoint: true,
//             data: chartData
//         }]
//     });
// });



// document.addEventListener("DOMContentLoaded", function () {
//     console.log("Datos recibidos en el JS:", );

//     if (typeof chartDataTMO === "string") {
//         chartDataTMO = JSON.parse(chartDataTMO);
//     }


//     Highcharts.chart('containerGraphicsTMOandASA', {
//         chart: {
//             type: 'column'
//         },
//         title: {
//             text: 'Efficiency Optimization by Branch'
//         },
//         xAxis: {
//             categories: [
//                 'ASA',
//                 'TMO',
//                 'test'
//             ]
//         },
//         yAxis: [{
//             min: 0,
//             title: {
//                 text: 'Employees'
//             }
//         }, {
//             title: {
//                 text: 'Profit (millions)'
//             },
//             opposite: true
//         }],
//         legend: {
//             shadow: false
//         },
//         tooltip: {
//             shared: true
//         },
//         plotOptions: {
//             column: {
//                 grouping: false,
//                 shadow: false,
//                 borderWidth: 0
//             }
//         },
//         series: [{
//             name: 'Employees',
//             color: 'rgba(165,170,217,1)',
//             data: [150, 73, 20],
//             pointPadding: 0.3,

//         }, {
//             name: 'Employees Optimized',
//             color: 'rgba(126,86,134,.9)',
//             data: [140, 90, 40],
//             pointPadding: 0.4,
//         }]
//     });
    
// });
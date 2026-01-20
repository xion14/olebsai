"use strict";

let datasChartVsBudget = [
    {
        month: "January",
        sales: 3200,
        budget: 2207,
    },
    {
        month: "February",
        sales: 1800,
        budget: 3403,
    },
    {
        month: "March",
        sales: 4305,
        budget: 2207,
    },
    {
        month: "April",
        sales: 1200,
        budget: 5025,
    },
    {
        month: "May",
        sales: 6310,
        budget: 2302,
    },
    {
        month: "June",
        sales: 5120,
        budget: 4208,
    },
    {
        month: "July",
        sales: 4305,
        budget: 2207,
    },
    {
        month: "August",
        sales: 5880,
        budget: 4880,
    },
];
// impot

// var ctx = document.getElementById("myChart").getContext("2d");
// var myChart = new Chart(ctx, {
//     type: "line",
//     data: {
//         labels: datasChartVsBudget.map((data) => data.month),
//         datasets: [
//             {
//                 label: "Sales",
//                 data: datasChartVsBudget.map((data) => data.sales),
//                 borderWidth: 2,
//                 backgroundColor: "rgba(35,159,225,.8)",
//                 borderWidth: 0,
//                 borderColor: "transparent",
//                 pointBorderWidth: 0,
//                 pointRadius: 3.5,
//                 pointBackgroundColor: "transparent",
//                 pointHoverBackgroundColor: "rgba(35,159,225,.8)",
//             },
//             {
//                 label: "Budget",
//                 data: datasChartVsBudget.map((data) => data.budget),
//                 borderWidth: 2,
//                 backgroundColor: "rgba(134,205,243,.8)",
//                 borderWidth: 0,
//                 borderColor: "transparent",
//                 pointBorderWidth: 0,
//                 pointRadius: 3.5,
//                 pointBackgroundColor: "transparent",
//                 pointHoverBackgroundColor: "rgba(134,205,243,.8)",
//             },
//         ],
//     },
//     options: {
//         legend: {
//             display: false,
//         },
//         scales: {
//             yAxes: [
//                 {
//                     gridLines: {
//                         // display: false,
//                         drawBorder: false,
//                         color: "#f2f2f2",
//                     },
//                     ticks: {
//                         beginAtZero: true,
//                         stepSize: 1500,
//                         callback: function (value, index, values) {
//                             return "$" + value;
//                         },
//                     },
//                 },
//             ],
//             xAxes: [
//                 {
//                     gridLines: {
//                         display: false,
//                         tickMarkLength: 15,
//                     },
//                 },
//             ],
//         },
//     },
// });

var balance_chart = document.getElementById("balance-chart").getContext("2d");

var balance_chart_bg_color = balance_chart.createLinearGradient(0, 0, 0, 70);
balance_chart_bg_color.addColorStop(0, "rgba(63,82,227,.2)");
balance_chart_bg_color.addColorStop(1, "rgba(63,82,227,0)");

$.ajax({
    url: '/admin/get-chart-data-balance',
    method: 'GET',
    dataType: 'json',
    success: function (responseData) {
        const chartData = responseData.data;

        var myChart = new Chart(balance_chart, {
            type: "line",
            data: {
                labels: chartData.map((item) => item.month),
                datasets: [
                    {
                        label: "Balance",
                        data: chartData.map((item) => item.balance),
                        backgroundColor: balance_chart_bg_color,
                        borderWidth: 3,
                        borderColor: "rgba(35,159,225,1)",
                        pointBorderWidth: 0,
                        pointBorderColor: "transparent",
                        pointRadius: 3,
                        pointBackgroundColor: "transparent",
                        pointHoverBackgroundColor: "rgba(35,159,225,1)",
                    },
                ],
            },
            options: {
                layout: {
                    padding: {
                        bottom: -1,
                        left: -1,
                    },
                },
                legend: {
                    display: false,
                },
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            let value = tooltipItem.yLabel;
                            return 'IDR ' + value.toLocaleString('id-ID');
                        },
                    },
                },
                scales: {
                    yAxes: [
                        {
                            gridLines: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                beginAtZero: true,
                                display: false,
                            },
                        },
                    ],
                    xAxes: [
                        {
                            gridLines: {
                                drawBorder: false,
                                display: false,
                            },
                            ticks: {
                                display: false,
                            },
                        },
                    ],
                },
            },
        });
    },
    error: function (error) {
        console.error('Error fetching chart data:', error);
    },
});

var sales_chart = document.getElementById("sales-chart").getContext("2d");

var sales_chart_bg_color = sales_chart.createLinearGradient(0, 0, 0, 80);
balance_chart_bg_color.addColorStop(0, "rgba(63,82,227,.2)");
balance_chart_bg_color.addColorStop(1, "rgba(63,82,227,0)");

$.ajax({
    url: '/admin/get-chart-data-transaction',
    method: 'GET',
    dataType: 'json',
    success: function (responseData) {
        const chartData = responseData.data;

        var myChart = new Chart(sales_chart, {
            type: "line",
            data: {
                labels: chartData.map((data) => data.month), // ubah jadi "month"
                datasets: [
                    {
                        label: "Sales",
                        data: chartData.map((data) => data.transaction), // ubah jadi "transaction"
                        borderWidth: 2,
                        backgroundColor: balance_chart_bg_color,
                        borderWidth: 3,
                        borderColor: "rgba(35,159,225,1)",
                        pointBorderWidth: 0,
                        pointBorderColor: "transparent",
                        pointRadius: 3,
                        pointBackgroundColor: "transparent",
                        pointHoverBackgroundColor: "rgba(35,159,225,1)",
                    },
                ],
            },
            options: {
                layout: {
                    padding: {
                        bottom: -1,
                        left: -1,
                    },
                },
                legend: {
                    display: false,
                },
                scales: {
                    yAxes: [
                        {
                            gridLines: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                beginAtZero: true,
                                display: false,
                            },
                        },
                    ],
                    xAxes: [
                        {
                            gridLines: {
                                drawBorder: false,
                                display: false,
                            },
                            ticks: {
                                display: false,
                            },
                        },
                    ],
                },
            },
        });
    },
    error: function (error) {
        console.error('Error fetching transaction chart data:', error);
    },
});


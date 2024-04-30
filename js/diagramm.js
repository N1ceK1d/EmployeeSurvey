let colors = [
    '#00575c',
    '#1e616c',
    '#336c79',
    '#467783',
    '#598389',
    '#6a8f8c',
    '#7b9b8c',
    '#8ca889',
    '#9bb583',
    '#a9c37a',
    '#b6d16d',
    '#c2e05b',
    '#cdef41',
    '#ffebd1',
    '#ffd7c2',
    '#ffc2b2',
    '#ffaca3',
    '#fe9694',
    '#f88186',
    '#ef6d79',
    '#e5596d',
    '#d94561',
    '#cb3256',
    '#bb1e4c',
    '#a80a42',
    '#93003a',
];
function showDiagramm(php_data, id, username, company_name = 'Компания', answers) {
    console.log(php_data.map(row => row.count));
    new Chart(
        document.querySelector(`.diagramm-item #myChart${id}`),
        {
            type: 'pie',
            data: {
                labels: answers,
                datasets: [{
                    label: username,
                    data: php_data.map(row => row.percentage),
                    backgroundColor: php_data.map(row => colors[php_data.indexOf(row)]),
                }]
            },
            options: {
                legend: {
                    display: true,
                    labels: {
                        fontColor: "black",
                    }
                },
                title: {
                    display: true,
                    text: company_name,
                },
                events: false,
                animation: {
                    duration: 500,
                    easing: "easeOutQuart",
                    onComplete: function () {
                        var ctx = this.chart.ctx;
                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';

                        this.data.datasets.forEach(function (dataset) {
                            for (var i = 0; i < dataset.data.length; i++) {
                                var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                                    total = dataset._meta[Object.keys(dataset._meta)[0]].total,
                                    mid_radius = model.innerRadius + (model.outerRadius - model.innerRadius) / 2,
                                    start_angle = model.startAngle,
                                    end_angle = model.endAngle,
                                    mid_angle = start_angle + (end_angle - start_angle) / 2;

                                var x = mid_radius * Math.cos(mid_angle);
                                var y = mid_radius * Math.sin(mid_angle);

                                ctx.fillStyle = '#fff';
                                if (i == 3) { // Darker text color for lighter background
                                    ctx.fillStyle = '#444';
                                }

                                var val = dataset.data[i];
                                var percent = String(Math.round(val / total * 100)) + "%";

                                if (val != 0) {
                                    ctx.fillText(dataset.data[i] + "%", model.x + x, model.y + y);
                                    // Display percent in another line, line break doesn't work for fillText
                                    ctx.fillText(percent, model.x + x, model.y + y + 15);
                                }
                            }
                        });
                    }
                }
            }
        });
}

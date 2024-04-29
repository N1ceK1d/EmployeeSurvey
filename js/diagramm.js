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
            },]
        },
        options: {
            legend: {display: true},
            title: {
                display: true,
                text: company_name,
            },
            colors: {
                enabled: false
            }
        }
    });
}
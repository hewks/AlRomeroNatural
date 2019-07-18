var moduleName = 'Compras';
var NominaChart = new BsChart;

document.addEventListener("DOMContentLoaded", function (event) {
    tableSection();
    NominaChart.requestChartData('buy_register', 'year', 'bs-buy-chart');
});

document.getElementById('bs-send-form-button').addEventListener('click', e => {

    e.preventDefault();

    validateFormOptions = {
        validateTwoPass: false,
        moduleTitle: moduleName,
        sendForm: true,
        passwordHash: false
    };

    sendFormOtions = {
        moduleTitle: moduleName,
        sendFormUrl: base_url + 'BackOffice/' + moduleName + '/add',
        redirectUrl: false,
        sendImages: false,
    }

    validateForm(validateFormOptions, sendFormOtions);
    tableSection();

});

setInterval(function () {
    NominaChart.requestChartData('buy_register', 'year', 'bs-buy-chart');
}, 10000);

function tableSection() {
    var tableColumns = ['id', 'product', 'quantity', 'unity', 'total', 'date', 'user'];
    var dataTableColumns = [];

    tableColumns.forEach(column => {
        dataTableColumns.push({ data: column });
    });

    var requestOptions = {
        requestUrl: 'BackOffice/' + moduleName + '/data_table',
        moduleName: moduleName,
        requestType: 'all',
        requestContentType: 'application/x-www-form-urlencoded',
        fillTable: true,
        tableColumns: dataTableColumns,
        fillSelects: true
    }

    requestTableData(requestOptions);
}
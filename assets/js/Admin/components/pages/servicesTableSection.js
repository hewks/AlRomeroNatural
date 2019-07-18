var moduleName = 'Servicios';
var NominaChart = new BsChart;

document.addEventListener("DOMContentLoaded", function (event) {
    tableSection();
    NominaChart.requestChartData('service_payment', 'year', 'bs-services-chart');
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
    NominaChart.requestChartData('service_payment', 'year', 'bs-services-chart');
}, 10000);

function tableSection() {
    var tableColumns = ['id', 'service', 'price', 'status', 'actions'];
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
        tableColumns: dataTableColumns
    }

    requestTableData(requestOptions);
}

function editSection() {

    validateFormOptions = {
        validateTwoPass: false,
        moduleTitle: moduleName,
        sendForm: true,
        passwordHash: false
    };

    sendFormOtions = {
        moduleTitle: moduleName,
        sendFormUrl: base_url + 'BackOffice/' + moduleName + '/edit',
        redirectUrl: false,
        sendImages: false,
    }

    validateForm(validateFormOptions, sendFormOtions, '#editModal .bs-admin-input');
    tableSection();

}

function requestEditData(moduleName, id) {
    var request = new XMLHttpRequest();

    var postData = 'requestType=one&id=' + id;

    request.open("POST", base_url + 'BackOffice/' + moduleName + '/data_table');
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(postData);

    request.onreadystatechange = () => {
        if (request.readyState == 200 || request.readyState == 4) {
            var requestResponse = JSON.parse(request.responseText);
            if (requestResponse[0]['status'] == true) {
                fillEditModal(requestResponse[1]['tableData']);
            } else {
                PNotify.error({
                    title: moduleName,
                    text: requestResponse[0]['response']
                });
            }
        }
    }
}

function fillEditModal(data) {
    var editForm = document.querySelectorAll('#editModal .bs-admin-input');
    editForm.forEach(input => {
        switch (input.name) {
            case 'service': input.value = data.service; break;
            case 'price': input.value = data.price; break;
            case 'status': input.value = data.status; break;
            case 'id': input.value = data.id; break;
        }
    });
    $('#editModal').modal();
}
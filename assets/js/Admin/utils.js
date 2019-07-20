// Validar email
function validateEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email) ? true : false;
}

function validatePassword(password) {
    return (password == null || password == '') ? false : true;
}

function validateText(text) {
    return (text == null || text == '') ? false : true;
}

function getUrlParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

// Send and validate forms

function validateForm(validateFormOptions, sendFormOtions, otherForm = null) {

    var form;
    if (otherForm == null) {
        form = document.querySelectorAll('#bs-send-form .bs-form-input');
        if (form.length == 0) {
            form = document.querySelectorAll('#bs-send-form .bs-admin-input');
        }
    } else {
        form = document.querySelectorAll(otherForm);
    }

    var errForm = [];
    var formData = [];
    var errorList = '';

    var formPasswords = {
        'passwordOne': null,
        'passwordTwo': null,
    };

    form.forEach(input => {
        switch (input.type) {
            case 'password':
                if (validatePassword(input.value) == false) { errForm.push(input.dataset.name) }
                else if (input.id != 'passwordTwo') {
                    if (validateFormOptions.passwordHash) {
                        formData.push({ 'name': input.name, 'value': md5(input.value) })
                    } else {
                        formData.push({ 'name': input.name, 'value': input.value })
                    }
                }
                break;
            case 'email':
                if (validateEmail(input.value) == false) { errForm.push(input.dataset.name) }
                else { formData.push({ 'name': input.name, 'value': input.value }) }
                break;
            default:
                if (validateText(input.value) == false) { errForm.push(input.dataset.name) }
                else { formData.push({ 'name': input.name, 'value': input.value }) }
                break;
        }
    });


    if (validateFormOptions.validateTwoPass == true) {
        formPasswords.passwordOne = document.getElementById('passwordOne').value;
        formPasswords.passwordTwo = document.getElementById('passwordTwo').value;
        if (formPasswords.passwordOne != formPasswords.passwordTwo) {
            errForm.push('Las contraseñas son distintas');
        }
    }

    if (errForm.length > 0) {

        errForm.forEach(error => { errorList += error + '\n' });
        PNotify.error({
            title: 'Debes llenar todos los campos',
            text: errorList
        });
    } else {
        if (validateFormOptions.sendForm == true) {
            sendFormData(sendFormOtions, formData);
        } else {
            PNotify.error({
                title: 'Validacion',
                text: 'El formulario se valido correctamente'
            });
        }
    }
}

function sendFormData(sendFormOtions, formData) {

    var request = new XMLHttpRequest();
    var dataObj = new FormData();

    formData.forEach(data => {
        dataObj.append(data.name, data.value);
    });

    if (sendFormOtions.sendImages) {
        var fileInput = sendFormOtions.fileInput;
        dataObj.append('image', fileInput.files[0])
        $.ajax({
            url: sendFormOtions.sendFormUrl,
            type: 'POST',
            contentType: false,
            data: dataObj,
            processData: false,
            cache: false,
            success: (response) => {
                if (response[0]['status'] == true) {
                    PNotify.success({
                        title: sendFormOtions.moduleTitle,
                        text: response[0]['response']
                    });
                } else {
                    PNotify.error({
                        title: sendFormOtions.moduleTitle,
                        text: response[0]['response']
                    });
                }
            }
        });
    } else {

        request.open("POST", sendFormOtions.sendFormUrl);
        request.send(dataObj);

        request.onreadystatechange = () => {
            if (request.readyState == 200 || request.readyState == 4) {
                var requestResponse = JSON.parse(request.responseText);
                if (requestResponse[0]['status'] == true) {
                    if (sendFormOtions.redirectUrl != false) {
                        window.location.href = sendFormOtions.redirectUrl;
                    } else {
                        PNotify.success({
                            title: sendFormOtions.moduleTitle,
                            text: requestResponse[0]['response']
                        });
                    }
                } else {
                    PNotify.error({
                        title: sendFormOtions.moduleTitle,
                        text: requestResponse[0]['response']
                    });
                }
            }
        }
    }
}

///////////////////////////////////////////
// Tables
///////////////////////////////////////////

function fillTable(tableData, dataTableColumns) {
    var customerTable = $('#tableSectionTable').DataTable();
    customerTable.destroy();
    var customerTable = $('#tableSectionTable').DataTable({
        data: tableData.tableData,
        columns: dataTableColumns
    });
}

function fillSelects(selectsData) {
    var selects = document.querySelectorAll('.' + selectsData['selects']);
    var data = selectsData['data'];

    selects.forEach(function (select) {
        select.innerHTML = '';
    });

    switch (selectsData['selects']) {
        case 'productSelect':
            selects.forEach(function (select) {
                data.forEach(function (selectOption) {
                    select.innerHTML += '<option value="' + selectOption.id + '">' + selectOption.product_name + ' ||||| Stock: ' + selectOption.stock + '</option>';
                });
            });
            break;
        case 'categoriesSelect':
            selects.forEach(function (select) {
                data.forEach(function (selectOption) {
                    select.innerHTML += '<option value="' + selectOption.id + '">' + selectOption.category + '</option>';
                });
            });
            break;
    }
}

function requestTableData(requestOptions) {
    var postUrlDataTable = requestOptions.requestUrl;
    var req = new XMLHttpRequest();
    var postData = 'requestType=' + requestOptions.requestType;
    req.open('POST', base_url + postUrlDataTable, true);
    req.setRequestHeader('Content-Type', requestOptions.requestContentType);
    req.send(postData);
    req.onreadystatechange = function () {
        if (req.readyState == 4 || req.readyState == 200) {
            var sectionData = JSON.parse(req.responseText);
            if (sectionData[0]['status'] == true) {
                if (requestOptions.fillTable == true) {
                    fillTable(sectionData[1], requestOptions.tableColumns);
                    if (requestOptions.fillSelects == true) {
                        fillSelects(sectionData[1]['selectData']);
                    }
                } else {
                    PNotify.info({
                        title: moduleName,
                        text: sectionData[0]['response']
                    });
                }
            } else {
                PNotify.error({
                    title: moduleName,
                    text: sectionData[0]['response']
                });
            }
        }
    }
}

///////////////////////////////////////////
// Table Buttons
///////////////////////////////////////////

function sectionAction(moduleName, id, action) {

    var postUrlDataTable = 'BackOffice/' + moduleName + '/' + action;
    var req = new XMLHttpRequest();
    var postData = 'id=' + id;
    req.open('POST', base_url + postUrlDataTable, true);
    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    req.send(postData);
    req.onreadystatechange = function () {
        if (req.readyState == 4 || req.readyState == 200) {
            var sectionData = JSON.parse(req.responseText);
            if (sectionData[0]['status'] == true) {
                tableSection();
                PNotify.success({
                    title: moduleName,
                    text: sectionData[0]['response']
                });
            } else {
                PNotify.error({
                    title: moduleName,
                    text: sectionData[0]['response']
                });
            }
        }
    }

}

///////////////////////////////////////////
// Chart Class
///////////////////////////////////////////

class BsChart {

    createChart(newChartData, newChartLabels, chartId) {

        Chart.defaults.global.animationSteps = 50;
        Chart.defaults.global.tooltipYPadding = 16;
        Chart.defaults.global.tooltipCornerRadius = 4;
        Chart.defaults.global.tooltipTitleFontStyle = "normal";
        Chart.defaults.global.tooltipFillColor = "rgba(50,160,200,0.8)";
        Chart.defaults.global.animationEasing = "easeOutBounce";
        Chart.defaults.global.responsive = true;
        Chart.defaults.global.scaleLineColor = "black";
        Chart.defaults.global.scaleFontSize = 16;

        var lineChartData = {
            labels: newChartLabels,
            datasets: [{
                fillColor: "rgba(151,187,205,0)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                data: newChartData
            }]

        }

        if (window.LineChart) {
            window.LineChart.destroy();
        }

        var ctx = document.getElementById(chartId).getContext("2d");
        window.LineChart = new Chart(ctx).Line(lineChartData, {
            bezierCurve: false,
        });

    }

    refactChartData(chartData, time, bsChartId) {

        var min = 1;
        var max = 0;
        var newChartData = [];
        var newChartLabels = [];

        switch (time) {
            case 'month':
                max = 31;
                break;
            case 'year':
                max = 12;
        }

        for (var count = min; count <= max; count++) {
            newChartData[count - 1] = 0;
            newChartLabels[count - 1] = count;
        }

        chartData.forEach(function (data) {
            for (var count = min; count <= max; count++) {
                if (count == data.month) {
                    newChartData[count - 1] += parseInt(data.price);
                }
            }
        });

        this.createChart(newChartData, newChartLabels, bsChartId);

    }

    requestChartData(table, time, bsChartId) {
        var request = new XMLHttpRequest();

        var postData = 'requestType=chart&table=' + table + '&time=' + time;

        request.open("POST", base_url + 'BackOffice/' + moduleName + '/data_table');
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.send(postData);

        request.onreadystatechange = () => {
            if (request.readyState == 200 || request.readyState == 4) {
                var requestResponse = JSON.parse(request.responseText);
                if (requestResponse[0]['status'] == true) {
                    this.refactChartData(requestResponse[1]['chartData'], time, bsChartId);
                } else {
                    console.log(requestResponse[0]['response']);
                }
            }
        }
    }

}

var moduleName = 'Productos';

document.addEventListener("DOMContentLoaded", function (event) {
    tableSection();
});

document.getElementById('bs-send-form-button').addEventListener('click', e => {

    e.preventDefault();

    validateFormOptions = {
        validateTwoPass: false,
        moduleTitle: moduleName,
        sendForm: true,
        passwordHash: false,
        sendImages: true
    };

    sendFormOtions = {
        moduleTitle: moduleName,
        sendFormUrl: base_url + 'BackOffice/' + moduleName + '/add',
        redirectUrl: false,
        sendImages: true,
        fileInput: document.getElementById('bs-upload-create-file')
    }

    validateForm(validateFormOptions, sendFormOtions);
    tableSection();

});

function tableSection() {
    var tableColumns = ['id', 'product', 'category', 'price', 'lastBuy', 'discount', 'stock', 'status', 'actions'];
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

function editSection() {

    validateFormOptions = {
        validateTwoPass: false,
        moduleTitle: moduleName,
        sendForm: true,
        passwordHash: false,
        sendImages: true
    };

    sendFormOtions = {
        moduleTitle: moduleName,
        sendFormUrl: base_url + 'BackOffice/' + moduleName + '/edit',
        redirectUrl: false,
        sendImages: true,
        fileInput: document.getElementById('bs-upload-edit-file')
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
    var imageEdit = document.getElementById('bs-image-edit');
    imageEdit.style.backgroundImage = 'url(\'' + base_url + 'assets/images/productos/' + data.image_url + '\')';
    console.log(imageEdit);
    editForm.forEach(input => {
        switch (input.name) {
            case 'product': input.value = data.product_name; break;
            case 'category': input.value = data.category_id; break;
            case 'price': input.value = data.price; break;
            case 'discount': input.value = data.discount; break;
            case 'stock': input.value = data.stock; break;
            case 'largeDescription': input.value = data.large_description; break;
            case 'shortDescription': input.value = data.short_description; break;
            case 'status': input.value = data.status; break;
            case 'id': input.value = data.id; break;
        }
    });
    $('#editModal').modal();
}

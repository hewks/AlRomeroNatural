document.getElementById('bs-send-form-button').addEventListener('click', e => {

    e.preventDefault();

    moduleTitle = 'Ingreso';

    validateFormOptions = {
        validateTwoPass: false,
        moduleTitle: moduleTitle,
        sendForm: true,
        passwordHash: true
    };

    sendFormOtions = {
        moduleTitle: moduleTitle,
        sendFormUrl: base_url + 'Admin/validate',
        redirectUrl: base_url + 'BackOffice/Administradores',
        sendImages: false,        
    }

    validateForm(validateFormOptions, sendFormOtions);

});
document.getElementById('bs-send-form-button').addEventListener('click', e => {

    e.preventDefault();

    moduleTitle = 'Registro';

    validateFormOptions = {
        validateTwoPass: true,
        moduleTitle: moduleTitle,
        sendForm: true,
        passwordHash: true
    };

    sendFormOtions = {
        moduleTitle: moduleTitle,
        sendFormUrl: base_url + 'Admin/create',
        redirectUrl: false,
        sendImages: false
    }

    validateForm(validateFormOptions, sendFormOtions);

});


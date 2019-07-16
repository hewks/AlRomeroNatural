addMultiFormSelector();

// Send Forms

var loginForm = document.querySelectorAll('#hw-login-form .hw-form-input');
var registerForm = document.querySelectorAll('#hw-register-form .hw-form-input');

var sendFormButton = document.querySelectorAll('.hw-send-form');

sendFormButton.forEach((button) => {
    button.addEventListener('click', (e) => {
        e.preventDefault();
        var form = document.querySelectorAll('#' + button.dataset.send + ' .hw-form-input');
        var sendOptions = {}
        if (button.dataset.send == 'hw-register-form') {
            sendOptions = {
                sendUrl: base_url + 'Users/email_register',
                sendPhotos: false,
                redirectUrl: false,
                validateTwoPass: true,
                hashPasswords: true,
            }
        } else if (button.dataset.send == 'hw-login-form') {
            sendOptions = {
                sendUrl: base_url + 'Users/email_login',
                sendPhotos: false,
                redirectUrl: base_url + 'Main',
                validateTwoPass: false,
                hashPasswords: true,
            }
        }
        var sendForm = new HwForms(form, sendOptions);
        sendForm.sendForm();
    });
});

// Animate

var selectorButtons = document.querySelectorAll('.hw-btn-form-selector');
var forms = document.querySelectorAll('.hw-theme-user-form');

selectorButtons.forEach((button) => {
    button.addEventListener('click', () => {
        var activeButton = document.querySelector('.hw-active-selector');
        activeButton.classList.remove('hw-active-selector');
        button.classList.add('hw-active-selector');
        forms.forEach((form) => {
            form.classList.remove('hw-active-form');
        });
        document.getElementById(button.dataset.form).classList.add('hw-active-form');
    });
});

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
                redirectUrl: base_url + 'Users',
                validateTwoPass: true,
            }
        } else if (button.dataset.send == 'hw-login-form') {
            sendOptions = {
                sendUrl: base_url + 'Users/email_login',
                sendPhotos: false,
                redirectUrl: base_url + 'Main',
                validateTwoPass: false,
            }
        }
        var sendForm = new HwForms(form, sendOptions);
        sendForm.sendForm();
    });
});

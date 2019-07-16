addMultiFormSelector();

// Send Forms

var editForm = document.querySelectorAll('#hw-edit-form .hw-form-input');
var passwordForm = document.querySelectorAll('#hw-password-form .hw-form-input');

var sendFormButton = document.querySelectorAll('.hw-send-form');

sendFormButton.forEach((button) => {
    button.addEventListener('click', (e) => {
        e.preventDefault();
        var form = document.querySelectorAll('#' + button.dataset.send + ' .hw-form-input');
        var sendOptions = {}
        if (button.dataset.send == 'hw-edit-form') {
            sendOptions = {
                sendUrl: base_url + 'Users/edit_user',
                sendPhotos: false,
                redirectUrl: false,
                validateTwoPass: false,
                hashPasswords: false,
                reloadUrl: true,
            }
        } else if (button.dataset.send == 'hw-password-form') {
            sendOptions = {
                sendUrl: base_url + 'Users/change_password',
                sendPhotos: false,
                redirectUrl: false,
                validateTwoPass: true,
                hashPasswords: true,
                reloadUrl: false,
            }
        }
        var sendForm = new HwForms(form, sendOptions);
        sendForm.sendForm();
    });
});

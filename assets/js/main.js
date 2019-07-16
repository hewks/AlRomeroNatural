//////////////////////////////////////
// Navigation
//////////////////////////////////////

document.getElementById('hw-navigation-toggler').addEventListener('click', () => {
    var sidebar = document.getElementById('hw-primary-sidebar');
    if (sidebar.classList.contains('hw-active-sidebar')) {
        sidebar.classList.remove('hw-active-sidebar-2');
        setTimeout(() => {
            sidebar.classList.remove('hw-active-sidebar');
        }, 500);
    } else {
        sidebar.classList.add('hw-active-sidebar');
        setTimeout(() => {
            sidebar.classList.add('hw-active-sidebar-2');
        }, 500);
    }
});

//////////////////////////////////////
// User exit
//////////////////////////////////////

var exitButtons = document.querySelectorAll('.hw-exit-button');
exitButtons.forEach((button) => {
    button.addEventListener('click', () => {
        userExit();
    });
});

function userExit() {
    var request = new XMLHttpRequest();
    request.open("POST", base_url + 'Users/user_exit');
    request.send();
    request.onreadystatechange = () => {
        if (request.readyState == 200 || request.readyState == 4) {
            var requestResponse = JSON.parse(request.responseText);
            if (requestResponse[0]['status'] == true) {
                location.reload();
            }
        }
    }
}

//////////////////////////////////////
// Utils
//////////////////////////////////////

// Forms

class HwForms {

    // Form options theme
    //
    // sendUrl: base_url + 'Users', Url
    // sendPhotos: false, Bool
    // redirectUrl: base_url + 'Users', Url
    // validateTwoPass: true, Bool
    // hashPasswords: true, Bool

    constructor(form, formOptions) {
        this.formOptions = formOptions;
        this.form = form;
    }

    validateEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email) ? true : false;
    }

    validateTwoPass() {
        return (document.getElementById('password_1').value == document.getElementById('password_2').value) ? true : false;
    }

    validateForm() {
        var errors = []
        if (this.formOptions['validateTwoPass'] == true) {
            if (!this.validateTwoPass()) {
                PNotify.error({
                    title: ':(',
                    text: 'Las Contraseñas no coinciden',
                    icon: 'fab fa-wpforms'
                });
                return false;
            }
        }
        this.form.forEach((input) => {
            if (input.type == 'email') {
                if (!this.validateEmail(input.value)) {
                    errors.push(input)
                }
            } else if (input.type == 'password') {
                if (input.value == '') {
                    errors.push(input)
                }
            } else {
                if (input.value == '') {
                    errors.push(input)
                }
            }
        });
        if (errors.length > 0) {
            var errorList = '';
            errors.forEach((error) => {
                errorList += error.dataset.name + '\n';
            });
            // Change to pnotify
            PNotify.error({
                title: 'Debes llenar todos los campos:',
                text: errorList,
                icon: 'fab fa-wpforms'
            });
            errors[0].focus();
            return false;
        } else {
            return true;
        }
    }

    sendForm() {
        if (this.validateForm()) {
            var formData = new FormData();
            this.form.forEach((input) => {
                if (input.type == 'password' && this.formOptions.hashPasswords == true) {
                    formData.append(input.name, md5(input.value));
                } else {
                    formData.append(input.name, input.value);
                }
            });

            var request = new XMLHttpRequest();

            request.open("POST", this.formOptions.sendUrl);
            request.send(formData);

            request.onreadystatechange = () => {
                if (request.readyState == 200 || request.readyState == 4) {
                    var requestResponse = JSON.parse(request.responseText);
                    if (requestResponse[0]['status'] == true) {
                        if (this.formOptions.redirectUrl != false) {
                            location.href = this.formOptions.redirectUrl;
                        } else {
                            PNotify.success({
                                title: 'AlRomeroNatural',
                                text: requestResponse[0]['response'],
                                icon: 'fab fa-wpforms'
                            });
                        }
                    } else {
                        PNotify.error({
                            title: 'AlRomeroNatural',
                            text: requestResponse[0]['response'],
                            icon: 'fab fa-wpforms'
                        });
                    }
                }
            }
        }
    }

}
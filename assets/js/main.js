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

    constructor(form, formOptions) {
        this.formOtions = formOptions;
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
        if (this.formOtions['validateTwoPass'] == true) {
            if (!this.validateTwoPass()) {
                // Change to Pnotify
                alert('Las contraseñas no coinciden');
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
            alert(errorList);
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
                formData.append(input.name, input.value);
            });

            var request = new XMLHttpRequest();

            request.open("POST", this.formOtions.sendUrl);

            request.onreadystatechange = () => {
                if (request.readyState == 200 || request.readyState == 4) {
                    var requestResponse = JSON.parse(request.responseText);
                    if (requestResponse[0]['status'] == true) {

                    } else {
                        // Change to Pnotify
                        alert('Hubo un error en la consulta')
                    }
                }
            }
        }
    }

}
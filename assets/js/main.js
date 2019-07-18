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
    button.addEventListener('click', (e) => {
        e.preventDefault();
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
                location.href = base_url + 'Main';
            }
        }
    }
}

//////////////////////////////////////
// Multi Form
//////////////////////////////////////

function addMultiFormSelector() {
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
    // reloadUrl: true, Bool

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
                        } else if (this.formOptions.reloadUrl == true) {
                            location.reload();
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

//////////////////////////////////////
// Simple Slider
//////////////////////////////////////

class SimpleSliders {
    constructor(sliderId, sliderCount) {
        this.sliders = document.querySelectorAll('.hw-ss');
        this.sliderControls = document.querySelectorAll('.hw-simple-slider-control');
        this.sliderCount = sliderCount;
        this.sliderId = sliderId;
        this.slider = document.getElementById(sliderId);
        this.createPrincipalClass();
    }

    createInitSliders() {
        this.sliderCount.forEach((count) => {
            this.sliders[count].classList.add('hw-active-slider-' + (count + 1));
        });
    }

    activateSliders() {
        this.sliderControls.forEach((control) => {
            control.addEventListener('click', () => {
                this.sliderCount.forEach((count, index) => {
                    this.sliders[count].classList.remove('hw-active-slider-' + (index + 1));
                });
                this.sliderCount.forEach((count, index) => {
                    if (control.dataset.toggle == 'next') {
                        if (this.sliderCount[index] < this.sliders.length - 1) {
                            this.sliderCount[index] += 1;
                        } else {
                            this.sliderCount[index] = 0;
                        }
                    } else if (control.dataset.toggle == 'back') {
                        if (this.sliderCount[index] > 0) {
                            this.sliderCount[index] -= 1;
                        } else {
                            this.sliderCount[index] = this.sliders.length - 1;
                        }
                    }
                });
                this.sliderCount.forEach((count, index) => {
                    this.sliders[count].classList.add('hw-active-slider-' + (index + 1));
                });
                this.showCount();
            });
        });
    }

    createPrincipalClass() {
        switch (this.sliderCount.length) {
            case 2:
                this.slider.classList.add('hw-sl-50');
                break;
            case 3:
                this.slider.classList.add('hw-sl-33');
                break;
            case 4:
                this.slider.classList.add('hw-sl-25');
                break;
            case 5:
                this.slider.classList.add('hw-sl-20');
                break;
            case 6:
                this.slider.classList.add('hw-sl-16');
                break;
        }
    }

    showCount() {
        console.log(this.sliderCount);
    }
}
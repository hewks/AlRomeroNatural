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
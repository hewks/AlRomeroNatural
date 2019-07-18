// Creado por CtrlProgrammer
// Copyright (C) Derechos de autor Hewks.net

window.onload = function () {
    var loader = document.getElementById('bs-total-page-loader');
    loader.style.visibility = 'hidden';
    loader.style.opacity = '0';
}

//Toggle sidebar
document.getElementById('bs-sidebar-toggler-btn').addEventListener('click', function (e) {

    e.preventDefault();

    var sidebar = document.getElementById('bs-main-sidebar');
    if (sidebar.classList.contains('bs-active-sidebar')) {
        sidebar.classList.remove('bs-active-sidebar');
    } else {
        sidebar.classList.add('bs-active-sidebar');
    }

});


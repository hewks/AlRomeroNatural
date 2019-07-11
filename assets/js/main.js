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
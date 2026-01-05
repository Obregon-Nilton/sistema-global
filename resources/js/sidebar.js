// resources/js/sidebar.js
document.addEventListener('DOMContentLoaded', () => {
    const menuBtns = document.querySelectorAll('.menu-btn');

    menuBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const submenu = btn.nextElementSibling;

            // Cerrar todos los submenús primero
            document.querySelectorAll('.submenu').forEach(sm => {
                if (sm !== submenu) {
                    sm.classList.remove('open');
                }
            });

            // Alternar solo el submenú clickeado
            submenu.classList.toggle('open');
        });
    });
});

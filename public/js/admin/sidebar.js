document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('admin-sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const mobileToggle = document.getElementById('mobile-sidebar-toggle');

    const openSidebar = () => {
        sidebar.classList.add('is-open');
        overlay.classList.add('is-visible');
    };

    const closeSidebar = () => {
        sidebar.classList.remove('is-open');
        overlay.classList.remove('is-visible');
    };

    mobileToggle?.addEventListener('click', () => {
        sidebar.classList.contains('is-open') ? closeSidebar() : openSidebar();
    });

    overlay?.addEventListener('click', closeSidebar);

    // Submenu accordion (Berita, Produk)
    document.querySelectorAll('[data-submenu-toggle]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const key = btn.dataset.submenuToggle;
            const submenu = document.getElementById(`submenu-${key}`);
            const isOpen = submenu.classList.contains('is-open');

            document.querySelectorAll('.admin-nav-submenu.is-open').forEach((el) => {
                el.classList.remove('is-open');
                el.previousElementSibling?.classList.remove('admin-nav-link--open');
            });

            if (!isOpen) {
                submenu.classList.add('is-open');
                btn.classList.add('admin-nav-link--open');
            }
        });
    });
});

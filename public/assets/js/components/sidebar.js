
document.addEventListener('DOMContentLoaded', function () {

    const navParents = document.querySelectorAll('.nav-parent');

    navParents.forEach(function (button) {

        button.addEventListener('click', function () {

            const group = this.parentElement;
            const submenu = group.querySelector('.nav-children');

            // Close all other menus
            document.querySelectorAll('.nav-group').forEach(function (item) {

                if (item !== group) {
                    item.classList.remove('active');
                    item.querySelector('.nav-children').style.maxHeight = null;
                }

            });

            // Toggle current menu
            group.classList.toggle('active');

            if (group.classList.contains('active')) {

                submenu.style.maxHeight = submenu.scrollHeight + 'px';

            } else {

                submenu.style.maxHeight = null;

            }

        });

    });

});

// ---------------------------------
const mobileMenuToggle = document.getElementById('mobileMenuToggle');
const closeSidebarBtn = document.getElementById('closeSidebarBtn');
const sidebar = document.getElementById('sidebar');
const sidebarOverlay = document.getElementById('sidebarOverlay');

mobileMenuToggle.addEventListener('click', openSidebar);

closeSidebarBtn.addEventListener('click', closeSidebar);

sidebarOverlay.addEventListener('click', closeSidebar);

document.addEventListener('keydown', function (e) {

    if (e.key === 'Escape') {

        closeSidebar();

    }

});

document.querySelectorAll('.sidebar a').forEach(link => {

    link.addEventListener('click', function () {

        if (window.innerWidth <= 991) {

            closeSidebar();

        }

    });

});

window.addEventListener('resize', function () {

    if (window.innerWidth > 991) {

        closeSidebar();

    }

});

function openSidebar() {

    sidebar.classList.add('show');

    sidebarOverlay.classList.add('show');

    document.body.style.overflow = 'hidden';

}

function closeSidebar() {

    sidebar.classList.remove('show');

    sidebarOverlay.classList.remove('show');

    document.body.style.overflow = '';

}
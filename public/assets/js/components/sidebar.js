console.log('Sidebar JS Loaded');
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
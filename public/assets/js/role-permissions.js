let hasChanges = false;

document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('permissionForm');

    const searchInput = document.getElementById('permissionSearch');

    const saveBar = document.getElementById('permissionSaveBar');

    const saveButtons = [

        document.getElementById('savePermissionsBtn'),

        document.getElementById('savePermissionsFooterBtn')

    ];

    const selectAllBtn = document.getElementById('selectAllBtn');

    const clearAllBtn = document.getElementById('clearAllBtn');

    const cancelBtn = document.getElementById('cancelPermissionChanges');



    /*
    |--------------------------------------------------------------------------
    | Initial Setup
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.permission-checkbox')
        .forEach(function (checkbox) {

            const label = checkbox.closest('.permission-label');

            if (label) {

                label.classList.toggle('active', checkbox.checked);

            }

            checkbox.addEventListener('change', function () {

                const label = this.closest('.permission-label');

                if (label) {

                    label.classList.toggle('active', this.checked);

                }

                markChanged();

            });

        });



    document
        .querySelectorAll('.module-select-btn')
        .forEach(function (button) {

            button.addEventListener('click', function () {

                toggleModule(this);

            });

        });



    if (searchInput) {

        searchInput.addEventListener('keyup', searchPermissions);

    }



    if (selectAllBtn) {

        selectAllBtn.addEventListener('click', selectAllPermissions);

    }



    if (clearAllBtn) {

        clearAllBtn.addEventListener('click', clearAllPermissions);

    }



    if (cancelBtn) {

        cancelBtn.addEventListener('click', function () {

            location.reload();

        });

    }



    saveButtons.forEach(function (button) {

        button.addEventListener('click', savePermissions);

    });



    updateSelectedCount();

    updateModuleCounters();

    updateModuleButtons();





    /*
    |--------------------------------------------------------------------------
    | Save Permissions
    |--------------------------------------------------------------------------
    */

    async function savePermissions() {

        if (!hasChanges) {

            showToast(

                'No changes detected.',

                'info'

            );

            return;

        }

        const formData = new FormData(form);

        formData.append('_method', 'PUT');

        setSavingState(true);

        try {

            const response = await fetch(

                `/roles/${window.roleId}/permissions`,

                {

                    method: 'POST',

                    headers: {

                        'X-CSRF-TOKEN':

                            document
                                .querySelector('meta[name="csrf-token"]')
                                .content,

                        'Accept': 'application/json'

                    },

                    body: formData

                }

            );

            const data = await response.json();

            if (!response.ok) {

                showToast(

                    data.message ?? 'Unable to update permissions.',

                    'error'

                );

                return;

            }

            hasChanges = false;

            saveBar.classList.remove('show');

            showToast(

                data.message,

                'success'

            );

        }
        catch (error) {

            console.error(error);

            showToast(

                'An unexpected error occurred.',

                'error'

            );

        }
        finally {

            setSavingState(false);

        }

    }

});



/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

function markChanged() {

    hasChanges = true;

    document
        .getElementById('permissionSaveBar')
        .classList
        .add('show');

    updateSelectedCount();

    updateModuleCounters();

    updateModuleButtons();

}



function updateSelectedCount() {

    const total = document.querySelectorAll(

        '.permission-checkbox:checked'

    ).length;

    document.getElementById(

        'selectedPermissionCount'

    ).textContent = total;

    document.getElementById(

        'footerPermissionCount'

    ).textContent = total;

}



function updateModuleCounters() {

    document
        .querySelectorAll('.permission-card')
        .forEach(function (card) {

            const total =

                card.querySelectorAll(

                    '.permission-checkbox'

                ).length;

            const checked =

                card.querySelectorAll(

                    '.permission-checkbox:checked'

                ).length;

            card.querySelector('small').textContent =

                `${checked} / ${total} Selected`;

        });

}



function updateModuleButtons() {

    document
        .querySelectorAll('.permission-card')
        .forEach(function (card) {

            const total =

                card.querySelectorAll(

                    '.permission-checkbox'

                ).length;

            const checked =

                card.querySelectorAll(

                    '.permission-checkbox:checked'

                ).length;

            const button =

                card.querySelector('.module-select-btn');

            button.textContent =

                checked === total

                    ? 'Clear All'

                    : 'Select All';

        });

}



function toggleModule(button) {

    const card = button.closest('.permission-card');

    const checkboxes =

        card.querySelectorAll('.permission-checkbox');

    const allSelected =

        [...checkboxes].every(cb => cb.checked);

    checkboxes.forEach(function (checkbox) {

        checkbox.checked = !allSelected;

        const label = checkbox.closest('.permission-label');

        if (label) {

            label.classList.toggle(

                'active',

                !allSelected

            );

        }

    });

    markChanged();

}



function selectAllPermissions() {

    document
        .querySelectorAll('.permission-checkbox')
        .forEach(function (checkbox) {

            checkbox.checked = true;

            const label = checkbox.closest('.permission-label');

            if (label) {

                label.classList.add('active');

            }

        });

    markChanged();

}



function clearAllPermissions() {

    document
        .querySelectorAll('.permission-checkbox')
        .forEach(function (checkbox) {

            checkbox.checked = false;

            const label = checkbox.closest('.permission-label');

            if (label) {

                label.classList.remove('active');

            }

        });

    markChanged();

}



function searchPermissions() {

    const keyword = this.value.toLowerCase();

    document
        .querySelectorAll('.permission-module')
        .forEach(function (module) {

            let visible = false;

            module
                .querySelectorAll('.permission-item')
                .forEach(function (item) {

                    const match = item
                        .innerText
                        .toLowerCase()
                        .includes(keyword);

                    item.style.display =

                        match

                            ? ''

                            : 'none';

                    if (match) {

                        visible = true;

                    }

                });

            module.style.display =

                visible

                    ? ''

                    : 'none';

        });

}



function setSavingState(saving) {

    document
        .querySelectorAll(

            '#savePermissionsBtn,#savePermissionsFooterBtn'

        )
        .forEach(function (button) {

            button.disabled = saving;

            button.innerHTML = saving

                ? '<i class="bi bi-hourglass-split me-2"></i>Saving...'

                : '<i class="bi bi-check-circle me-2"></i>Save Changes';

        });

}
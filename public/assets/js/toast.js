function showToast(message, type = 'success')
{

    let icon = '';
    let bg = '';


    switch(type){

        case 'success':

            icon = 'bi-check-circle-fill';
            bg = 'bg-success';

        break;


        case 'error':
        case 'danger':

            icon = 'bi-x-circle-fill';
            bg = 'bg-danger';

        break;


        case 'warning':

            icon = 'bi-exclamation-triangle-fill';
            bg = 'bg-warning';

        break;


        case 'info':

            icon = 'bi-info-circle-fill';
            bg = 'bg-primary';

        break;

        default:

            icon = 'bi-info-circle-fill';
            bg = 'bg-primary';

        break;

    }



    let toast = `

        <div class="toast align-items-center text-white ${bg} border-0 mb-2"
             role="alert">

            <div class="d-flex">

                <div class="toast-body">

                    <i class="bi ${icon} me-2"></i>

                    ${message}

                </div>


                <button type="button"
                        class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast">

                </button>

            </div>

        </div>

    `;



    $('.toast-container')
        .append(toast);



    let toastElement =
        $('.toast-container .toast').last();



    let bsToast =
        new bootstrap.Toast(
            toastElement[0],
            {
                delay:4000
            }
        );


    bsToast.show();



    toastElement.on(
        'hidden.bs.toast',
        function(){

            $(this).remove();

        }
    );

}
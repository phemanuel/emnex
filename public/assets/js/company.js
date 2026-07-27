$(document).ready(function(){


    /*
    |--------------------------------------------------------------------------
    | Update Company Information
    |--------------------------------------------------------------------------
    */

    $('#editCompanyForm').submit(function(e){

        e.preventDefault();


        let form = this;


        $.ajax({

            url: $(form).attr('action'),

            method: 'POST',

            data: $(form).serialize(),

            beforeSend:function(){

                $('.btn-primary')
                .prop('disabled',true);

            },


            success:function(response){


                $('#editCompanyModal')
                    .modal('hide');


                showToast(
                    'Company information updated successfully',
                    'success'
                );


                setTimeout(function(){

                    location.reload();

                },800);


            },


            error:function(xhr){


                showToast(
                    'Unable to update company information',
                    'error'
                );


                console.log(xhr.responseText);


            },


            complete:function(){

                $('.btn-primary')
                .prop('disabled',false);

            }


        });


    });




    /*
    |--------------------------------------------------------------------------
    | Upload Company Logo
    |--------------------------------------------------------------------------
    */


    $('#companyLogoForm').submit(function(e){


        e.preventDefault();


        let formData = new FormData(this);



        $.ajax({


            url: $(this).attr('action'),


            method:'POST',


            data:formData,


            processData:false,


            contentType:false,


            beforeSend:function(){


                $('.btn-success')
                .prop('disabled',true);


            },


            success:function(response){


                $('#logoModal')
                    .modal('hide');



                showToast(
                    'Company logo updated successfully',
                    'success'
                );



                setTimeout(function(){

                    location.reload();

                },800);



            },


            error:function(xhr){


                showToast(
                    'Logo upload failed',
                    'error'
                );


                console.log(xhr.responseText);


            },


            complete:function(){


                $('.btn-success')
                .prop('disabled',false);


            }


        });


    });


});
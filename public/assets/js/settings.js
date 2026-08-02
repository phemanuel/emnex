
/*
|--------------------------------------------------------------------------
| EMNEX POS
| Settings Module
|--------------------------------------------------------------------------
*/


const Settings = {


    form: null,

    currency: null,

    currencySymbol: null,


    init(){


        this.cacheElements();


        this.bindEvents();


        this.loadCurrencySymbol();


    },



   cacheElements(){


    this.form = document.getElementById(
        'settingsForm'
    );


    this.currency = document.getElementById(
        'currency'
    );


    this.currencySymbol = document.getElementById(
        'currencySymbol'
    );


},

    bindEvents(){


    if(this.form){


        this.form.addEventListener(
            'submit',
            (e)=>{

                e.preventDefault();

                this.update();

            }
        );


    }





    if(this.currency){


        this.currency.addEventListener(
            'change',
            ()=>{


                this.loadCurrencySymbol();


            }
        );


    }



},

loadCurrencySymbol(){


        const selectedOption =
        this.currency.options[
            this.currency.selectedIndex
        ];



        const symbol =
        selectedOption.getAttribute(
            'data-symbol'
        );



        if(symbol){


            this.currencySymbol.value = symbol;


        }


    },    


    async update(){


        this.clearErrors();



        const formData = new FormData(
            this.form
        );



        // Convert unchecked switches
        [
            'allow_negative_stock',
            'allow_price_override',
            'allow_discount',
            'enable_customer_credit',
            'tax_enabled',
            'print_logo',
            'print_barcode'
        ]
        .forEach(field=>{


            if(!formData.has(field)){


                formData.append(
                    field,
                    0
                );


            }


        });

        try{


            const response = await fetch(window.settingsUpdateUrl,
                {


                    method:'POST',


                    headers:{


                        'Accept':
                        'application/json',


                        'X-CSRF-TOKEN':
                        document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content


                    },


                    body:formData


                }
            );




            const data = await response.json();





            if(response.ok && data.success){



                showToast(
                    data.message,
                    data.type ?? 'success'
                );



                return;


            }






            if(data.errors){


                this.showValidation(
                    data.errors
                );


                showToast(
                    'Please correct highlighted fields.',
                    'warning'
                );


                return;


            }







            showToast(
                data.message ??
                'Unable to update settings.',
                data.type ??
                'warning'
            );





        }
        catch(error){



            console.error(
                error
            );



            showToast(
                'Something went wrong while saving settings.',
                'danger'
            );


        }



    },









    clearErrors(){


        document
        .querySelectorAll(
            '#settingsForm .is-invalid'
        )
        .forEach(field=>{


            field.classList.remove(
                'is-invalid'
            );


        });



        document
        .querySelectorAll(
            '#settingsForm .invalid-feedback'
        )
        .forEach(error=>{


            error.innerHTML='';


        });



    },








    showValidation(errors){


        Object.keys(errors)
        .forEach(field=>{


            const input =
            this.form.querySelector(
                `[name="${field}"]`
            );



            if(input){


                input.classList.add(
                    'is-invalid'
                );



                const feedback =
                input.parentElement.querySelector(
                    '.invalid-feedback'
                );



                if(feedback){


                    feedback.innerHTML =
                    errors[field][0];


                }


            }



        });



    }



};







document.addEventListener(
    'DOMContentLoaded',
    ()=>{


        Settings.init();


    }
);
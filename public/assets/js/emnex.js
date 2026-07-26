document.addEventListener("DOMContentLoaded",function(){


    const toggle =
        document.getElementById("togglePassword");


    const password =
        document.getElementById("password");



    if(toggle){

        toggle.addEventListener("click",function(){


            const type =
                password.getAttribute("type")
                === "password"
                ? "text"
                : "password";


            password.setAttribute("type",type);


            this.innerHTML =
                type === "password"
                ?
                '<i class="bi bi-eye"></i>'
                :
                '<i class="bi bi-eye-slash"></i>';


        });

    }





    const form =
        document.getElementById("loginForm");


    if(form){


        form.addEventListener("submit",function(){


            let btn =
                document.getElementById("loginButton");


            let text =
                document.getElementById("loginText");


            let spinner =
                document.getElementById("loginSpinner");



            btn.disabled=true;

            text.innerHTML="Signing in...";

            spinner.classList.remove("d-none");


        });


    }



});
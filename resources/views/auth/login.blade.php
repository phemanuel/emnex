@extends('layouts.auth')


@section('content')

<div class="login-wrapper">


    <!-- LEFT SIDE -->
    <div class="login-banner">

    <div class="overlay"></div>


    <!-- TOP BRAND -->
    <div class="banner-brand">


        <div class="emnex-logo">

            <i class="bi bi-grid-1x2-fill"></i>

        </div>


        <div class="brand-text">

            <span>
                EMNEX
            </span>

            <small>
                POS
            </small>

        </div>


    </div>





    <!-- BOTTOM INFORMATION -->

    <div class="banner-content">


        <div class="brand-card">


            <h1>
                Enterprise Retail Solution
            </h1>


            <p>
                Everything you need to run your business
                efficiently from one powerful platform.
            </p>



            <div class="features">


                <div class="feature-item">
                    <i class="bi bi-box-seam"></i>
                    Inventory
                </div>


                <div class="feature-item">
                    <i class="bi bi-diagram-3"></i>
                    Multi Branch
                </div>


                <div class="feature-item">
                    <i class="bi bi-bar-chart"></i>
                    Analytics
                </div>


                <div class="feature-item">
                    <i class="bi bi-people"></i>
                    Customers
                </div>


            </div>


        </div>


    </div>
   </div>





    <!-- RIGHT SIDE -->
    <div class="login-area">


        <div class="login-card">


            <div class="text-center mb-4">


                <div class="login-icon">

                    <i class="bi bi-lock"></i>

                </div>


                <h3>
                    Welcome Back
                </h3>


                <p>
                    Sign in to your Emnex POS account
                </p>


            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" id="loginForm">

                @csrf



                <!-- Company Code -->

                <div class="mb-3">

                    <label class="form-label">
                        Company Code
                    </label>


                    <div class="input-group">

                        <span class="input-group-text">

                            <i class="bi bi-building"></i>

                        </span>


                        <input 
                            type="text"
                            name="company_code"
                            class="form-control"
                            placeholder="Enter company code"
                            required
                        >

                    </div>

                </div>





                <!-- Username -->

                <div class="mb-3">

                    <label class="form-label">
                        Username
                    </label>


                    <div class="input-group">

                        <span class="input-group-text">

                            <i class="bi bi-person"></i>

                        </span>


                        <input 
                            type="text"
                            name="username"
                            class="form-control"
                            placeholder="Enter username"
                            required
                        >

                    </div>


                </div>





                <!-- Password -->

                <div class="mb-3">


                    <label class="form-label">
                        Password
                    </label>



                    <div class="input-group">


                        <span class="input-group-text">

                            <i class="bi bi-key"></i>

                        </span>



                        <input 
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder="Enter password"
                            required
                        >



                        <button 
                            class="btn btn-outline-secondary"
                            type="button"
                            id="togglePassword"
                        >

                            <i class="bi bi-eye"></i>

                        </button>


                    </div>


                </div>





                <div class="d-flex justify-content-between mb-4">


                    <div class="form-check">


                        <input 
                            class="form-check-input"
                            type="checkbox"
                            name="remember"
                            id="remember"
                        >


                        <label class="form-check-label"
                               for="remember">

                            Remember me

                        </label>


                    </div>



                    <a href="#" class="small">

                        Forgot password?

                    </a>


                </div>






                <button 
                    class="btn login-btn w-100"
                    id="loginButton"
                >


                    <span id="loginText">

                        Sign In

                    </span>



                    <span 
                        class="spinner-border spinner-border-sm d-none"
                        id="loginSpinner"
                    ></span>


                </button>



            </form>



        </div>



    </div>



</div>


@endsection
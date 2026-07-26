<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html lang="en">

<head>

    @include('layouts.partials.head')

    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components/topbar.css') }}">

</head>

<body>

<div class="app-layout">


    @include('layouts.partials.sidebar')


    <div class="app-main">


        @include('layouts.partials.topbar')


        <div class="app-body">


            <main class="app-content">

                @yield('content')

            </main>


            @include('layouts.partials.footer')


        </div>


    </div>


</div>


@include('layouts.partials.scripts')


</body>
</html>

</html>
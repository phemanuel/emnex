<!DOCTYPE html>
<html lang="en">

<head>

    @include('layouts.partials.head')

</head>

<body class="auth-body">

    {{ $slot ?? '' }}

    @yield('content')


    @include('layouts.partials.scripts')

</body>

</html>
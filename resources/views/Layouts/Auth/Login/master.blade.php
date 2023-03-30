<!DOCTYPE html>
<html lang="en">

<head>
    @include('Layouts.Auth.Register.head-tag')
    @yield('head-tag')

</head>

<body class="hold-transition login-page">




    <div class="login-box">



            @yield('content')

    </div>


    @include('Layouts.Auth.Register.script')
    @yield('script')


    @include('Alerts.sweetalert.error')



</body>
</html>

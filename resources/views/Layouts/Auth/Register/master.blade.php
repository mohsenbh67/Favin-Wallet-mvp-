<!DOCTYPE html>
<html lang="en">

<head>
    @include('Layouts.Auth.Register.head-tag')
    @yield('head-tag')

</head>

<body class="hold-transition register-page">




    <div class="register-box">



            @yield('content')

    </div>


    @include('Layouts.Auth.Register.script')
    @yield('script')


    @include('Alerts.sweetalert.error')



</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    @include('Layouts.Admin.head-tag')
    @yield('head-tag')

</head>

<body class="hold-transition sidebar-mini layout-fixed">

    @include('Layouts.Admin.header')



    <section class="body-container">

        @include('Layouts.Admin.sidebar')


        <section id="main-body" class="main-body">

            @yield('content')

        </section>
    </section>


    @include('Layouts.Admin.script')
    @yield('script')



    @include('Alerts.sweetalert.error')
    @include('Alerts.sweetalert.success')


</body>
</html>

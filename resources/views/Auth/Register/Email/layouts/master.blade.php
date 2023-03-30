<!doctype html>
<html>
<head>

    @include('auth.register.email.layouts.head-tag')
    @yield('head-tag')

</head>
<body>

    <!-- start header -->
    @include('auth.register.email.layouts.header')
    <!-- end header -->


    <!-- start main one col -->
    <main id="main-body-one-col" class="main-body">
        @yield('content')
    </main>
    <!-- end main one col -->


    <!-- start footer -->
    @include('auth.register.email.layouts.footer')
    <!-- end footer -->

</body>
</html>
@include('frontend/layouts/partials/_start')

    @unless(Route::is('login', 'register', 'email.verifie.use-otp', 'forgot.password', 'forgot.password.verify.otp', 'forgot.password.edit.new.password'))
        @include('frontend/layouts/partials/_header')
    @endunless

        @yield('content')

    @include('frontend/layouts/partials/_scroll-top')

    @unless(Route::is('login', 'register', 'email.verifie.use-otp', 'forgot.password', 'forgot.password.verify.otp', 'forgot.password.edit.new.password'))
        @include('frontend/layouts/partials/_footer')
        @include('frontend/layouts/partials/_offcanvas_minicart_wrapper')
    @endunless

    <!-- Les messages d'alerte sweetalert2  -->
    @include('frontend-flash-message')
    <!-- End  -->

@include('frontend/layouts/partials/_end')
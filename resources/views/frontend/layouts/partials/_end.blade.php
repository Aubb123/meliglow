    @yield('summernote')

    <!-- JS ============================================ -->

    <!-- Modernizer JS -->
    <script src="{{ asset(getEnvFolder() . 'frontend/assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <!-- jQuery JS -->
    <script src="{{ asset(getEnvFolder() . 'frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset(getEnvFolder() . 'frontend/assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <!-- slick Slider JS -->
    <script src="{{ asset(getEnvFolder() . 'frontend/assets/js/plugins/slick.min.js') }}"></script>
    <!-- Countdown JS -->
    <script src="{{ asset(getEnvFolder() . 'frontend/assets/js/plugins/countdown.min.js') }}"></script>
    <!-- Nice Select JS -->
    <script src="{{ asset(getEnvFolder() . 'frontend/assets/js/plugins/nice-select.min.js') }}"></script>
    <!-- jquery UI JS -->
    <script src="{{ asset(getEnvFolder() . 'frontend/assets/js/plugins/jqueryui.min.js') }}"></script>
    <!-- Image zoom JS -->
    <script src="{{ asset(getEnvFolder() . 'frontend/assets/js/plugins/image-zoom.min.js') }}"></script>
    <!-- Images loaded JS -->
    <script src="{{ asset(getEnvFolder() . 'frontend/assets/js/plugins/imagesloaded.pkgd.min.js') }}"></script>
    <!-- mail-chimp active js -->
    <script src="{{ asset(getEnvFolder() . 'frontend/assets/js/plugins/ajaxchimp.js') }}"></script>
    <!-- contact form dynamic js -->
    <script src="{{ asset(getEnvFolder() . 'frontend/assets/js/plugins/ajax-mail.js') }}"></script>
    <!-- google map active js -->
    <script src="{{ asset(getEnvFolder() . 'frontend/assets/js/plugins/google-map.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset(getEnvFolder() . 'frontend/assets/js/main.js') }}"></script>

    <!-- Script hors template, fichier js ajouter par Aubanel -->
    <script src="{{ asset(getEnvFolder() . 'others/all/others/js/global-form-loader.js') }}"></script>

    @yield('scripts')

</body>

</html>
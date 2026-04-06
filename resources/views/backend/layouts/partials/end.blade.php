

    @yield('summernote')
    
    <script src="{{ asset(getEnvFolder() . 'backend/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'backend/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'backend/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'backend/assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'backend/assets/vendor/libs/%40algolia/autocomplete-js.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'backend/assets/vendor/libs/pickr/pickr.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'backend/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'backend/assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'backend/assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'backend/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'backend/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'backend/assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'backend/assets/js/main.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'backend/assets/js/dashboards-analytics.js') }}"></script>
    
    <!-- Script hors template, fichier js ajouter par Aubanel -->
    <script src="{{ asset(getEnvFolder() . 'others/all/others/js/global-form-loader.js') }}"></script>

    @yield('script')

</body>

</html>
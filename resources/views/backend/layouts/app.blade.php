@include('backend/layouts/partials/start')
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar  ">
        <div class="layout-container">

            <!-- Start Aside -->
            @include('backend/layouts/partials/aside')
            <!-- End Aside -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Start Navbar -->
                @include('backend/layouts/partials/navbar')
                <!-- End Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <!-- Les messages d'alerte simple  -->        
                    @include('backend-messages')
                    <!-- End  -->

                    <!-- Start Page-content -->
                    @yield('content')
                    <!-- End Page-content -->
                 
                    <!-- Start Footer -->
                    @include('backend/layouts/partials/footer')
                    <!-- End Footer -->

                </div>
                <!-- Content wrapper -->

            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Les messages d'alerte sweetalert2  -->
    @include('backend-flash-message')
    <!-- End  -->
    
@include('backend/layouts/partials/end')

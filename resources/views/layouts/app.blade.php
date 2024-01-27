<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset("assets/images/icon.png")}}">

    <!-- jsvectormap css -->
    <link href="{{asset("assets/libs/jsvectormap/css/jsvectormap.min.css")}}" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="{{asset("assets/libs/swiper/swiper-bundle.min.css")}}" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="{{asset("assets/js/layout.js")}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{asset("assets/css/bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset("assets/css/icons.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset("assets/css/app.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{asset("assets/css/custom.min.css")}}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{asset("cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css")}}" />
    <link rel="stylesheet" href="{{asset("cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css")}}" />
    <link rel="stylesheet" href="{{asset("cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css")}}">

    @yield('css-link')

</head>

<style>
    :is([data-layout=vertical],[data-layout=semibox])[data-sidebar=dark] .navbar-menu {
        background: #ffffff;
        border-right: 1px solid #ffffff;
    }
    :is([data-layout=vertical],[data-layout=semibox])[data-sidebar=dark] .navbar-nav .nav-link {
        color: #000000;
    }
    :is([data-layout=vertical],[data-layout=semibox])[data-sidebar=dark] .navbar-nav .nav-link:hover {
        color: #e35310;
    }
    .menu-title span {
        padding: 12px 20px;
        display: inline-block;
        color: #087039;
    }
    :is([data-layout=vertical],[data-layout=semibox])[data-sidebar=dark][data-sidebar-size=sm] .navbar-brand-box {
        background: #ffffff;
    }
    :is([data-layout=vertical],[data-layout=semibox])[data-sidebar=dark] .navbar-nav .nav-link[data-bs-toggle=collapse][aria-expanded=true] {
        color: #e45310;
    }
    :is([data-layout=vertical],[data-layout=semibox])[data-sidebar=dark] .navbar-nav .nav-sm .nav-link {
        color: #000000;
    }

    :is([data-layout=vertical],[data-layout=semibox])[data-sidebar=dark] .navbar-nav .nav-sm .nav-link:hover {
        color: #087039;
    }
    .dropify-wrapper .dropify-message > span > p{
        font-size: 12px;
    }
    .hidden{
        display: none;
    }
</style>


<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        @include('partials.top-bar')

        <!-- removeNotificationModal -->
        <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mt-2 text-center">
                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                            <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                <h4>Are you sure ?</h4>
                                <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                            <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                        </div>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- ========== App Menu ========== -->
        @include('partials.side-bar')
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        @yield('content')
        <!-- end main content-->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6" >
                            <script>document.write(new Date().getFullYear())</script>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

    </div>
    <!-- END layout-wrapper -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!-- JAVASCRIPT -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{asset("assets/libs/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
    <script src="{{asset("assets/libs/simplebar/simplebar.min.js")}}"></script>
    <script src="{{asset("assets/libs/node-waves/waves.min.js")}}"></script>
    <script src="{{asset("assets/libs/feather-icons/feather.min.js")}}"></script>
    <script src="{{asset("assets/js/pages/plugins/lord-icon-2.1.0.js")}}"></script>
    <script src="{{asset("assets/js/plugins.js")}}"></script>

    <script src="{{asset("cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js")}}"></script>
    <script src="{{asset("cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js")}}"></script>
    <script src="{{asset("cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js")}}"></script>
    <script src="{{asset("cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js")}}"></script>
    <script src="{{asset("cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js")}}"></script>
    <script src="{{asset("cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js")}}"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"></script>

    <link href="{{asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js" integrity="sha512-efAcjYoYT0sXxQRtxGY37CKYmqsFVOIwMApaEbrxJr4RwqVVGw8o+Lfh/+59TU07+suZn1BWq4fDl5fdgyCNkw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $('.phone').inputmask('225 9999999999', { placeholder: '' });
        $('.dropify-logo').dropify({
            messages: {
                default: 'Glissez-déposez un logo ici ou cliquez',
                replace: 'Glissez-déposez un logo ou cliquez pour remplacer',
                remove:  'Supprimer',
                error:   'Désolé, le fichier trop volumineux'
            }
        });
        $('.dropify').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove:  'Supprimer',
                error:   'Désolé, le fichier trop volumineux'
            }
        });
        
        function deleted(id,link){

            Swal.fire({
                html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon><div class="mt-4 pt-2 fs-15 mx-5"><h4>Êtes-vous sûr?</h4><p class="text-muted mx-4 mb-0">Une fois supprimé, vous ne pourrez plus récupérer cet élément!</p></div></div>',
                showCancelButton: !0,
                confirmButtonClass: "btn btn-primary w-xs me-2 mb-1",
                confirmButtonText: "Oui",
                cancelButtonText: "Non",
                cancelButtonClass: "btn btn-danger w-xs mb-1",
                buttonsStyling: !1,
                showCloseButton: !0
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'GET',
                        url: link,
                        data: {id:id},
                        dataType: 'json',
                        success: function (result){
                            if(result.status=="success"){
                                Toastify({
                                        text: result.message,
                                        duration: 3000, // 3 seconds
                                        gravity: "top", // Position at the top of the screen
                                        backgroundColor: "#0ab39c", // Background color for success
                                        close: true, // Show a close button
                                    }).showToast();
                                setTimeout(() => {
                                window.location.reload();
                                }, 2000);
                            }else{
                                Toastify({
                                    text: result.message,
                                    duration: 3000, // 3 seconds
                                    gravity: "top", // Position at the top of the screen
                                    backgroundColor: "#e75050", // Background color for success
                                    close: true, // Show a close button
                                }).showToast();
                            }
                        },error: function(){
                            Toastify({
                                text: "Une erreur c'est produite",
                                duration: 3000, // 3 seconds
                                gravity: "top", // Position at the top of the screen
                                backgroundColor: "#e75050", // Background color for success
                                close: true, // Show a close button
                            }).showToast();
                        }
                    });
                }
            });
        }
    </script>
    
    @yield('script')

</body>


</html>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <!-- App favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assettes/images/babo-white.png')}}">
    <!-- Layout config Js -->
    <script src="{{asset("assets/js/layout.js")}}"></script>
    

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{asset("cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css")}}" />
    <link rel="stylesheet" href="{{asset("cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css")}}" />
    <link rel="stylesheet" href="{{asset("cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css")}}">

    <!--New Start-->
	<link href={{asset("assettes/vendor/bootstrap-select/dist/css/bootstrap-select.min.css")}} rel="stylesheet" type="text/css"/>
	<link href={{asset("assettes/vendor/chartist/css/chartist.min.css")}} rel="stylesheet" type="text/css"/>
	<link href={{asset("assettes/vendor/owl-carousel/owl.carousel.css")}} rel="stylesheet" type="text/css"/>
	<link href={{asset("assettes/css/style.css")}} rel="stylesheet" type="text/css"/>
    <link href={{asset("assettes/vendor/datatables/css/jquery.dataTables.min.css")}} rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&amp;family=Roboto:wght@100;300;400;500;700;900&amp;display=swap" rel="stylesheet" type="text/css"/>
    <link href={{asset("assettes/vendor/jquery-smartwizard/dist/css/smart_wizard.min.css")}} rel="stylesheet">    
    <!--New End-->

    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    


    @yield('css-link')

</head>

<style>

    table.dataTable {
        width: 100%;
        margin: 0 auto;
        clear: both;
        border-collapse: separate;
        border-spacing: 0;
        border: 1px !important;
        color: gray;
    }

    .badge-danger {
        background-color: #cf0013;
    }

    .light.badge-danger {
        background-color: #fff3f7;
        color: #cf0013;
    }

    .light.btn-primary {
        background-color: #c0c1c6;
        border-color: #c0c1c6;
        color: #fff;
    }

    table.table-bordered.dataTable thead tr:first-child th, table.table-bordered.dataTable thead tr:first-child td {
        border-bottom-width: 0px;
    }

    button.dt-button:first-child, div.dt-button:first-child, a.dt-button:first-child, input.dt-button:first-child {
    margin-left: 0;
    background: #cf0013 !important;
    color: white;
    margin: 10px;
    border-color: #cf0013;
}

    td, th {
    padding-bottom: 20px !important;
    padding-top: 20px !important;
    font-size: 15px !important;
    }
    
    button {
        width: 100%;
        font-size: 18px !important;
    }

    .btn-danger {
        background-color: #cf0013;
    }

    #icone-delete {
        border-color: #cf0013; 
    }

    .pagination .page-item.active .page-link {
        background-color: #cf0013;
        border-color: #cf0013;
        color: #fff;
        box-shadow: 0 10px 20px 0px rgba(233, 4, 69, 0.2);
    }

    .pagination .page-item .page-link:hover {
        background: #cf0013;
        color: #fff;
        border-color: #cf0013;
    }

    table.dataTable thead th {
        color: #494949;
        font-weight: 500;
        font-size: 14px;
    }

    th {
        margin-left: 0 !important;
        padding-left: 10px !important;
        text-align: start !important;
    }

    button.dt-button:first-child, div.dt-button:first-child, a.dt-button:first-child, input.dt-button:first-child {
        border-radius: 30px;
        font-size: 14px;
    }

    div.dataTables_wrapper div.dataTables_filter input {
        border-radius: 30px;
    }

    :is([data-layout=vertical],[data-layout=semibox])[data-sidebar=dark] .navbar-menu {
        background: #ffffff;
        border-right: 1px solid #ffffff;
    }
    :is([data-layout=vertical],[data-layout=semibox])[data-sidebar=dark] .navbar-nav .nav-link {
        color: #000000;
    }
    :is([data-layout=vertical],[data-layout=semibox])[data-sidebar=dark] .navbar-nav .nav-link:hover {
        color: #04284c;
    }
    .menu-title span {
        padding: 12px 20px;
        display: inline-block;
        color: #04284c;
    }
    :is([data-layout=vertical],[data-layout=semibox])[data-sidebar=dark][data-sidebar-size=sm] .navbar-brand-box {
        background: #ffffff;
    }
    :is([data-layout=vertical],[data-layout=semibox])[data-sidebar=dark] .navbar-nav .nav-link[data-bs-toggle=collapse][aria-expanded=true] {
        color: #04284c;
    }
    :is([data-layout=vertical],[data-layout=semibox])[data-sidebar=dark] .navbar-nav .nav-sm .nav-link {
        color: #000000;
    }

    :is([data-layout=vertical],[data-layout=semibox])[data-sidebar=dark] .navbar-nav .nav-sm .nav-link:hover {
        color: #04284c;
    }
    .dropify-wrapper .dropify-message > span > p{
        font-size: 12px;
    }
    .hidden{
        display: none;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #04284C;
        color: white;
    }

    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1px solid #aaa;
        border-radius: 20px;
    }

    .select2-container--default .select2-selection--single {
        height: 40px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        padding: 5px 14px;
    }
    .select2-container--default .select2-selection--single {
        border: 1px solid #f0f1f5;
        border-radius: 25px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 7px;
        right: 5px;
    }
    .select2-container--default .select2-selection--multiple {
        background-color: white;
        border: 1px solid #aaa;
        border-radius: 4px;
        cursor: text;
        padding-bottom: 5px;
        padding-right: 5px;
        min-height: 36px;
        position: relative;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #405189;
        border: 1px solid #405189;
        border-radius: 3px;
        margin-left: 5px;
        margin-top: 7px;
        padding: 0;
        padding-left: 20px;
        position: relative;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        vertical-align: bottom;
        white-space: nowrap;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        border-right: 1px solid #405189;
        color: #fff;
    }
    button.dt-button:first-child, div.dt-button:first-child, a.dt-button:first-child, input.dt-button:first-child {
        margin-left: 0;
        background: #04284c;
        color: white;
        margin: 10px
    }
    .btn-primary{
        background: #04284c;
        border: none
    }
    .btn-primary:hover{
        background: #04284c;
        border: none
    }

    #box_yan {
    padding: 1.875rem;
    background: linear-gradient(to right, #04284c 0%, #b32431 100%) !important;
    border-radius: 20px;
    }

    label {
    display: inline-block;
    margin-bottom: 0.5rem;
    font-weight: 600 !important;
    }

    .card-title {
    font-size: 18px;
    font-weight: 600;
    color: #04284c;
    text-transform:none;
    }

    .btn-primary:hover {
        color: #fff;
        background-color: #04284c !important;
        border-color: #04284c !important;
    }

    .btn-danger:hover {
        color: #fff;
        background-color: #cf0013 !important;
        border-color: #cf0013 !important;
    }

    .footer .copyright a {
        color: #04284C;
    }

    .btn-primary:not(:disabled):not(.disabled):active, .btn-primary:not(:disabled):not(.disabled).active, .show > .btn-primary.dropdown-toggle {
        color: #fff;
        background-color: #04284c !important;
        border-color: #04284c !important;
    }

    .btn-primary:focus, .btn-primary.focus {
        color: #fff;
        background-color: #04284c;
        border-color: #04284c;
        box-shadow: none;
    }

    .btn-danger:not(:disabled):not(.disabled):active, .btn-danger:not(:disabled):not(.disabled).active, .show > .btn-danger.dropdown-toggle {
        color: #fff;
        background-color: #cf0013;
        border-color: #cf0013;
    }

    .header-left .dashboard_bar {
        font-size: 28px;
        font-weight: 600;
        color: #04284c;
    }

    .header-right .header-profile > a.nav-link .header-info strong {
        font-weight: 600;
        color: #04284c;
    }

    .swal2-actions {
        flex-wrap: nowrap !important;
    }

    .btn-danger:focus, .btn-danger.focus {
        color: #fff;
        background-color: #cf0013;
        border-color: #cf0013;
        box-shadow: 0 0 0 0.2rem rgba(250, 98, 153, 0.5);
    }

    .sw-theme-default .toolbar>.btn {
        color: #fff;
        background-color: #04284c;
        border: 1px solid #04284c;
        padding: .375rem .75rem;
        border-radius: .25rem;
        font-weight: 400;
    }

    .bootstrap-select .dropdown-toggle .filter-option-inner-inner {
        overflow: hidden;
        color: #4a4646 !important;
        font-size: 13px;
        padding-top: 6px;
        padding-bottom: 6px;
    }

    .toolbar.toolbar-bottom {
        width: 20%;
        border: 50px;
    }

    .sw-theme-default .toolbar>.btn {
        color: #fff;
        background-color: #04284c;
        border: 1px solid #04284c;
        padding: .375rem .75rem;
        border-radius: 1.25rem;
        font-weight: 400;
        padding: 7px;
        padding-right: 20px;
        padding-left: 20px;
    }

    button.swal2-confirm.btn.btn-primary.w-xs.me-2.mb-1 {
        margin-right: 10px !important;
    }

    .form-control {
        color: #4a4646 !important;
    }

    .bootstrap-select .dropdown-toggle .filter-option-inner-inner {
        overflow: hidden;
        color: #4a4646 !important;
    }

    .sw-theme-default>.nav {
        box-shadow: none !important;
    }

    .sw-theme-default {
        border: none !important;
    }

    .toolbar.toolbar-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
}


</style>


<body>

    <!-- Begin page -->
    <div id="main-wrapper">

        <div class="nav-header">
            <a href="{{route("dashboard")}}" class="brand-logo">
				<img class="logo-abbr" src="{{asset('assettes/images/babo-white.png')}}" alt="">
				<img class="logo-compact" src="{{asset('assettes/images/logo-phenix.png')}}" alt="">
                <img class="brand-title" src="{{asset('assettes/images/logo-phenix.png')}}" alt="">
            </a>

            <div class="nav-control"> 
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>

        @include('partials.top-bar')

        
        <!-- ========== App Menu ========== -->
        @include('partials.side-bar')
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        @yield('content')
        <!-- end main content-->
            
        <div class="footer">
            <div class="copyright">
                <p> Développé par <a href="#" target="_blank">Babo-Corporate</a> 
                    <script>document.write(new Date().getFullYear())</script>
                </p>
            </div>
        </div>
    </div>
    <!-- END layout-wrapper -->



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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jszip@3/dist/jszip.min.js"></script>

    <!-- NEW START -->
    <script src={{asset("assettes/vendor/global/global.min.js")}} type="text/javascript"></script>
    <script src={{asset("assettes/vendor/bootstrap-select/dist/js/bootstrap-select.min.js")}} type="text/javascript"></script>
    <script src={{asset("assettes/vendor/chart.js/Chart.bundle.min.js")}} type="text/javascript"></script>
    <script src={{asset("assettes/public/vendor/peity/jquery.peity.min.js")}} type="text/javascript"></script>
    <script src={{asset("assettes/vendor/apexchart/apexchart.js")}} type="text/javascript"></script>
    <script src={{asset("assettes/js/dashboard/dashboard-1.js")}} type="text/javascript"></script>
    <script src={{asset("assettes/js/custom.js")}} type="text/javascript"></script>
    <script src={{asset("assettes/js/deznav-init.js")}} type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src={{asset("assettes/vendor/datatables/js/jquery.dataTables.min.js")}} type="text/javascript"></script>
    <script src={{asset("assettes/js/plugins-init/datatables.init.js")}} type="text/javascript"></script>

    <script src={{asset("assettes/vendor/jquery-smartwizard/dist/js/jquery.smartWizard.js")}}></script>	
	<script>
		$(document).ready(function(){
			// SmartWizard initialize
			$('#smartwizard').smartWizard(); 
		});
	</script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- NEW END -->


    <script>
        //$('select').select2();

        $('.phone').inputmask('2259999999999', { placeholder: '' });
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

        function resilier(id,link){

            Swal.fire({
                html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon><div class="mt-4 pt-2 fs-15 mx-5"><h4>Êtes-vous sûr?</h4><p class="text-muted mx-4 mb-0">Une fois résilier, vous ne pourrez plus activer cet élément!</p></div></div>',
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
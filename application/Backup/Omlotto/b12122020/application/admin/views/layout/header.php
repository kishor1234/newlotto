<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <title>Admin Dashboard</title>
        <link rel="shortcut icon" href="favicon.png"> 
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="assets/css/adminlte.min.css">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

        <!-- REQUIRED SCRIPTS -->
        <link rel="stylesheet" href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css">
        <link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">
        <!-- jQuery -->
        <script src="assets/plugins/jquery/jquery.min.js"></script>
        
    
        <script src="assets/js/jquerysession.js" type="text/javascript"></script>
        <!-- Bootstrap 4 -->
        <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="assets/js/adminlte.min.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/plugins/datatables/media/css/jquery.dataTables.css">
        <link rel="stylesheet" type="text/css" href="assets/plugins/datatables/media/css/dataTables.bootstrap4.css">
        <link rel="stylesheet" type="text/css" href="assets/plugins/datatables/media/css/responsive.dataTables.css">
        <script src="assets/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="assets/plugins/datatables/media/js/dataTables.bootstrap4.js"></script>
        <script src="assets/plugins/datatables/media/js/dataTables.responsive.js"></script>
        <script src="assets/plugins/datatables/media/js/responsive.bootstrap4.js"></script>
        <!-- buttons for Export datatable -->
        <!--<script src="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" async></script>-->
        <script src="assets/plugins/datatables/media/js/button/dataTables.buttons.js"></script>
        <script src="assets/plugins/datatables/media/js/button/buttons.bootstrap4.js"></script>
        <script src="assets/plugins/datatables/media/js/button/buttons.print.js"></script>
        <script src="assets/plugins/datatables/media/js/button/buttons.html5.js"></script>
        <script src="assets/plugins/datatables/media/js/button/buttons.flash.js"></script>
        <script src="assets/plugins/datatables/media/js/button/pdfmake.min.js"></script>
        <script src="assets/plugins/datatables/media/js/button/vfs_fonts.js"></script>
        <script src="assets/plugins/jquerytoast/jquery.toaster.js" type="text/javascript"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
        <script src="https://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.23.1/slimselect.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.23.1/slimselect.min.css"> 
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/data.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="assets/plugins/daterangepicker/daterangepicker.js"></script>

        <script>
            function checkSession() {
                var answer = $.session.get("loginEmail");
                if (answer != undefined) {
                    $(".storage-val strong span").html(answer);
                } else {
                    window.location.replace("/");
                }
            }
            //checkSession();
        </script>
        <style>
            .orSec {
                margin: 0 auto;
                width: 242px;
                border-bottom: 1px solid #cecece;
                position: relative;
                margin-bottom: 20px;
            }
            .orSec .ortextNew {
                width: 20px;
                height: 20px;
                position: absolute;
                left: 50%;
                bottom: -10px;
                margin-left: -14px;
                line-height: 20px;
                font-size: 12px;
                background: #fff;
            }


            .form{
                position: inherit;

                width: 100%;
                height: auto;
                border: 1px dashed #7f7f7f;
            }
            .form p{
                //width: 100%;
                //height: 100%;
                text-align: center;
                line-height: 170px;
                color: #7f7f7f;
                font-family: Arial;
            }
            .form input{
                position: absolute;
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
                outline: none;
                opacity: 0;
            }
            .form button{
                margin: 0;
                color: #7f7f7f;
                background: #16a085;
                border: none;
                width: 508px;
                height: 35px;
                margin-top: -20px;
                margin-left: -4px;
                border-radius: 4px;
                border-bottom: 4px solid #117A60;
                transition: all .2s ease;
                outline: none;
            }
            .form button:hover{
                background: #149174;
                color: #0C5645;
            }
            .form button:active{
                border:0;
            }
            #progress{
                display: none;
            }

            .text-dark{
                text-transform: capitalize;
            }
        </style>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <div class="wrapper">

            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                    </li>
                    <li>
                        <a class="nav-link" href="#">Total Point <i class="fas fa-money"></i> <span id="exams"></span></a>
                    </li>

                </ul>

                <!-- SEARCH FORM -->


                <!-- Right navbar links -->

            </nav>
            <!-- /.navbar -->
            <?=
            $main->isLoadView(array("header" => "header", "main" => "sidebar", "footer" => "footer", "error" => "page_404"), false, array());
            ?>
            
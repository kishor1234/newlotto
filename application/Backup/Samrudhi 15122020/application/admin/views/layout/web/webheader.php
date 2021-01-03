<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Admin <?= $title ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="favicon.png"> 
        <!-- Font Awesome -->
        <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="assets/css/adminlte.min.css">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Parisienne&display=swap" rel="stylesheet">
        <style>
            #grad1 {

                background-color: #1fc8db;
                background-image: linear-gradient(141deg, #AC97E7 0%, #9777E1 10%,  #7D55DA 50%, #5C2AD1 75%);
                color: white;
                opacity: 0.95;
            }
            p#credit{
                text-align: center;
            }
            p#credit a{
                color:#FFF;
                font-size: 35px;
                font-weight: lighter;
            }
            #login-logo{
                font-family: 'Parisienne', cursive;
                font-size: 38px;
                margin-top: -10px;
            }
            #login-logo a{
                color:#FFF;
            }
            #progress{
                display: none;
            }
        </style>
        <!-- jquery js-->
        <!-- jQuery -->
        <script src="assets/plugins/jquery/jquery.min.js"></script>
        <script src="assets/js/jquerysession.js" type="text/javascript"></script>
        <!-- Bootstrap 4 -->
        <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="assets/js/adminlte.min.js"></script>

        <!-- end js-->
        <script>

//            function checkSession() {
//                var answer = $.session.get("loginEmail");
//                if (answer != undefined) {
//                    window.location.replace("/?r=dashboard");
//                } else {
//                    //window.location.replace("/");
//                }
//            }
//            checkSession();
        </script>
    </head>
    <body>
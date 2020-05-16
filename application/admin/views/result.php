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

    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <style>
                        #r1{
                            text-align: center;
                            border: 1px solid #000000;
                            color: #FFFFFF;
                            background-color: rgb(212,133,194);
                            font-size: 25px;
                            font-weight: bold;
                            padding: 0px 5px;
                        }
                        #r2{
                            text-align: center;
                            border: 1px solid #000000;
                            color: #FFFFFF;
                            background-color: rgb(130,180,126);
                            font-size: 25px;
                            font-weight: bold;
                            padding: 0px 5px;
                        }
                        #r3{
                            text-align: center;
                            border: 1px solid #000000;
                            color: #FFFFFF;
                            background-color: rgb(122,180,232);
                            font-size: 25px;
                            font-weight: bold;
                            padding: 0px 5px;
                        }
                        #r4{
                            text-align: center;
                            border: 1px solid #000000;
                            color: #FFFFFF;
                            background-color: rgb(91,163,106);
                            font-size: 25px;
                            font-weight: bold;
                            padding: 0px 5px;
                        }
                        #r5{
                            text-align: center;
                            border: 1px solid #000000;
                            color: #FFFFFF;
                            background-color: rgb(217,141,129);
                            font-size: 25px;
                            font-weight: bold;
                            padding: 0px 5px;
                        }
                        #r6{
                            text-align: center;
                            border: 1px solid #000000;
                            color: #FFFFFF;
                            background-color: rgb(185,177,230);
                            font-size: 25px;
                            font-weight: bold;
                            padding: 0px 5px;
                        }
                        #r7{
                            text-align: center;
                            border: 1px solid #000000;
                            color: #FFFFFF;
                            background-color: rgb(234,158,123);
                            font-size: 25px;
                            font-weight: bold;
                            padding: 0px 5px;
                        }
                        #r8{
                            text-align: center;
                            border: 1px solid #000000;
                            color: #FFFFFF;
                            background-color: rgb(164,204,90);
                            font-size: 25px;
                            font-weight: bold;
                            padding: 0px 5px;
                        }
                        #r9{
                            text-align: center;
                            border: 1px solid #000000;
                            color: #FFFFFF;
                            background-color: rgb(201,189,175);
                            font-size: 25px;
                            font-weight: bold;
                            padding: 0px 5px;
                        }
                        #r10{
                            text-align: center;
                            border: 1px solid #000000;
                            color: #FFFFFF;
                            background-color: rgb(23,188,189);
                            font-size: 25px;
                            font-weight: bold;
                            padding: 0px 5px;
                        }
                        ul{
                            padding: 0px;
                            margin: 0px;
                            float: left;
                        }
                        li{
                            list-style-type: none;
                            float: left;
                            margin: 1px;
                        }
                        .center{
                            text-align: center;
                            font-size: 20px;
                            font-weight: bold;
                            padding: 0;
                            margin: 0;
                        }
                        .mt-3{
                            margin: 10px 0px;
                        }
                    </style>
                    <h1>Result </h1>
                    <form action="/?r=result" method="post">
                        <div class="row form-group">
                            <div class="col-6">
                                <label>Select Date</label>
                                <input type="date" id="gdate" name="gdate" value="<?= $gdate ?>" class="form-control" max="<?= date("Y-m-d") ?>">

                            </div>
                            <div class="col-6">
                                <label>&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;</label>
                                <button class="btn btn-default form-control">Result</button>
                                <input type="hidden" id="series" name="series" value="<?= $series ?>">
                                <input type="hidden" id="userid" name="userid" value="<?= $userid ?>">
                            </div>
                        </div>

                    </form>
<!--                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#today">Today Result</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#previous">Previous Result</a>
                        </li>
                    </ul>-->
                    <div id="myTabContent" class="tab-d">
                        <div class="tab-pane fade show active" id="today">
                            <br><br>
                            <?php
                            $json = json_decode($result, true);
                            

                            foreach ($json as $key => $val) {
                                echo "<table class=\"table table-bordered mt-3\">";
                                echo "<tr><th><h4 class=\"center\">Draw Time: {$val["gameetime"]} </h4></th></tr>";
                                echo "<tr><td><ul>";
                                $k = 0;
                                $kk=1;
                                $s = explode("-", $val["series"]);
                                for ($i = $s[0]; $i <= $s[1]; $i = $i + 100) {
                                    
                                    $number = $i + $val[$k];
                                    echo "<li><h1 id=\"r{$kk}\">{$number}</h1></li>";
                                    $k++;
                                    $kk++;
                                }
                                echo "</ul></td></tr></table>";
                            }
                            ?>

                        </div>
<!--                        <div class="tab-pane fade" id="previous">
                            <br><br>
                            <table class="table table-bordered mt-3">
                                <tr>
                                    <th><h4 class="center">Draw Time</h4></th>
                                <td><h4 class="center">10:00:00</h4></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <ul>
                                            <li><h1 id="r1">1050</h1></li>
                                            <li><h1 id="r2">1050</h1></li>
                                            <li><h1 id="r3">1050</h1></li>
                                            <li><h1 id="r4">1050</h1></li>
                                            <li><h1 id="r5">1050</h1></li>
                                            <li><h1 id="r6">1050</h1></li>
                                            <li><h1 id="r7">1050</h1></li>
                                            <li><h1 id="r8">1050</h1></li>
                                            <li><h1 id="r9">1050</h1></li>
                                            <li><h1 id="r10">1050</h1></li>
                                        </ul>

                                    </td>
                                </tr>
                            </table>
                            <table class="table table-bordered mt-3">
                                <tr>
                                    <th><h4 class="center">Draw Time</h4></th>
                                <td><h4 class="center">10:00:00</h4></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <ul>
                                            <li><h1 id="r1">1050</h1></li>
                                            <li><h1 id="r2">1050</h1></li>
                                            <li><h1 id="r3">1050</h1></li>
                                            <li><h1 id="r4">1050</h1></li>
                                            <li><h1 id="r5">1050</h1></li>
                                            <li><h1 id="r6">1050</h1></li>
                                            <li><h1 id="r7">1050</h1></li>
                                            <li><h1 id="r8">1050</h1></li>
                                            <li><h1 id="r9">1050</h1></li>
                                            <li><h1 id="r10">1050</h1></li>
                                        </ul>

                                    </td>
                                </tr>
                            </table>
                        </div>-->
                    </div>
                </div>
            </div>

        </div>

        <script>
            $(document).ready(function () {
                //alert("work");
                //loadResult();
            });
            function loadResult() {
                $.post("<?= api_url ?>/?r=getResult", {gdate: $("#tdate").val(), series: $("#series").val()}, function (data) {
                    var json = JSON.parse(data);
                    var final = "<br><br>";
                    $.each(json, function (index, value) {
                        var series = value.series;
                        var s = series.split("-");
                        var k = 0;
                        var outPut = "<table class=\"table table-bordered mt-3\">" +
                                "<tr><th><h4 class=\"center\">Draw Time</h4></th><td><h4 class=\"center\">" + value['gameetime'] + "</h4></td>" +
                                "</tr><tr><td></td><td><ul>";
                        for (var i = parseInt(s[0]); i <= parseInt(s[1]); i = i + 100) {
                            var number = i + parseInt(value[k]);
                            k++;
                            outPut += "<li><h1 id=\"r" + k + "\">" + number + "</h1></li>";
                        }
                        outPut += "</ul></td></tr></table>";
                        final += outPut;
                        //console.log(outPut);
                    });
                    $("#today").html(final);

                });
            }
        </script>
    </body>
</html>
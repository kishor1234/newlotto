<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
<!--        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />-->
        <title>RajLaxmi Result Panel</title>
        <link href="/assets/ap/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <style>
            .logo-img {
                width: 100px !important;
                height: auto;
            }
        </style>
    </head>
    <body>
        <?php
        $today = date("Y-m-d");
        $yesterday = date('Y-m-d', (strtotime('-1 day', strtotime($today))));
        $rawSeries = json_decode($main->jsonRespon(api_url . "/?r=loadSeries", array()), true);
        $series = $rawSeries["data"];
        ?>

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p>
                        <img src="rjlx.png" alt="log-img" class="logo-img"/>
                        <span style="text-align:center;font-size:30px;"><strong>RajLaxmi Lottery Result Panel Coming Soon</strong></span>
                    </p>
                </div>
                <?php die;?>
                <div class="col-lg-12">
                    <ul class="nav nav-tabs">
                        <li class="active bg-success"><a href="#today" data-toggle="tab" aria-expanded="true"><strong>Today</strong></a></li>
                        <li class="bg-danger"><a href="#yesterday" data-toggle="tab" aria-expanded="false"><strong>Yesterday</strong></a></li>

                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade active in" id="today">
                            <ul class="nav nav-tabs">
                                <?php
                                $i = 1;
                                foreach ($series as $key => $val) {
                                    if ($i == 1) {
                                        ?>
                                        <li class="active bg-success"><a href="#today<?= $val["id"] ?>" data-toggle="tab" aria-expanded="true"><strong><?= $val["series"] ?></strong></a></li>

                                        <?php
                                    } else {
                                        ?>
                                        <li class="bg-success"><a href="#today<?= $val["id"] ?>" data-toggle="tab" aria-expanded="true"><strong><?= $val["series"] ?></strong></a></li>

                                        <?php
                                    }
                                    $i++;
                                }
                                ?>

                            </ul>

                            <div id="myTabContent" class="tab-content">
                                <?php
                                $colorArray = array("#d485c2", "#82b47e", "#7ab4e8", "#5ba36a", "#d98d81", "#b9b1e6", "#ea9e7b", "#a4cc5a", "#c9bdaf", "#17bcbd");
                                foreach ($series as $key => $val) {
                                    $i = 1;
                                    $result = json_decode($main->postJsonRespon(api_url . "/?r=result", array("series" => $val["series"], "gdate" => $today)), true);
                                    ?>
                                    <div class="tab-pane fade active in" id="today<?= $val["id"] ?>">

                                        <?php
                                        foreach ($result as $k => $vl) {

                                            if ($i == 1) {
                                                ?>
                                                <table class="table table-responsive">
                                                    <tr>
                                                        <th colspan="10"><strong style="text-align:center;font-size:20px;">Draw Time : <?= date("h:i a", strtotime($vl["gameetime"])) ?></strong></th>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color:<?= $colorArray[0] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["0"] ?></td>
                                                        <td style="background-color:<?= $colorArray[1] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["1"] ?></td>
                                                        <td style="background-color:<?= $colorArray[2] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["2"] ?></td>
                                                        <td style="background-color:<?= $colorArray[3] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["3"] ?></td>
                                                        <td style="background-color:<?= $colorArray[4] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["4"] ?></td>
                                                        <td style="background-color:<?= $colorArray[5] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["5"] ?></td>
                                                        <td style="background-color:<?= $colorArray[6] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["6"] ?></td>
                                                        <td style="background-color:<?= $colorArray[7] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["7"] ?></td>
                                                        <td style="background-color:<?= $colorArray[8] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["8"] ?></td>
                                                        <td style="background-color:<?= $colorArray[9] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["9"] ?></td>
                                                    </tr>

                                                </table>

                                                <?php
                                            } else {
                                                ?>
                                                <table class="table table-responsive">
                                                    <tr>
                                                        <th colspan="10"><strong style="text-align:center;font-size:20px;">Draw Time :  <?= date("h:i a", strtotime($vl["gameetime"])) ?></strong></th>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color:<?= $colorArray[0] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["0"] ?></td>
                                                        <td style="background-color:<?= $colorArray[1] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["1"] ?></td>
                                                        <td style="background-color:<?= $colorArray[2] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["2"] ?></td>
                                                        <td style="background-color:<?= $colorArray[3] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["3"] ?></td>
                                                        <td style="background-color:<?= $colorArray[4] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["4"] ?></td>
                                                        <td style="background-color:<?= $colorArray[5] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["5"] ?></td>
                                                        <td style="background-color:<?= $colorArray[6] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["6"] ?></td>
                                                        <td style="background-color:<?= $colorArray[7] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["7"] ?></td>
                                                        <td style="background-color:<?= $colorArray[8] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["8"] ?></td>
                                                        <td style="background-color:<?= $colorArray[9] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["9"] ?></td>
                                                    </tr>

                                                </table>

                                                <?php
                                            }
                                            $i++;
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="yesterday">
                            <ul class="nav nav-tabs">
                                <?php
                                $j = 1;
                                foreach ($series as $key => $val) {
                                    if ($j == 1) {
                                        ?>
                                        <li class="active bg-danger"><a href="#yesterday<?= $val["id"] ?>" data-toggle="tab" aria-expanded="true"><strong><?= $val["series"] ?></strong></a></li>

                                        <?php
                                    } else {
                                        ?>
                                        <li class="bg-danger"><a href="#yesterday<?= $val["id"] ?>" data-toggle="tab" aria-expanded="true"><strong><?= $val["series"] ?></strong></a></li>

                                        <?php
                                    }
                                    $j++;
                                }
                                ?>
                            </ul>

                            <div id="myTabContentYesterday" class="tab-content">
                                <?php
                                //$colorArray = array("#d485c2", "#82b47e", "#7ab4e8", "#5ba36a", "#d98d81", "#b9b1e6", "#ea9e7b", "#a4cc5a", "#c9bdaf", "#17bcbd");
                                foreach ($series as $key => $val) {
                                    $i = 1;
                                    $result = json_decode($main->postJsonRespon(api_url . "/?r=result", array("series" => $val["series"], "gdate" => $yesterday)), true);
                                    ?>
                                    <div class="tab-pane fade active in" id="yesterday<?= $val["id"] ?>">

                                        <?php
                                        foreach ($result as $k => $vl) {

                                            if ($i == 1) {
                                                ?>
                                                <table class="table table-responsive">
                                                    <tr>
                                                        <th colspan="10"><strong style="text-align:center;font-size:20px;">Draw Time : <?= date("h:i a", strtotime($vl["gameetime"])) ?></strong></th>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color:<?= $colorArray[0] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["0"] ?></td>
                                                        <td style="background-color:<?= $colorArray[1] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["1"] ?></td>
                                                        <td style="background-color:<?= $colorArray[2] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["2"] ?></td>
                                                        <td style="background-color:<?= $colorArray[3] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["3"] ?></td>
                                                        <td style="background-color:<?= $colorArray[4] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["4"] ?></td>
                                                        <td style="background-color:<?= $colorArray[5] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["5"] ?></td>
                                                        <td style="background-color:<?= $colorArray[6] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["6"] ?></td>
                                                        <td style="background-color:<?= $colorArray[7] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["7"] ?></td>
                                                        <td style="background-color:<?= $colorArray[8] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["8"] ?></td>
                                                        <td style="background-color:<?= $colorArray[9] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["9"] ?></td>
                                                    </tr>

                                                </table>

                                                <?php
                                            } else {
                                                ?>
                                                <table class="table table-responsive">
                                                    <tr>
                                                        <th colspan="10"><strong style="text-align:center;font-size:20px;">Draw Time :  <?= date("h:i a", strtotime($vl["gameetime"])) ?></strong></th>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color:<?= $colorArray[0] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["0"] ?></td>
                                                        <td style="background-color:<?= $colorArray[1] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["1"] ?></td>
                                                        <td style="background-color:<?= $colorArray[2] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["2"] ?></td>
                                                        <td style="background-color:<?= $colorArray[3] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["3"] ?></td>
                                                        <td style="background-color:<?= $colorArray[4] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["4"] ?></td>
                                                        <td style="background-color:<?= $colorArray[5] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["5"] ?></td>
                                                        <td style="background-color:<?= $colorArray[6] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["6"] ?></td>
                                                        <td style="background-color:<?= $colorArray[7] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["7"] ?></td>
                                                        <td style="background-color:<?= $colorArray[8] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["8"] ?></td>
                                                        <td style="background-color:<?= $colorArray[9] ?>;text-align:center;font-size:20px;"><?= (int) $val["series"] + $vl["9"] ?></td>
                                                    </tr>

                                                </table>

                                                <?php
                                            }
                                            $i++;
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
        <script src="/assets/ap/bootstrap/js/bootstrap.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
        <script>
            $(document).ready(function () {
                $('table').DataTable();
            });
        </script>
    </body>
</html>
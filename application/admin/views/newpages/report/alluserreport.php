<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?= $main->isLoadView(array("header" => "webheader", "main" => "banner", "footer" => "webfooter", "error" => "page_404"), false, array("title" => $title, "link" => $link)); ?>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <!--                        <div class="card-header">
                                                    <div class="card-title mb-2">
                                                        
                        -->
                        <div id="myModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <link rel="stylesheet"
                                      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

                                <style>
                                    #tickets-data {
                                        width: 250px;
                                        max-width: 250px;
                                        overflow: hidden;
                                        line-height: 1.2em;
                                    }

                                    .sign:not(:last-child) {
                                        padding-bottom: 30px;
                                        margin-bottom: 30px;
                                        border-bottom: 1px solid #e5e5e5;
                                    }

                                    div {
                                        line-height: 17px;
                                    }

                                    .game_title {
                                        line-height: 45px;
                                        font-size: 14px;
                                        margin-bottom: 10px;
                                        text-align: center;
                                    }

                                    .logo {
                                        width: 100%;
                                    }

                                    .first_prize {
                                        font-size: 16px;
                                        font-weight: normal;
                                    }

                                    .numbers-played {
                                        width: 100%;
                                        margin-bottom: 10px;
                                    }

                                    .numbers-played tr th,
                                    .numbers-played tr td {
                                        text-align: center;
                                    }

                                    .numbers-played tr td:nth-child(odd) {
                                        font-size: 11px;
                                        font-weight: normal;
                                    }

                                    .numbers-played tr td:nth-child(even) {
                                        font-weight: normal;
                                    }

                                    .normal_font {
                                        font-weight: normal;
                                    }

                                    .barcode {
                                        width: 75%;
                                    }

                                    .sign {
                                        text-align: center;
                                    }

                                    .sign img {
                                        height: 30px;
                                    }

                                    .sign_name {
                                        text-align: center;
                                        font-size: 12px;
                                    }

                                    .signImage {
                                        width: 100%;
                                    }
                                </style>
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <p class="modal-title">Show Ticket</p>
                                    </div>
                                    <div class="modal-body" id="ticket">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php
                        
                        if (isset($_POST["dateform"]) && isset($_POST["dateto"])) {
                            $dateform = $_POST["dateform"];
                            $dateto = $_POST["dateto"];
                            
                        } else {
                            $dateform = date("Y-m-d");
                            $dateto = date("Y-m-d");
                        }
                        ?>
                        <!--
                                                    </div>
                                                </div>-->
                        <div class="card-body">
                            <div class="progress" id="progress">
                                <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" id="inner-progress">Please wait....</div>
                            </div>

                            <div class="card-text">
                                <div class="row">
                                    <div class="col-12">
                                        <form  method="post" action="/?r=link&v=alluserreport">
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label>Form Date:</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="far fa-calendar-alt"></i>
                                                                </span>
                                                            </div>
                                                            <input type="date" value="<?= $dateform ?>" class="form-control float-right" id="reservation" name="dateform" max="<?= date("Y-m-d"); ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label>To Date:</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="far fa-calendar-alt"></i>
                                                                </span>
                                                            </div>
                                                            <input type="date" value="<?= $dateto ?>" class="form-control float-right" id="reservation" name="dateto" max="<?= date("Y-m-d"); ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label><br></label>
                                                        <button type="submit" class="btn btn-primary btn-sm form-control"><i class="fa fa-search "></i> Search</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="action" id="action" value="searchTicket">

                                        </form>
                                    </div>
                                    <div class="col-12">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th  style="text-align: center;background-color: #3C8DBC; color: #FFF;" class="col-xs-2" >
                                                        #        
                                                    </th>
                                                    <th  style="text-align: center;background-color: #3C8DBC; color: #FFF;" class="col-xs-2" >
                                                        User ID      
                                                    </th>
                                                    <th  style="text-align: center;background-color: #3C8DBC; color: #FFF;" class="col-xs-2" >
                                                        Purchase 
                                                        (a)
                                                    </th>
                                                    <th  style="text-align: center;background-color: #3C8DBC; color: #FFF;" class="col-xs-2" >
                                                        Cancel
                                                        (b)
                                                    </th>
                                                    <th  style="text-align: center;background-color: #3C8DBC; color: #FFF;" class="col-xs-2" >
                                                        Net Purchase pt
                                                        (c=a-b)
                                                    </th>
                                                    <th  style="text-align: center;background-color: #3C8DBC; color: #FFF;" class="col-xs-2" >
                                                        Win Pts
                                                        (d)
                                                    </th>
                                                    <th  style="text-align: center;background-color: #3C8DBC; color: #FFF;" class="col-xs-2" >
                                                        End pts
                                                        (e=c-d)
                                                    </th>
                                                    <th  style="text-align: center;background-color: #3C8DBC; color: #FFF;" class="col-xs-2" >
                                                        E-Stokc
                                                        Comm.(f)
                                                    </th>
                                                    <th  style="text-align: center;background-color: #3C8DBC; color: #FFF;"  class="col-xs-2" >
                                                        Incentive
                                                        (g)
                                                    </th>
                                                    <th  style="text-align: center;background-color: #3C8DBC; color: #FFF;" class="col-xs-2" >
                                                        Balance pt
                                                        (H=e-f-g)
                                                    </th>
                                                </tr>

                                            </thead>
                                            <tbody>
                                                <?php
                                                $sumofa = 0;
                                                $sumofb = 0;
                                                $sumofc = 0;
                                                $sumofd = 0;
                                                $sumofe = 0;
                                                $sumoff = 0;
                                                $sumofg = 0;
                                                $sumofh = 0;
                                                $responseData = $main->jsonRespon(api_url . "/?r=alluserreport", array("dateform" => $dateform, "dateto" => $dateto));
                                                $json = json_decode($responseData, true);
                                                foreach ($json as $key => $val) {
                                                    echo "<tr>";
                                                    echo "<td>{$key}</td>";
                                                    echo "<td>{$val["uid"]}</td>";
                                                    echo "<td>{$val["a"]}</td>";
                                                    $sumofa += $val["a"];
                                                    echo "<td>{$val["b"]}</td>";
                                                    $sumofb += $val["b"];
                                                    echo "<td>{$val["c"]}</td>";
                                                    $sumofc += $val["c"];
                                                    echo "<td>{$val["d"]}</td>";
                                                    $sumofd += $val["d"];
                                                    echo "<td>{$val["e"]}</td>";
                                                    $sumofe += $val["e"];
                                                    echo "<td>{$val["f"]}</td>";
                                                    $sumoff += $val["f"];
                                                    echo "<td>{$val["g"]}</td>";
                                                    $sumofg += $val["g"];
                                                    echo "<td>{$val["h"]}</td>";
                                                    $sumofh += $val["h"];
                                                    echo "<tr>";
                                                }
                                                ?>
                                                
                                            </tbody>
                                            <tfoot style="background-color:#0ff">
                                                <tr>
                                                    <td></td>
                                                    <th>Total:</th>
                                                    <th><?=$sumofa?></th>
                                                    <th><?=$sumofb?></th>
                                                    <th><?=$sumofc?></th>
                                                    <th><?=$sumofd?></th>
                                                    <th><?=$sumofe?></th>
                                                    <th><?=$sumoff?></th>
                                                    <th><?=$sumofg?></th>
                                                    <th><?=$sumofh?></th>
                                                    
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
    var table;
    $(document).ready(function () {
        $.fn.serializeObject = function ()
        {
            var o = {};
            var a = this.serializeArray();
            $.each(a, function () {
                if (o[this.name] !== undefined) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            return o;
        };
        $("#myMainForm").submit(function () {
            $("#myMainSubmit").attr("disabled", true);
            var formdata = new FormData($("#myMainForm")[0]);
            var object = {};
            formdata.forEach(function (value, key) {
                object[key] = value;
            });
            var json = JSON.stringify(object);
            $.ajax({
                type: 'POST',
                url: '<?= api_url ?>/?r=grandSel',
                dataType: "json",
                data: json,
                success: function (obj) {

                    $("#gs").html(obj.gs);
                    $("#wa").html(obj.wa);
                    $("#np").html(obj.np);
                    $("#d").html("Grand Sale " + obj.cdate);
                },
                error: function (request, status, error) {
                    printMessage("Error on " + error, "danger", ".msg");
                }
            });
            return false;
        });
    });

    function deleteSeries(id, st)
    {
        swal({
            title: "Are you sure?",
            text: "want to delete Series?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, Delete it!",
            closeOnConfirm: true
        },
                function () {
                    $.post('<?= api_url ?>/?r=CSeries', {id: id, action: 'delete'}, function (data) {
                        console.log(data);
                        table.ajax.reload(null, false);
                        var json = JSON.parse(data);
                        $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});

                    });

                });

    }
    function loadTicket(id)
    {
        console.log(id);
        $("#ticket").html("Loading.....");
        $.post("<?= api_url ?>/?r=reprintTicket", {game: id}, function (d) {
            var json = JSON.parse(d);
            $("#ticket").html(json.ticket);
        });
    }

</script>
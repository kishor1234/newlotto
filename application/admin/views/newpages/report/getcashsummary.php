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
                        <!--
                                                    </div>
                                                </div>-->
                        <div class="card-body">


                            <div class="card-text">
                                <div class="row">
                                    <div class="col-12">
                                        <form id="myMainForm" name="myMainForm" method="post" action="javascript:void(0)">
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label>Select Retailers</label>
                                                        <select class="form-control select2" name="own" required>
                                                            <?php
                                                            $responseData = $main->jsonRespon(api_url . "/?r=CAddUser", array("action" => "allUser"));
                                                            $json = json_decode($responseData, true);
                                                            foreach ($json as $key => $val) {
                                                                echo "<option value='{$val["userid"]}'>{$val["userid"]}</option>";
                                                            }
                                                            ?>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label>Form Date:</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="far fa-calendar-alt"></i>
                                                                </span>
                                                            </div>
                                                            <input type="date" class="form-control float-right" id="reservation" name="dateform" max="<?= date("Y-m-d"); ?>" required>
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
                                                            <input type="date" class="form-control float-right" id="reservation" name="dateto" max="<?= date("Y-m-d"); ?>" required>
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
                                        <div class="box-body table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Sale</td>
                                                        <td id="sale">0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Claim</td>
                                                        <td id="claim">   0.00 </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pay Amount</td>
                                                        <td id="pa">
                                                            0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right">Total Amount</td>
                                                        <td><strong id="ta">0.00</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right">Commision</td>
                                                        <td><strong id="cm">0.00</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right">Net to Pay</td>
                                                        <td><strong id="np">0.00</strong></td>
                                                    </tr>

                                                </tbody>

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
                    url: '<?= api_url ?>/?r=cashSummery',
                    dataType: "json",
                    data: json,
                    success: function (obj) {

                        $("#sale").html(obj.sale);
                        $("#claim").html(obj.claim);
                        $("#pa").html(obj.pa);
                        $("#ta").html(obj.ta);
                        $("#cm").html(obj.cm);
                        $("#np").html(obj.np);
                        
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
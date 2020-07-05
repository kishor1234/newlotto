<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Content Header (Page header) -->
    <?= $main->isLoadView(array("header" => "webheader", "main" => "banner", "footer" => "webfooter", "error" => "page_404"), false, array("title" => $title, "link" => $link)); ?>
    <!-- /.content-header -->
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Users</span>
                            <a href="javascript:void(0)" onclick="clickOnLink('/?r=dashboard&v=user', '#app-container', false)" class="nav-link">
                                <span class="info-box-number" id="compaines">

                                </span>
                            </a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-code"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Lotto Series</span>
                            <a href="javascript:void(0)" onclick="clickOnLink('/?r=dashboard&v=series', '#app-container', false)" class="nav-link">
                                <span class="info-box-number" id="colleges"></span>
                            </a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-play"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Game</span>
                            <a href="javascript:void(0)" class="nav-link"> <span class="info-box-number" id="students">1</span></a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Result Percentage</span>
                            <a href="javascript:void(0)" class="nav-link" data-toggle="modal" onclick="$('#myMainResultPer')[0].reset();" data-target="#myMain"><span class="info-box-number" id="per"></span></a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <div class="row">
                <style>
                    #center{
                        text-align: center;
                        margin-left: auto;
                        margin-right: auto;
                    }
                </style>
                <div class="col-8 offset-2">
                    <div id="center">
                        <?php
                        $result = $main->adminDB[$_SESSION["db_1"]]->query($main->ask_mysqli->select("admin", $_SESSION["db_1"]));
                        $row = $result->fetch_assoc();
                        if ((int) $row["cron"] == 0) {
                            ?>
                            <h1>Click Button to Start Result</h1>
                            <button class="btn btn-success" onclick="ResultServices(1)"><i class="fa fa-star"></i> Start</button>
                            <?php
                        } else {
                            ?>
                            <h1>Click Button to Stop Result</h1>
                            <button class="btn btn-danger" onclick="ResultServices(0)"><i class="fa fa-stop"></i> Stop</button>

                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>

<div class="modal fade preview-modal" data-backdrop="" id="myMain" role="dialog" aria-labelledby="preview-modal" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Result Percentage</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form action="#" method="post" id="myMainResultPer">
                            <div class="form-group">
                                <label class="form-control-label">Result Percentage <span class="text-danger">*</span></label>
                                <input type="text" name="resultper" id="resultper" placeholder="Enter Message" title="Message" required autocomplete="off" class="form-control">
                                <span id="error_name" class=""></span>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Result Min/Max <span class="text-danger">*</span></label>
                                <select name="min" id="min" placeholder="Result Min/Max" title="Result Min/Max" required autocomplete="off" class="form-control">
                                    <option value="0">Minimum</option>
                                    <option value="1">Maximum</option>
                                </select>
                                <span id="error_name" class=""></span>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="action" id="action" value="updateper">
                                <input type="hidden" id="id" name="id" value="<?= $_SESSION["id"] ?>">
                                <button class="btn btn-primary btn-sm form-control" id="myMainSubmitPer">Update</button>
                            </div>
                        </form>
                    </div>
                </div>

                <br>
                <div class="progress" id="progress">
                    <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" id="inner-progress mainpro1">Please wait....</div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
<script>
    $("document").ready(function () {
        report();
        $("#myMainResultPer").submit(function () {
            $("#myMainSubmitPer").attr("disabled", true);
            var formdata = new FormData($("#myMainResultPer")[0]);
            $.ajax({
                url: '<?= api_url ?>/?r=CAddUser',
                type: 'post',
                data: formdata,
                enctype: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                xhr: function () {
                    $("#mainloadimg").show();
                    $("#progress").show();
                    var xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function (e) {
                        var progressbar = Math.round((e.loaded / e.total) * 100);
                        $("#mainpro1").css('width', progressbar + '%');
                        $("#mainpro1").html(progressbar + '%');
                    });
                    return xhr;
                },
                success: function (data) {
                    console.log(data);
                    $("#myMainSubmit").attr("disabled", false);
                    $("#mainloadimg").hide();
                    var json = JSON.parse(data);
                    if (json.status === 1) {
                        swal("Success", json.message, "success");


                    } else {
                        swal("Error", json.message, "error");
                    }
                    $('#myMainResultPer')[0].reset();
                    $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});
                    $("#mainpro1").css('width', '0%');
                    $("#mainpro1").html('0%');
                    $("#progress").hide();
                    report();
                },
                error: function (xhr, error, code)
                {
                    console.log(xhr);
                    console.log(code);
                }
            });
            return false;
        });
    });
    function report() {
        $.post("<?= api_url ?>?r=CAddUser", {action: "adminBalance"}, function (data) {
            console.log(data);
            var js = JSON.parse(data);
            $("#compaines").html(js[1]);
            $("#colleges").html(js[0]);
            $("#students").html(js[2]);
            $("#exams").html(js[3]);
            if (js[5] === "1") {
                $("#per").html(js[4] + "%(Max)" );
            } else {
                $("#per").html(js[4] + "%(Min)" );
            }
        });
    }
    function ResultServices(id)
    {
        $.post("<?= api_url ?>?r=CStartorStop", {cron: id}, function (data) {
            $("#center").html(data);
        });
    }
</script>

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
                <div class="col-lg-12">
                    <div id="dp"></div>
                    <div class="card card-primary">
                        <div class="card-header with-border">
                            <h2 class="card-title">Lotto Set Result</h2>
                        </div>
                        <div class="card-body">
                            <form action="javascript:void(0)" method="post" class="form-horizontal" onsubmit="return formPost('#myid', '<?php echo $obj->encdata("C_SetLotoResult"); ?>', '#dp')" id="myid">
                                <div class=" row form-group">
                                    <div class="col-lg-3">
                                        <label><strong>Select Draw</strong>*</label>
                                        <input type="text" id="series" list="serieslist"  name="series" class="form-control">
                                        <datalist id="serieslist">
                                            <?php
                                            $result = $main->adminDB[$_SESSION["db_1"]]->query($main->ask_mysqli->select("gameseries", $_SESSION["db_1"]));
                                            while ($row = $result->fetch_assoc()) {
                                                echo"<option>" . $row["series"] . "</option>";
                                            }
                                            ?>
                                        </datalist>
                                    </div>
                                    <div class="col-lg-3">
                                        <label><strong>Select Draw</strong>*</label>
                                        <input type="text" id="gameid" list="did" required onkeyup="getDrawLoto('#gameid', '#did')" name="gameid" class="form-control">
                                        <datalist id="did">
                                            <?php
                                            $sql = $main->ask_mysqli->select("gametime", $_SESSION["db_1"]) . $main->ask_mysqli->whereSinglelessthanequal(array("stime" => date("H:i:s"))) . $main->ask_mysqli->orderBy("DESC", "id") . $main->ask_mysqli->limitWithOutOffset(1);
                                            $result = $main->adminDB[$_SESSION["db_1"]]->query($sql);
                                            while ($row = $result->fetch_assoc()) {
                                                echo"<option>" . $row["id"] . "|" . $row["stime"] . "|" . $row["etime"] . "" . "</option>";
                                            }
                                            ?>
                                        </datalist>
                                    </div>
                                    <div class="col-lg-3">
                                        <label><strong>Start Time</strong>*</label>
                                        <input type="text" id="stime" name="stime" required readonly="" class="form-control">
                                    </div>
                                    <div class="col-lg-3">
                                        <label><strong>End Time</strong>*</label>
                                        <input type="text" id="etime" name="etime" required="" readonly="" class="form-control">
                                    </div>

                                    <div class="col-lg-1">
                                        &nbsp;
                                    </div>
                                    <?php
                                    for ($i = 0; $i < 10; $i++) {
                                        ?>
                                        <div class="col-lg-1">
                                            <label id="label label-primary" style="margin-left:15px;"><strong><?php echo $i; ?></strong>*</label>
                                            <input required style="height:20px; width:40px; margin:1px; padding:1px; border-radius: 5px; text-align:center; border-color: #FFAAD2; color:red; font-size: 20px;" type="text" maxlength="2" onkeypress="return isNumber(event)" name="<?php echo $i; ?>" id="<?php echo $i; ?>" class="form-control">
                                        </div>

                                        <?php
                                    }
                                    ?>
                                    <div class="col-lg-1">
                                        &nbsp;
                                    </div>
                                    <div class="col-lg-12">
                                        <label>&nbsp;</label>
                                        <input type="submit"  class="btn btn-success bnt-sm form-control">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="box-footer">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <legend>Total Load of Selected Draw</legend>
                    <div id="display" style="overflow: auto;">

                    </div>
                </div>
            </div>

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
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
                    //console.log(data);
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
            $("#per").html(js[4] + "%");
        });
    }
    function getDrawLoto(id, list) {

        var val = $(id).val();
        var opts = $(list).children();//.childNodes;
        for (var i = 0; i < opts.length; i++) {
            if (opts[i].value === val) {
                var res = opts[i].value.split("|");
                $("#gameid").val(res[0]);
                $("#stime").val(res[1]);
                $("#etime").val(res[2]);
                $.post("/?r=<?php echo $obj->encdata("C_GetDrawLoadLoto"); ?>", {id: res[0], series: $("#series").val()}, function (d) {
                    //console.log(d);
                    $("#display").html(d);
                });
                break;
            }
        }
    }
    function formPost(id, file, display)
    {

        var formData = new FormData($(id)[0]);
        onLoading();
        $.ajax({
            type: "POST",
            url: '/?r=' + file,
            data: formData, //$("#studetnReg").serialize(), // serializes the form's elements.,
            contentType: false,
            processData: false,
            success: function (data)
            {
                console.log(data);
                //alert(data);
                offLoading();
                $(display).html(data);
                printMsg("#msg");
                //alert(data); // show response from the php script.
            }

        });

        $(id)[0].reset();
        return false;
    }
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;

        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            //alert("Only Number Accept");
            return false;
        }
        return true;
    }
    function printMsg(msg)
    {
        $.post("/?r=<?php echo $obj->encdata("C_PrintMsg"); ?>", {}, function (data) {
            $(msg).html(data);
        });
    }

</script>

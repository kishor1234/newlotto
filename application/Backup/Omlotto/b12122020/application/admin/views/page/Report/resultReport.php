
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><?= $title ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <?php
                        foreach ($link as $key => $val) {

                            echo "<li class=\"breadcrumb-item active\"><a href=\"{$val}\">$key</a></li>";
                        }
                        ?>

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h5 class="card-title">Download Exam Attending Report</h5>
                        </div>
                        <div class="card-body" id="form">
                            <form action="#" method="post" name="downloadReport" id="downloadReport"> 
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label class="form-control-label" for="clg">Result Status <small class="text-danger">*</small></label>
                                        <select  id="clg"  onchange="loadExamList()" class="form-control" placeholder="Type Exma Name" title="Exam list" required="">
                                            <option value="">----Select---</option>
                                            <option value="company">company</option>
                                            <option value="college">college</option>

                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="form-control-label" for="exam">Select Exam <small class="text-danger">*</small></label>
                                        <input type="text" list="examList" oninput="return getExam('#exam','#examList')" id="exam" name="exam" class="form-control" placeholder="Type Exma Name" title="Exam list" required="">
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="form-control-label" for="result">Result Status <small class="text-danger">*</small></label>
                                        <select  id="result" name="result" class="form-control" placeholder="Type Exma Name" title="Exam list" required="">
                                            <option value="">Result Status</option>
                                            <option value="Pass">Pass</option>
                                            <option value="Fail">Fail</option>
                                            <option value="ALL">ALL</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="hidden" id="examid" name="examid">
                                        <input type="hidden" id="action" name="action" value="viewReport">
                                        <label class="form-control-label" for="result">&nbsp;</label>
                                        <button type="submit" id="submit" class="btn btn-dark form-control">Download</button>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <style>
                        #progress-sheet{
                            display: none;
                        }
                        #dexcel{
                            display: none;
                        }
                    </style>
                    <div class="progress" id="progress-sheet">
                        <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" id="inner-progress pro1 sheetpro1">Please wait....</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <form action="/?r=DownloadExcel" method="post" target="blank" id="dexcel">
                    <input type="hidden" name="data" id="data">
                    <button type="submit" class="btn btn-dark">Download Excel</button>
                </form>
            </div>
            <datalist id="examList">

            </datalist>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<script>
    $("document").ready(function () {

        //loadExamList();
        $("#downloadReport").submit(function (e) {
            console.log("Submit Occur");
            e.preventDefault();
            $("#dexcel").hide();
            var formdata = new FormData($("#downloadReport")[0]);
            $.ajax({
                url: '<?= api_url ?>/?r=CExamReport',
                type: 'post',
                data: formdata,
                enctype: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                xhr: function () {
                    $("#loadimg").show();
                    $("#progress-sheet").show();
                    var xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function (e) {
                        var progressbar = Math.round((e.loaded / e.total) * 100);
                        $("#sheetpro1").css('width', progressbar + '%');
                        $("#sheetpro1").html(progressbar + '%');
                    });
                    return xhr;
                },
                success: function (data) {
                    console.log(data);
                    $("#loadimg").hide();
                    $("#progress-sheet").hide();
                    var json = JSON.parse(data);
                    if (json.status === 1) {
                        swal("Success", json.msg, "success");
                        $("#data").val(data);
                        $("#dexcel").show();
                    } else {
                        swal("Error", json.msg, "error");
                        $("#dexcel").hide();
                    }
                    $('#downloadReport')[0].reset();
                    $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});
                    $("#sheetpro1").css('width', '0%');
                    $("#sheetpro1").html('0%');
                    $("#sheetpro1").hide();

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
    function loadExamList()
    {
        var clg=$("#clg").val();
        $.post("<?= api_url ?>?r=CExamReport", {action: "examlist", companyid: "<?= $_SESSION["id"]; ?>", postby: clg}, function (data) {
            //console.log(data);
            var option = "";
            $.each(JSON.parse(data), function (index, value) {
                //console.log(value);
                option += "<option>" + value["id"] + "|" + value["title"] + "</option>"
            });
            $("#examList").html(option);
        });
    }
    function getExam(id, list)
    {
        var val = $(id).val();
        var opts = $(list).children();//.childNodes;
        for (var i = 0; i < opts.length; i++) {
            if (opts[i].value === val) {
                var s = opts[i].value.split("|");
                $(id).val(s[1]);
                $("#examid").val(s[0]);
                break;
            }
        }
    }
</script>
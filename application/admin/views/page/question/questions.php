<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark breadcrumb"><?= $title ?></h1>
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
    <style>
        #cplab{
            text-transform: capitalize; 
        }
    </style>
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title mb-2">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" onclick="resetform();" data-target="#myQuestion">
                                    Add New <i class="fas fa-plus"></i>
                                </button>

                                <!-- The Modal -->
                                <div class="modal fade preview-modal" data-backdrop="" id="myQuestion" role="dialog" aria-labelledby="preview-modal" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Questions</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <form action="#" method="post" id="myForm">
                                                            <div class="row form-group">
                                                                <div class="col-lg-12">
                                                                    <label class="form-control-label">Select Subject <span class="text-danger">*</span></label>
                                                                    <input type="text" name="subject" list="slist" id="subject" placeholder="Type to select subject" title="Suject" required="" autocomplete="off" class="form-control">
                                                                    <span id="error_email" class=""></span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-control-label">Question <span class="text-danger">*</span></label>
                                                                <textarea class="codemirror-textarea"  id="question">

                                                                </textarea>  
                                                                <input type="hidden" name="question"  id="desc">
                                                                <span id="error_question" class=""></span>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-lg-6">
                                                                    <label class="form-control-label">Select No of Option on Above Question<span class="text-danger">*</span></label>
                                                                    <select name="nooption" id="nooption" class="form-control">
                                                                        <option value="">---Select---</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                        <option value="6">6</option>
                                                                        <option value="7">7</option>
                                                                        <option value="8">8</option>
                                                                        <option value="9">9</option>
                                                                        <option value="10">10</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                </div>
                                                            </div>
                                                            <div class="row form-group" id="optionList">
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-lg-6">
                                                                    <label class="form-control-label">Select Correct Answer <span class="text-danger">*</span></label>
                                                                    <select name="answer" id="answer"  title="Select Correct Answer" required autocomplete="off" class="form-control">
                                                                        <option value="">---Select---</option>
                                                                        <option value="a">A</option>
                                                                        <option value="b">B</option>
                                                                        <option value="c">C</option>
                                                                        <option value="d">D</option>
                                                                    </select>
                                                                    <span id="error_op" class=""></span>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label class="form-control-label">Answer <span class="text-danger">*</span></label>
                                                                    <input type="text"  id="ans" placeholder="Answer" title="Answer" readonly autocomplete="off" class="form-control">
                                                                    <span id="error_ans" class=""></span>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <input type="hidden" name="action" id="action" value="save">
                                                                <input type="hidden" name="id" id="id" value="0">
                                                                <button class="btn btn-primary btn-sm form-control" id="myFormSubmit">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <br>
                                                    <div class="col-lg-12">
                                                        <style>
                                                            #progress-form{
                                                                display: none;
                                                            }
                                                        </style>
                                                        <div class="progress" id="progress-form">
                                                            <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" id="inner-progress pro1 formpro1">Please wait....</div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- Button to Open the Modal -->
                                <button type="button" disabled="true" class="btn btn-primary" data-toggle="modal" onclick="$('#myExcel')[0].reset();" data-target="#mySheet">
                                    Upload Excel Sheet<i class="fas fa-plus"></i>
                                </button>

                                <!-- The Modal -->
                                <div class="modal fade preview-modal" data-backdrop="" id="mySheet" role="dialog" aria-labelledby="preview-modal" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Questions</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">

                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <h5>Download Excel sheet file <a href="/files/company.xls">Download</a></h5>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <style>
                                                            #progress-sheet{
                                                                display: none;
                                                            }
                                                        </style>
                                                        <div class="progress" id="progress-sheet">
                                                            <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" id="inner-progress pro1 sheetpro1">Please wait....</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">

                                                        <form action="#"  method="POST" id="myExcel" name="myExcel" enctype='multipart/form-data'>
                                                            <div class="form mb-3">
                                                                <input type="file" required=""  name="file" accept=".xls,.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                                                <p>Drag your files here or click in this area.</p>
                                                            </div>
                                                            <input type="hidden" name="action" id="action" value="excel">
                                                            <!--
                                                                                                                        <button type="submit" class="btn btn-success form-control">Upload</button>-->

                                                        </form>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-body">


                            <div class="card-text">
                                <table class="stripe hover display responsive nowrap" id="myTable" cellspacing='0'>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Question</th>                                            
                                            <th>A</th>
                                            <th>B</th>
                                            <th>C</th>
                                            <th>D</th>
                                            <th>E</th>
                                            <th>F</th>
                                            <th>G</th>
                                            <th>H</th>
                                            <th>I</th>
                                            <th>J</th>
                                            <th>Answer</th>
                                            <th>Subject</th>
                                            <th>Active</th>
                                            <th>Create</th>
                                            <th class="datatable-nosort">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Question</th>                                            
                                            <th>A</th>
                                            <th>B</th>
                                            <th>C</th>
                                            <th>D</th>
                                            <th>E</th>
                                            <th>F</th>
                                            <th>G</th>
                                            <th>H</th>
                                            <th>I</th>
                                            <th>J</th>
                                            <th>Answer</th>
                                            <th>Subject</th>
                                            <th>Active</th>
                                            <th>Create</th>
                                            <th class="datatable-nosort">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
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
<datalist id="slist">

</datalist>
<!-- /.content-wrapper -->
<script type="text/javascript">
    var table;
    var edit;
    function resetform()
    {
        $('#myForm')[0].reset();
        $("#optionList").html("");
        $("#answer").html("");
    }
    $("document").ready(function () {
        slist();
        CKEDITOR.replace('question', {
            height: 300,
            filebrowserUploadUrl: "upload.php"

        });
        timer = setInterval(updateDiv, 100);
        function updateDiv() {
            var editorText = CKEDITOR.instances.question.getData();
            $('#desc').val(editorText);
        }
        $("#nooption").change(function () {
            var option = $("#nooption").val();
            loadOption(option);
        });

        function slist() {
            $.post('<?= api_url ?>/?r=CQuestions', {id: 0, action: 'slist'}, function (data) {
                console.log(data);
                var json = JSON.parse(data);
                var dp = "";
                for (var i = 0; i < json.length; i++)
                {
                    var m = "<option>" + json[i]["code"] + "</option>";
                    dp = dp + m;
                }
                $("#slist").html(dp);
            });
        }

    });
    var options = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j"];
    function loadOption(opt)
    {
        $("#optionList").html("");
        $("#answer").html("");
        for (var i = 0; i < opt; i++)
        {
            var o = ' <div class="col-lg-6">' +
                    '<label class = "form-control-label" id="cplab"> ' + options[i] + ' <span class = "text-danger"> * </span></label>' +
                    '<input type = "text" name = "' + options[i] + '" id = "' + options[i] + '" placeholder = "Answer ' + options[i] + '" title = "Answer ' + options[i] + '" required autocomplete = "off" class = "form-control" >' +
                    '<span id = "error_' + options[i] + '" class = "" > </span>' +
                    '</div>';
            $("#optionList").append(o);
        }
        $("#answer").append("<option value=''>---Select Answer---</option>");
        for (var i = 0; i < opt; i++) {
            $("#answer").append("<option value='" + options[i] + "'>" + options[i] + "</option>");
        }
    }
    $(document).ready(function () {
        $("#answer").change(function (e) {
            e.preventDefault();
            $("#ans").val($("#" + $("#answer").val() + "").val());
        });
        $('.form input').change(function () {
            //$('.form p').text(this.files.length + " file(s) selected");
            var formdata = new FormData($("#myExcel")[0]);
            $.ajax({
                url: '<?= api_url ?>/?r=CQuestions',
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
                    var json = JSON.parse(data);
                    if (json.status === 1) {
                        swal("Success", json.message, "success");
                    } else {
                        swal("Error", json.message, "error");
                    }
                    $('#myExcel')[0].reset();
                    $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});
                    $("#sheetpro1").css('width', '0%');
                    $("#sheetpro1").html('0%');
                    $("#sheetpro1").hide();
                    table.ajax.reload(null, false);
                    $("#progress-sheet").hide();
                },
                error: function (xhr, error, code)
                {
                    console.log(xhr);
                    console.log(code);
                }
            });
            return false;
        });
        table = $('#myTable').DataTable({
            serverSide: true,
            Processing: true,
            dom: 'Bfrtip',
            order: [[0, "desc"]],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url: '<?= api_url ?>/?r=CQuestions',
                type: "post", // method  , by default get
                dataType: "json",
                data: {action: "loadTable"},
                error: function () {  // error handling
                    $(".data-grid-error").html("");
                    $("#data-grid").append('<tbody class="data-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#data-grid_processing").css("display", "none");
                }
            },
            scrollCollapse: true,
            autoWidth: false,
            responsive: true,
            columnDefs: [{
                    targets: "datatable-nosort",
                    orderable: false
                }],
            lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
            language: {
                info: "_START_-_END_ of _TOTAL_ entries",
                searchPlaceholder: "Search"
            }
        });
        $("#myExcel").submit(function (e) {
            e.preventDefault();
            var formdata = new FormData($("#myExcel")[0]);
            $.ajax({
                url: '<?= api_url ?>/?r=CQuestions',
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
                    } else {
                        swal("Error", json.msg, "error");
                    }
                    $('#myExcel')[0].reset();
                    $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});
                    $("#sheetpro1").css('width', '0%');
                    $("#sheetpro1").html('0%');
                    $("#sheetpro1").hide();
                    table.ajax.reload(null, false);

                },
                error: function (xhr, error, code)
                {
                    console.log(xhr);
                    console.log(code);
                }
            });
            return false;
        });
        $("#myForm").submit(function () {
            $("#myFormSubmit").attr("disabled",true);
            var formdata = new FormData($("#myForm")[0]);
            $.ajax({
                url: '<?= api_url ?>/?r=CQuestions',
                type: 'post',
                data: formdata,
                enctype: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                xhr: function () {
                    $("#loadimg").show();
                    $("#progress-form").show();
                    var xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function (e) {
                        var progressbar = Math.round((e.loaded / e.total) * 100);
                        $("#formpro1").css('width', progressbar + '%');
                        $("#formpro1").html(progressbar + '%');
                    });
                    return xhr;
                },
                success: function (data) {
                    $("#myFormSubmit").attr("disabled",false);
                    console.log(data);
                    $("#loadimg").hide();
                    $("#progress-form").hide();
                    var json = JSON.parse(data);
                    if (json.status === 1) {
                        swal("Success", json.msg, "success");
                    } else {
                        swal("Error", json.msg, "error");
                    }
                    $('#myForm')[0].reset();
                    $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});
                    $("#formpro1").css('width', '0%');
                    $("#formpro1").html('0%');
                    $("#formpro1").hide();
                    table.ajax.reload(null, false);
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
    function editbusiness(id)
    {
        $.post('<?= api_url ?>/?r=CQuestions', {id: id, action: 'select'}, function (data) {
            var json = JSON.parse(data);
            loadOption(json.row["nooption"]);
            $("#nooption").val(json.row["nooption"]).change();
            $("#id").val(json.row["id"]);
            $("#subject").val(json.row["subject"]);
            CKEDITOR.instances['question'].setData(json.row["question"]);

            for (var i = 0; i < json.row["nooption"]; i++)
            {
                $("#" + options[i]).val(json.row[options[i]]);
            }

            $("#ans").val($("#" + json.row["answer"]).val());
            $("#answer").val(json.row["answer"]).change();
            //$("#nooption").val(json.row["nooption"]).change();
            $("#action").val("update");
            $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});
        });
    }
    function deletebusiness(id, st)
    {
        swal({
            title: "Are you sure?",
            text: "want to delete question?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, Delete it!",
            closeOnConfirm: true
        },
        function () {
            $.post('<?= api_url ?>/?r=CQuestions', {id: id, st: st, action: 'delete'}, function (data) {
                console.log(data);
                table.ajax.reload(null, false);
                var json = JSON.parse(data);
                $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});
            });
        });
    }

</script>
<!-- Content Wrapper. Contains page content -->
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
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title mb-2">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" onclick="loadMyForm(); " data-target="#myModal">
                                    Add New <i class="fas fa-plus"></i>
                                </button>

                                <!-- The Modal -->
                                <div class="modal fade preview-modal" data-backdrop="" id="myModal" role="dialog" aria-labelledby="preview-modal" aria-hidden="true">

                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Subject's</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <form action="#" method="post" id="myForm">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Department <span class="text-danger">*</span></label>
                                                                <select required name="course" id="course" class="form-control">

                                                                </select>
                                                                <span id="error_name" class=""></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-control-label">Subject <span class="text-danger">*</span></label>
                                                                <input type="text" name="code" id="code" placeholder="Enter Subject Code." title="Enter Subject code" required autocomplete="off" class="form-control">
                                                                <span id="error_code" class=""></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="hidden" name="action" id="action" value="save">
                                                                <input type="hidden" name="id" id="id" value="0">
                                                                <button class="btn btn-primary btn-sm form-control" id="mySubmit">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="orSec mb-4">
                                                        <span class="ortextNew"><strong>OR</strong></span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <h5>Download Excel sheet file <a href="/files/Subject.xls">Download</a></h5>
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
                                                <br>
                                                <style>
                                                    #progress-subject{
                                                        display: none;
                                                    }
                                                </style>
                                                <div class="progress" id="progress-subject">
                                                    <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" id="inner-progress pro1 subjectpro1">Please wait....</div>
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
                                    Upload Excel sheet <i class="fas fa-plus"></i>
                                </button>

                                <!-- The Modal -->
                                <div class="modal fade preview-modal" data-backdrop="" id="mySheet" role="dialog" aria-labelledby="preview-modal" aria-hidden="true">

                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Subject's</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <h5>Download Excel sheet file <a href="/files/Subject.xls">Download</a></h5>
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
                                                <br>
                                                <style>
                                                    #progress-sheet{
                                                        display: none;
                                                    }
                                                </style>
                                                <div class="progress" id="progress-sheet">
                                                    <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" id="inner-progress pro1 sheetpro1">Please wait....</div>
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
                                            <th>Category</th>                                            
                                            <th>Subject</th>
                                            <th>Crete</th>
                                            <th class="datatable-nosort">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Category</th>                                            
                                            <th>Subject</th>
                                            <th>Crete</th>
                                            <th>Action</th>
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
<!-- /.content-wrapper -->
<script type="text/javascript">
    var table;
    $(document).ready(function () {
        $('.form input').change(function () {
            $('.form p').text(this.files.length + " file(s) selected");
            var formdata = new FormData($("#myExcel")[0]);
            $.ajax({
                url: '<?= api_url ?>/?r=CSubject',
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
                url: '<?= api_url ?>/?r=CSubject',
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

        $("#myExcel").submit(function () {
            var formdata = new FormData($("#myExcel")[0]);
            $.ajax({
                url: '<?= api_url ?>/?r=CSubject',
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
                    $("#loadimg").hide();

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
        $("#mySubmit").attr("disabled",true);
            var formdata = new FormData($("#myForm")[0]);
            $.ajax({
                url: '<?= api_url ?>/?r=CSubject',
                type: 'post',
                data: formdata,
                enctype: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                xhr: function () {
                    $("#loadimg").show();
                    $("#progress-subject").show();
                    var xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function (e) {
                        var progressbar = Math.round((e.loaded / e.total) * 100);
                        $("#subjectpro1").css('width', progressbar + '%');
                        $("#subjectpro1").html(progressbar + '%');
                    });
                    return xhr;
                },
                success: function (data) {
                    console.log(data);
                    $("#mySubmit").attr("disabled",false);
                    $("#progress-subject").hide();
                    var json = JSON.parse(data);
                    if (json.status === 1) {
                        swal("Success", json.msg, "success");


                    } else {
                        swal("Error", json.msg, "error");
                    }
                    $('#myForm')[0].reset();
                    $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});
                    $("#subjectpro1").css('width', '0%');
                    $("#subjectpro1").html('0%');
                    $("#subjectpro1").hide();
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
    function loadMyForm()
    {
        $('#myForm')[0].reset();
        loadParentid();
    }
    function loadParentid()
    {
        $.post('<?= api_url ?>/?r=CCourse', {id: 0, action: 'loadMain'}, function (data) {
            console.log(data);
            var json = JSON.parse(data);
            var option = "<option value=''>--select---</option>";
            if (json.status === 1)
            {
                for (var i = 0; i < json.data.length; i++)
                {
                    option += "<option value='" + json.data[i]['id'] + "'>" + json.data[i]['name'] + "</option>";
                }
            }
            $("#course").html(option);
            $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});

        });
    }
    function editbusiness(id)
    {
        $.post('<?= api_url ?>/?r=CSubject', {id: id, action: 'select'}, function (data) {
            console.log(data);
            var json = JSON.parse(data);
            $("#id").val(json.row["id"]);
            $("#name").val(json.row["name"]);
            $("#code").val(json.row["code"]);
            $("#action").val("update");
            $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});

        });
    }
    function deletebusiness(id, st)
    {
        swal({
            title: "Are you sure?",
            text: "want to delete subject?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, Suspeded it!",
            closeOnConfirm: true
        },
        function () {
            $.post('<?= api_url ?>/?r=CSubject', {id: id, st: st, action: 'delete'}, function (data) {
                console.log(data);
                table.ajax.reload(null, false);
                var json = JSON.parse(data);
                $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});

            });

        });
    }
    function actionOnBusiness(id, st)
    {
        if (st == 0) {
            swal({
                title: "Are you sure?",
                text: "Your will Active Account by Admin",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, Suspeded it!",
                closeOnConfirm: false
            },
            function () {
                $.post("/?r=<?= $obj->encdata("C_SaveBusiness") ?>", {id: id, st: st, action: 'actionOnBusiness'}, function (data) {
                    console.log(data);
                    table.ajax.reload(null, false);
                    swal("Suspended!", "Account Has been suspeded", "success");
                });

            });
        } else {
            swal({
                title: "Are you sure?",
                text: "Want to Active Business account",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, Active it!",
                closeOnConfirm: false
            },
            function () {
                $.post("/?r=<?= $obj->encdata("C_SaveBusiness") ?>", {id: id, st: st, action: 'actionOnBusiness'}, function (data) {
                    console.log(data);
                    table.ajax.reload(null, false);
                    swal("Activeted!", "Account Has been suspeded", "success");
                });

            });
        }

    }
</script>
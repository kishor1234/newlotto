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
                                <button type="button" class="btn btn-primary" data-toggle="modal" onclick="$('#myForm')[0].reset();" data-target="#myModal">
                                    Add New <i class="fas fa-plus"></i>
                                </button>

                                <!-- The Modal -->
                                <div class="modal fade preview-modal" data-backdrop="" id="myModal" role="dialog" aria-labelledby="preview-modal" aria-hidden="true">

                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">College</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <form action="#" method="post" id="myForm">
                                                            <div class="row form-group">
                                                                <div class="col-lg-6">
                                                                    <label class="form-control-label">college Name <span class="text-danger">*</span></label>
                                                                    <input type="text" name="college" id="college" placeholder="Enter college name." title="Enter college name" required autocomplete="off" class="form-control">
                                                                    <span id="error_college" class=""></span>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label class="form-control-label">University <span class="text-danger">*</span></label>
                                                                    <input type="text" name="uni" id="uni" list="ulist" placeholder="Enter University." title="Enter University" required autocomplete="off" class="form-control">
                                                                    <span id="error_uni" class=""></span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-control-label">Address <span class="text-danger">*</span></label>
                                                                <input type="text" name="address" id="address" placeholder="Enter address." title="Enter address" required autocomplete="off" class="form-control">
                                                                <span id="error_address" class=""></span>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-lg-6">
                                                                    <label class="form-control-label">State <span class="text-danger">*</span></label>
                                                                    <input type="text" name="state" id="state" placeholder="Enter state." title="Enter state" required autocomplete="off" class="form-control">
                                                                    <span id="error_state" class=""></span>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label class="form-control-label">Dist <span class="text-danger">*</span></label>
                                                                    <input type="text" name="dist" id="dist" placeholder="Enter district." title="Enter district" required autocomplete="off" class="form-control">
                                                                    <span id="error_dist" class=""></span>
                                                                </div>
                                                            </div>

                                                            <div class="row form-group">
                                                                <div class="col-lg-6">
                                                                    <label class="form-control-label">City <span class="text-danger">*</span></label>
                                                                    <input type="text" name="city" id="city" placeholder="Enter city." title="Enter city" required autocomplete="off" class="form-control">
                                                                    <span id="error_city" class=""></span>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label class="form-control-label">PIN <span class="text-danger">*</span></label>
                                                                    <input type="text" name="pin" id="pin" maxlength="6" placeholder="Enter PIN" title="Enter PIN" required autocomplete="off" class="form-control">
                                                                    <span id="error_pin" class=""></span>
                                                                </div>
                                                            </div>

                                                            <div class="row form-group">
                                                                <div class="col-lg-6">
                                                                    <label class="form-control-label">Mobile <span class="text-danger">*</span></label>
                                                                    <input type="text" name="mobile" id="mobile" maxlength="10" placeholder="Enter Mobile no" title="Enter Mobile no" required autocomplete="off" class="form-control">
                                                                    <span id="error_mobile" class=""></span>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label class="form-control-label">Email <span class="text-danger">*</span></label>
                                                                    <input type="email" name="email" id="email" placeholder="Enter Email" title="Enter Email" required autocomplete="off" class="form-control">
                                                                    <span id="error_email" class=""></span>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-lg-12">
                                                                    <span><input type="radio" name="isActive" id="deactive" class="radio-inline" value="0">&nbsp;De-Active</span>&nbsp;
                                                                    <span><input type="radio" name="isActive" id="active" class="radio-inline" value="1">&nbsp;Active</span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="hidden" name="action" id="action" value="save">
                                                                <input type="hidden" name="id" id="id" value="0">
                                                                <button class="btn btn-primary btn-sm form-control">Save</button>
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
                                                    <br>
                                                    <div class="progress" id="progress">
                                                        <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" id="inner-progress pro1">Please wait....</div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <h5>Download Excel sheet file <a href="/files/college.xls">Download</a></h5>
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
                                            <th>Name</th>                                            
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Location</th>
                                            <th>IP</th>
                                            <th class="datatable-nosort">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>                                            
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Location</th>
                                            <th>IP</th>
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
<datalist id="ulist">

</datalist>
<!-- /.content-wrapper -->
<script type="text/javascript">
    var table;
    $(document).ready(function () {
        unilist();
        $('.form input').change(function () {
            //$('.form p').text(this.files.length + " file(s) selected");
            var formdata = new FormData($("#myExcel")[0]);
            $.ajax({
                url: '<?= api_url ?>/?r=CCollege',
                type: 'post',
                data: formdata,
                enctype: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                xhr: function () {
                    $("#loadimg").show();
                    $("#progress").show();
                    var xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function (e) {
                        var progressbar = Math.round((e.loaded / e.total) * 100);
                        $("#pro1").css('width', progressbar + '%');
                        $("#pro1").html(progressbar + '%');
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
                    $("#pro1").css('width', '0%');
                    $("#pro1").html('0%');
                    $("#pro1").hide();
                    table.ajax.reload(null, false);
                    $("#progress").hide();

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
                url: '<?= api_url ?>/?r=CExamReport',
                type: "post", // method  , by default get
                dataType: "json",
                data: {action: "student"},
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
                url: '<?= api_url ?>/?r=CCollege',
                type: 'post',
                data: formdata,
                enctype: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                xhr: function () {
                    $("#loadimg").show();
                    $("#progress").show();
                    var xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function (e) {
                        var progressbar = Math.round((e.loaded / e.total) * 100);
                        $("#pro1").css('width', progressbar + '%');
                        $("#pro1").html(progressbar + '%');
                    });
                    return xhr;
                },
                success: function (data) {
                    console.log(data);
                    $("#loadimg").hide();
                    $("#progress").hide();
                    var json = JSON.parse(data);
                    if (json.status === 1) {
                        swal("Success", json.msg, "success");
                    } else {
                        swal("Error", json.msg, "error");
                    }
                    $('#myExcel')[0].reset();
                    $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});
                    $("#pro1").css('width', '0%');
                    $("#pro1").html('0%');
                    $("#pro1").hide();
                    table.ajax.reload(null, false);
                    $("#progress").hide();

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
            var formdata = new FormData($("#myForm")[0]);
            $.ajax({
                url: '<?= api_url ?>/?r=CCollege',
                type: 'post',
                data: formdata,
                enctype: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                xhr: function () {
                    $("#loadimg").show();
                    $("#progress").show();
                    var xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function (e) {
                        var progressbar = Math.round((e.loaded / e.total) * 100);
                        $("#pro1").css('width', progressbar + '%');
                        $("#pro1").html(progressbar + '%');
                    });
                    return xhr;
                },
                success: function (data) {
                    console.log(data);
                    $("#loadimg").hide();
                    $("#progress").hide();
                    var json = JSON.parse(data);
                    if (json.status === 1) {
                        swal("Success", json.msg, "success");


                    } else {
                        swal("Error", json.msg, "error");
                    }
                    $('#myForm')[0].reset();
                    $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});
                    $("#pro1").css('width', '0%');
                    $("#pro1").html('0%');
                    $("#pro1").hide();
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

    function unilist() {
        $.post('<?= api_url ?>/?r=CCollege', {id: 0, action: 'unilist'}, function (data) {
            console.log(data);
            var json = JSON.parse(data);
            var dp = "";
            for (var i = 0; i < json.length; i++)
            {
                var m = "<option>" + json[i]["name"] + "</option>";
                dp = dp + m;
            }
            $("#ulist").html(dp);
        });
    }
    function editbusiness(id)
    {
        $.post('<?= api_url ?>/?r=CCollege', {id: id, action: 'select'}, function (data) {
            console.log(data);
            var json = JSON.parse(data);
            $("#id").val(json.row["id"]);
            $("#college").val(json.row["college"]);
            $("#address").val(json.row["address"]);
            $("#state").val(json.row["state"]);
            $("#dist").val(json.row["dist"]);
            $("#city").val(json.row["city"]);
            $("#uni").val(json.row["uni"]);
            $("#pin").val(json.row["pin"]);
            $("#mobile").val(json.row["mobile"]);
            $("#email").val(json.row["email"]);
            switch (json.row['isActive'])
            {
                case "0":
                    $("#deactive").prop("checked", true);
                    break;
                case "1":
                    $("#active").prop("checked", true);
                    break;
            }
            $("#action").val("update");
            $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});

        });
    }
    function deletebusiness(id, st)
    {
        swal({
            title: "Are you sure?",
            text: "want to delete College?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, Suspeded it!",
            closeOnConfirm: true
        },
        function () {
            $.post('<?= api_url ?>/?r=CCollege', {id: id, st: st, action: 'delete'}, function (data) {
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
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
                                                <h4 class="modal-title">University</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <form action="#" method="post" id="myForm">
                                                            <div class="row form-group">
                                                                <div class="col-lg-12">
                                                                    <label class="form-control-label">University Name <span class="text-danger">*</span></label>
                                                                    <input type="text" name="name" id="name" placeholder="Enter University name." title="Enter Univeristy name" required autocomplete="off" class="form-control">
                                                                    <span id="error_name" class=""></span>
                                                                </div>

                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-control-label">Address <span class="text-danger">*</span></label>
                                                                <input type="text" name="address" id="address" placeholder="Enter address." title="Enter address" required autocomplete="off" class="form-control">
                                                                <span id="error_address" class=""></span>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-lg-6">
                                                                    <label class="form-control-label">Phone <span class="text-danger">*</span></label>
                                                                    <input type="text" onkeydown="return phoneve(event);" name="phone" id="phone" placeholder="Enter phone." title="Enter phone" required autocomplete="off" class="form-control">
                                                                    <span id="error_phone" class=""></span>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label class="form-control-label">Website <span class="text-danger">*</span></label>
                                                                    <input type="text" name="website" id="website" placeholder="Enter Website." title="Enter Website" required autocomplete="off" class="form-control">
                                                                    <span id="error_website" class=""></span>
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
                                                    <div class="col-lg-12">
                                                        <div class="progress" id="progress">
                                                            <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" id="inner-progress pro1">Please wait....</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <h5>Download Excel sheet file <a href="/files/university.xls">Download</a></h5>
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
                                            <th>University Name</th>                                            
                                            <th>Address</th>
                                            <th>PHone</th>
                                            <th>Website</th>
                                            <th>Create</th>
                                            <th class="datatable-nosort">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>University Name</th>                                            
                                            <th>Address</th>
                                            <th>PHone</th>
                                            <th>Website</th>
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
<!-- /.content-wrapper -->
<script type="text/javascript">
    function phoneve(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        //alert(charCode);
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            $("#error_phone").removeClass("text-success");
            $("#error_phone").addClass("text-danger");
            $("#error_phone").val("Invalid number");
            return false;
        }
        $("#error_phone").val("Success..!");
        $("#error_phone").addClass("text-success");
        $("#error_phone").removeClass("text-danger");
        return true;
    }
    $("#website").keyup(function (e) {
        e.preventDefault();
        var url_validate = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
        if (url_validate.test($("#website").val())) {
            $("#error_website").addClass("text-success");
            $("#error_website").removeClass("text-danger");
            $("#error_website").html("valid URL");
        } else {
            $("#error_website").removeClass("text-success");
            $("#error_website").addClass("text-danger");
            $("#error_website").html("Invalid URL");
        }
    });

    var table;
    $(document).ready(function () {
        $('.form input').change(function () {
            //$('.form p').text(this.files.length + " file(s) selected");
            var formdata = new FormData($("#myExcel")[0]);
            $.ajax({
                url: '<?= api_url ?>/?r=CCUniversity',
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
                url: '<?= api_url ?>/?r=CCUniversity',
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
                url: '<?= api_url ?>/?r=CCUniversity',
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
                url: '<?= api_url ?>/?r=CCUniversity',
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

    function editbusiness(id)
    {
        $.post('<?= api_url ?>/?r=CCUniversity', {id: id, action: 'select'}, function (data) {
            console.log(data);
            var json = JSON.parse(data);
            $("#id").val(json.row["id"]);
            $("#name").val(json.row["name"]);
            $("#address").val(json.row["address"]);
            $("#phone").val(json.row["phone"]);
            $("#website").val(json.row["website"]);
            $("#action").val("update");
            $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});

        });
    }
    function deletebusiness(id, st)
    {
        swal({
            title: "Are you sure?",
            text: "want to delete comapny?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, Delete it!",
            closeOnConfirm: true
        },
        function () {
            $.post('<?= api_url ?>/?r=CCUniversity', {id: id, st: st, action: 'delete'}, function (data) {
                console.log(data);
                table.ajax.reload(null, false);
                var json = JSON.parse(data);
                $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});

            });

        });
    }

</script>
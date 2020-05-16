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
                        <div class="card-header">
                            <div class="card-title mb-2">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" onclick="$('#myMainForm')[0].reset();" data-target="#myMain">
                                    Add New User <i class="fas fa-plus"></i>
                                </button>
                                <div class="modal fade preview-modal" data-backdrop="" id="myMain" role="dialog" aria-labelledby="preview-modal" aria-hidden="true">

                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Add New User </h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <form action="#" method="post" id="myMainForm">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Name <span class="text-danger">*</span></label>
                                                                <input type="text" name="name" id="name" placeholder="Enter user name." title="Enter user name" required autocomplete="off" class="form-control">
                                                                <span id="error_name" class=""></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-control-label">Mobile No. <span class="text-danger">*</span></label>
                                                                <input type="text" name="mobileno" id="mobileno" maxlength="10" onkeypress="return isNumber(event);" placeholder="Enter Mobile No." title="Enter Mobile No." required autocomplete="off" class="form-control">
                                                                <span id="error_name" class=""></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-control-label">Commission Percentage % (Ex 5% than put 0.05%) <span class="text-danger">*</span></label>
                                                                <input type="number" step="0.01" max="0.3" min="0" name="comission" id="comission" placeholder="Enter user Commission Percenatage Ex 5% than put 0.05" title="Commission Percenatage" required autocomplete="off" class="form-control">
                                                                <span id="error_name" class=""></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-control-label">Device </label>
                                                                <input type="text" name="device" id="device" placeholder="Enter Device MAC" title="Enter Device MAC" autocomplete="off" class="form-control">
                                                                <span id="error_name" class=""></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="hidden" name="action" id="action" value="addUser">
                                                                <input type="hidden" name="id" id="id" value="0">
                                                                <button class="btn btn-primary btn-sm form-control" id="myMainSubmit">Save</button>
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
                                <div class="modal fade preview-modal" data-backdrop="" id="myPoint" role="dialog" aria-labelledby="preview-modal" aria-hidden="true">

                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">User Point Add/Remove </h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <form action="#" method="post" id="myPointForm">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Name <span class="text-danger">*</span></label>
                                                                <input type="text"  id="name" placeholder="Enter user name." title="Enter user name" required autocomplete="off" class="form-control">
                                                                <span id="error_name" class=""></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-control-label">Total Point <span class="text-danger">*</span></label>
                                                                <input type="text" name="point" id="point" maxlength="5" onkeypress="return isNumber(event);" placeholder="Enter Mobile No." title="Enter Mobile No." required autocomplete="off" class="form-control">
                                                                <span id="error_name" class=""></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="text" name="action" id="action" value="putPoint">
                                                                <input type="text" name="id" id="id" value="0">
                                                                <button class="btn btn-primary btn-sm form-control" id="myPointSubmit">Send Command</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                                <br>
                                                <div class="progress" id="progressPoint">
                                                    <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" id="inner-progress pointpro1">Please wait....</div>
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
                                            <th>User Id</th>
                                            <th>Password</th>
                                            <th>Name</th>
                                            <th>Mobile No.</th>
                                            <th>Balance</th>
                                            <th>Device</th>
                                            <th>IP</th>
                                            <th>Status</th>
                                            <th>Create Date</th>
                                            <th>Last Update</th>
                                            <th class="datatable-nosort">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>User Id</th>
                                            <th>Password</th>
                                            <th>Name</th>
                                            <th>Mobile No.</th>
                                            <th>Balance</th>
                                            <th>Device</th>
                                            <th>IP</th>
                                            <th>Status</th>
                                            <th>Create Date</th>
                                            <th>Last Update</th>
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
    var table;
    $(document).ready(function () {
        table = $('#myTable').DataTable({
            serverSide: true,
            Processing: true,
            dom: 'Bfrtip',
            order: [[0, "desc"]],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url: '<?= api_url ?>/?r=CAddUser',
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
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            language: {
                info: "_START_-_END_ of _TOTAL_ entries",
                searchPlaceholder: "Search"
            }
        });
        $("#myMainForm").submit(function () {
            $("#myMainSubmit").attr("disabled", true);
            var formdata = new FormData($("#myMainForm")[0]);
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
                        swal("Success", json.msg, "success");


                    } else {
                        swal("Error", json.msg, "error");
                    }
                    $('#myMainForm')[0].reset();
                    $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});
                    $("#mainpro1").css('width', '0%');
                    $("#mainpro1").html('0%');
                    $("#progress").hide();
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
        $("#myPointForm").submit(function () {
            $("#myPointSubmit").attr("disabled", true);
            var formdata = new FormData($("#myPointForm")[0]);
            $.ajax({
                url: '<?= api_url ?>/?r=CAddUser',
                type: 'post',
                data: formdata,
                enctype: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                xhr: function () {
                    $("#pointloadimg").show();
                    $("#progressPoint").show();
                    var xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function (e) {
                        var progressbar = Math.round((e.loaded / e.total) * 100);
                        $("#pointpro1").css('width', progressbar + '%');
                        $("#pointpro1").html(progressbar + '%');
                    });
                    return xhr;
                },
                success: function (data) {
                    console.log(data);
                    $("#myPointSubmit").attr("disabled", false);
                    $("#pointloadimg").hide();
                    var json = JSON.parse(data);
                    if (json.status === 1) {
                        swal("Success", json.msg, "success");


                    } else {
                        swal("Error", json.msg, "error");
                    }
                    $('#myPointForm')[0].reset();
                    $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});
                    $("#pointpro1").css('width', '0%');
                    $("#pointpro1").html('0%');
                    $("#progressPoint").hide();
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

    function deleteFullAccount(id, st)
    {
        swal({
            title: "Are you sure?",
            text: "want to delete Full Acount?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, Delete it!",
            closeOnConfirm: true
        },
        function () {
            $.post('<?= api_url ?>/?r=CAddUser', {id: id, action: 'delete'}, function (data) {
                console.log(data);
                table.ajax.reload(null, false);
                var json = JSON.parse(data);
                $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});
                table.ajax.reload(null, false);
            });

        });
    }
    function editAccount(id, name, mobile, commision, device)
    {
        $("#myMain").modal("show");
        $("#name").val(name);
        $("#mobileno").val(mobile);
        $("#comission").val(commision);
        $("#device").val(device);
        $("#id").val(id);
        $("#action").val("update");
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
    function putPoint(id, name, point)
    {
        swal({
            title: "Put Point for User",
            text: "Enter point to send user.",
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            inputPlaceholder: "Write something"
        }, function (inputValue) {
            if (inputValue === false)
                return false;
            if (inputValue === "") {
                swal.showInputError("You need to write something!");
                return false;
            }
            if ($.isNumeric(inputValue))
            {
                $.post('<?= api_url ?>/?r=CAddUser', {userid: id, point: inputValue, action: 'putPoint'}, function (data) {
                    console.log(data);
                    var json = JSON.parse(data);
                    if (json.status === 1)
                    {
                        swal("Success", json.message, "success");
                    } else {
                        swal("Error", json.message, "error");
                    }
                    $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});
                    table.ajax.reload(null, false);

                });
            } else {
                //swal("Error", json.msg, "error");
                swal("Error", "You wrote wrong value: " + inputValue, "error");
            }

            //
        });
    }

    function getPoint(id, name, point)
    {
        swal({
            title: "Get Point Form  User",
            text: "Enter point to send user.",
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            inputPlaceholder: "Write something"
        }, function (inputValue) {
            if (inputValue === false)
                return false;
            if (inputValue === "") {
                swal.showInputError("You need to write something!");
                return false;
            }
            if ($.isNumeric(inputValue))
            {
                $.post('<?= api_url ?>/?r=CAddUser', {userid: id, point: inputValue, action: 'getPoint'}, function (data) {
                    console.log(data);
                    var json = JSON.parse(data);
                    if (json.status === 1)
                    {
                        swal("Success", json.message, "success");
                    } else {
                        swal("Error", json.message, "error");
                    }
                    $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});
                    table.ajax.reload(null, false);

                });
            } else {
                //swal("Error", json.msg, "error");
                swal("Error", "You wrote wrong value: " + inputValue, "error");
            }

            //
        });
    }
    function suspendAccount(id, status)
    {
        var msg = "";
        if (status === 1)
        {
            msg = "want to Active Account?";
        } else {
            msg = "want to Suspend Account?";
        }
        swal({
            title: "Are you sure?",
            text: msg,
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, Do it!",
            closeOnConfirm: true
        },
        function () {
            $.post('<?= api_url ?>/?r=CAddUser', {id: id, is_active: status, action: 'suspend'}, function (data) {
                console.log(data);
                table.ajax.reload(null, false);
                var json = JSON.parse(data);
                $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});
                table.ajax.reload(null, false);
            });

        });
    }
</script>
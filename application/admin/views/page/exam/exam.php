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

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title mb-2">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" onclick="clickOnLink('/?r=dashboard&v=createcompanyexam', '#app-container', false)">
                                    Add New Exam for Company <i class="fas fa-plus"></i>
                                </button>
                                <button type="button" class="btn btn-primary" onclick="clickOnLink('/?r=dashboard&v=createcollegeexam', '#app-container', false)">
                                    Add New Exam for College <i class="fas fa-plus"></i>
                                </button>

                                <div class="modal fade preview-modal" data-backdrop="" id="editExam" role="dialog" aria-labelledby="preview-modal" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Exam</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <form action="#" method="post" id="myForm">
                                                    <div class="row form-group">
                                                        <div class="col-lg-6">
                                                            <label class="form-control-label">Select Company <span class="text-danger">*</span></label>
                                                            <select id="compnayid"  name="companyid" class="form-control" required="" title="company id">

                                                            </select>
                                                            <span id="error_companyid" class=""></span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label class="form-control-label">Exam Title <span class="text-danger">*</span></label>
                                                            <input type="text" id="title" name="title" required="" class="form-control" placeholder="Exam Title" title="Exam Title">
                                                            <span id="error_companyid" class=""></span>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-12">
                                                            <label class="form-control-label">Exam Time Duration in min. <span class="text-danger">*</span></label>
                                                            <input type="number" name="examtime"  id="examtime" value="0" placeholder="Exam Time Duration in min." title="Exam Time Duration in min." required autocomplete="off" class="form-control">
                                                            <span id="error_examtime" class=""></span>
                                                        </div>

                                                    </div>


                                                    <div class="row form-group">
                                                        <div class="col-lg-6">
                                                            <label class="form-control-label">Number of Questions <span class="text-danger">*</span></label>
                                                            <input type="number" name="noofquestion" readonly="" id="noofquestion" value="0" placeholder="Number of Questions" title="Number of Questions" required autocomplete="off" class="form-control">
                                                            <span id="error_a" class=""></span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label class="form-control-label">Mark for each Question <span class="text-danger">*</span></label>
                                                            <input type="number" step="0.01" name="markofeach" id="markofeach" placeholder="Mark for each Question" title="Mark for each Question" required autocomplete="off" class="form-control">
                                                            <span id="error_b" class=""></span>
                                                        </div>
                                                    </div>

                                                    <div class="row form-group">
                                                        <div class="col-lg-6">
                                                            <label class="form-control-label">Negative Mark of each <span class="text-danger">*</span></label>
                                                            <input type="number" step="0.01" name="negativemarkofeach" id="negativemarkofeach" placeholder="Negative Mark of each" title="Negative Mark of each" required autocomplete="off" class="form-control">
                                                            <span id="error_c" class=""></span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label class="form-control-label">Passing Marks <span class="text-danger">*</span></label>
                                                            <input type="text" step="0.01" name="passingmark" id="passingmark"  placeholder="Passing Marks" title="Passing Marks" required autocomplete="off" class="form-control">
                                                            <span id="error_d" class=""></span>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-6">
                                                            <label class="form-control-label">Exam Start Date <span class="text-danger">*</span></label>
                                                            <input type="date" name="startdate" id="startdate" placeholder="Exam Start Date" title="Negative Mark of each" required autocomplete="off" class="form-control">
                                                            <span id="error_c" class=""></span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label class="form-control-label">Exam End Date <span class="text-danger">*</span></label>
                                                            <input type="date" name="closedate" id="closedate"  placeholder="Exam End Date" title="Exam End Date" required autocomplete="off" class="form-control">
                                                            <span id="error_d" class=""></span>
                                                        </div>
                                                        <div class="col-lg-6">

                                                        </div>
                                                    </div>

                                                    <div class="row form-group">
                                                        <div class="col-lg-12">
                                                            <label class="form-control-label">Exam Short Description <span class="text-danger">*</span></label>
                                                            <textarea id="sdesc"></textarea>
                                                            <input type="hidden" name="short" id="short">
                                                            <span id="error_short" class=""></span>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <label class="form-control-label">Exam Full Description <span class="text-danger">*</span></label>
                                                            <textarea id="fdesc"></textarea>
                                                            <input type="hidden" name="full" id="full">
                                                            <span id="error_full" class=""></span>
                                                        </div>
                                                    </div>

                                                    <div class="row form-group">
                                                        <input type="hidden" name="action" id="action" value="save">
                                                        <input type="hidden" name="id" id="id" value="0">

                                                        <div class="col-lg-12">
                                                            <button class="btn btn-primary btn-sm form-control">Save & Active</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- The Modal -->
                                <div class="modal fade preview-modal" data-backdrop="" id="myQuestion" role="dialog" aria-labelledby="preview-modal" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Exam Subject</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <table class="stripe hover display responsive nowrap" id="mySubjectTable" cellspacing='0'>
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Exam_id</th>                                            
                                                            <th>Subject</th>
                                                            <th class="datatable-nosort">No of Question</th>

                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Exam_id</th>                                            
                                                            <th>Subject</th>
                                                            <th class="datatable-nosort">No of Question</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade preview-modal" data-backdrop="" id="mydesc" role="dialog" aria-labelledby="preview-modal" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Exam Description</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row form-group">
                                                    <div class="col-lg-12">
                                                        <label class="label form-control-label">Short Description</label>
                                                        <textarea id="sdesc"></textarea>
                                                        <input type="hidden" id="short">
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <label class="lable form-control-label">Full Description</label>
                                                        <textarea id="fdesc"></textarea>
                                                        <input type="hidden" id="full">
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
                                            <th>Title</th>                                            
                                            <th>Company or College</th>
                                            <th>Post By</th>
                                            <th>No of Question</th>
                                            <th>Mark of each</th>
                                            <th>Negative Mark of Each</th>
                                            <th>Passing Mark</th>
                                            <th>Exam Start Date</th>
                                            <th>Exam Close Date</th>
                                            <th>Exam Time in Min</th>
                                            <th>Subject</th>
                                            <th>Active</th>
                                            <th>Create</th>
                                            <th class="datatable-nosort">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>                                            
                                            <th>Company or College</th>
                                            <th>Post By</th>
                                            <th>No of Question</th>
                                            <th>Mark of each</th>
                                            <th>Negative Mark of Each</th>
                                            <th>Passing Mark</th>
                                            <th>Exam Start Date</th>
                                            <th>Exam Close Date</th>
                                            <th>Exam Time in Min</th>
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

    $("document").ready(function () {
        CKEDITOR.replace('sdesc', {
            height: 300,
            filebrowserUploadUrl: "upload.php"

        });
        timer = setInterval(updateDiv, 100);
        function updateDiv() {
            var editorText = CKEDITOR.instances.sdesc.getData();
            $('#short').val(editorText);
        }
        CKEDITOR.replace('fdesc', {
            height: 300,
            filebrowserUploadUrl: "upload.php"

        });
        timer = setInterval(updateDivf, 100);
        function updateDivf() {
            var editorText = CKEDITOR.instances.fdesc.getData();
            $('#full').val(editorText);
        }
        slist();
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
                url: '<?= api_url ?>/?r=CExam',
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
                url: '<?= api_url ?>/?r=CQuestions',
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

    function editExam(id)
    {
        $("#editExam").modal("show");
    }
    function editbusiness(id)
    {
        $("#myQuestion").modal("show");
        $('#mySubjectTable').DataTable({
            serverSide: true,
            Processing: true,
            dom: 'Bfrtip',
            order: [[0, "desc"]],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url: '<?= api_url ?>/?r=CExam',
                type: "post", // method  , by default get
                dataType: "json",
                data: {action: "loadSubjectTable", examid: id},
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

    }
    function description(id)
    {
        $("#mydesc").modal("show");
        $.post('<?= api_url ?>/?r=CExam', {id: id, action: 'select'}, function (data) {
            console.log(data);
            var json = JSON.parse(data);
            CKEDITOR.instances['sdesc'].setData(json.row["short"]);
            CKEDITOR.instances['fdesc'].setData(json.row["full"]);
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
            confirmButtonText: "Yes, Suspeded it!",
            closeOnConfirm: true
        },
        function () {
            $.post('<?= api_url ?>/?r=CExam', {id: id, st: st, action: 'delete'}, function (data) {
                console.log(data);
                table.ajax.reload(null, false);
                var json = JSON.parse(data);
                $.toaster({priority: json.toast[0], title: json.toast[1], message: json.toast[2]});

            });

        });

    }
    function getResult(id, title)
    {
        clickOnLink('/?r=dashboard&v=examresult&id=' + id, '#app-container', false)
    }

</script>
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
                            <span class="info-box-text">Point</span>
                            <a href="javascript:void(0)" class="nav-link"><span class="info-box-number" id="exams"></span></a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="m-0">Total Student</h5>
                        </div>
                        <div class="card-body">
                            <table class="stripe hover display responsive nowrap" id="myTableStudent" cellspacing='0'>
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
           
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<script>
    $("document").ready(function () {
        report();
        table = $('#myTableStudent').DataTable({
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
        $('#myTableCollege').DataTable({
            serverSide: true,
            Processing: true,
            dom: 'Bfrtip',
            order: [[0, "desc"]],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url: '<?= api_url ?>/?r=CCollege',
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
        $('#myTableCompanies').DataTable({
            serverSide: true,
            Processing: true,
            dom: 'Bfrtip',
            order: [[0, "desc"]],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url: '<?= api_url ?>/?r=CCompany',
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
        $('#myTableQuestion').DataTable({
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
        var table = $('#myTable').DataTable({
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
    });
    function report() {
        $.post("<?= api_url ?>?r=CAddUser", {action: "adminBalance"}, function (data) {
            console.log(data);
            var js = JSON.parse(data);
            $("#compaines").html(js[1]);
            $("#colleges").html(js[0]);
            $("#students").html(js[2]);
            $("#exams").html(js[3]);
        });
    }
</script>

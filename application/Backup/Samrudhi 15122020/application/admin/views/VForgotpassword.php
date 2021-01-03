<script>
    function checkSession() {
        var answer = $.session.get("loginEmail");
        if (answer != undefined) {
            window.location.replace("/?r=dashboard");
        } else {
            //window.location.replace("/");
        }
    }

    checkSession();
    $("document").ready(function () {
        checkLogin();
        $("#forgotPassword").submit(function (e) {
            e.preventDefault();
            var formdata = new FormData($("#forgotPassword")[0]);
            var object = {};
            formdata.forEach(function (value, key) {
                object[key] = value;
            });
            var json = JSON.stringify(object);
            progressShow();
            $.ajax({
                url: '<?= api_url ?>/?r=Cadminforgotpasswrod',
                type: 'post',
                data: formdata,
                enctype: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                xhr: function () {
                    progressShow();
                    var xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function (e) {
                        var progressbar = Math.round((e.loaded / e.total) * 100);
                        $("#inner-progress").css('width', progressbar + '%');
                        $("#inner-progress").html("Please Wait... "+progressbar + '%');
                    });
                    return xhr;
                },
                success: function (msg) {
                    console.log(msg);
                    var obj = JSON.parse(msg);
                    if (obj.status === 1 && obj.mail === true) {
                        printMessage(obj.message, "success", ".msg");
                        $("#forgotPassword")[0].reset();
                        progressHide();
                    } else {
                        printMessage("SMTPS Server not connected, Please try again after some time. " + obj.message, "danger", ".msg");
                        progressHide();
                    }
                },
                error: function (request, status, error) {

                    printMessage("Error on " + error, "danger", ".msg");
                    $("#forgotPassword")[0].reset();
                    progressHide();
                }
            });
        });
        function progressShow()
        {
            $("#btn_submit").attr("disabled", true);
            $("#progress").show();
        }
        function progressHide()
        {
            $("#btn_submit").attr("disabled", false);
            $("#progress").hide();
        }
        function setSession(obj)
        {
            $.post("/?r=C_SetSession", {"email": obj.email, "id": obj._id}, function (data) {
                console.log(data);
            });
        }
        function printMessage(message, clas, display)
        {
            $(display).html("<div class='alert alert-dismissible alert-" + clas + "'><button type='button' class='close' data-dismiss='alert'>&times;</button>" + message + "</div>");
        }
        function checkLogin()
        {
            var answer = $.session.get("loginEmail");
            if (answer != undefined) {
                window.location.replace("/?r=dashboard");
            } else {
                //window.location.replace("/");
            }
        }
    });
</script>

<div class="hold-transition login-page" id="grad1">
    <div class="login-box">
        <div class="msg">

        </div>
        <div class="login-logo" id="login-logo">
            <a href="#"><b>Admin</b> Forgot Password</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="progress" id="progress">
                <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" id="inner-progress" style="width:100%">Please wait....</div>
            </div>
            <div class="card-body login-card-body">
                <p class="login-box-msg">Enter your register email.</p>

                <form action="javascript:void(0)" method="post" name="forgotPassword" for="forgotPassword" id="forgotPassword">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" required name="userName" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                Click here to <a href="/" >Login</a>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" id="btn_submit" class="btn btn-primary btn-block">Send</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <!-- /.social-auth-links -->
                <p class="mb-1">

                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
        <p id="credit">Powered By <a href="https://www.aasksoft.co.in/" target="_blank" title="@askSfot pvt ltd"> @askSoft</a></p>
    </div>
    <!-- /.login-box -->

</div>


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
        $("#newPassword").submit(function (e) {
            e.preventDefault();
            var formdata = new FormData($("#newPassword")[0]);
            var object = {};
            formdata.forEach(function (value, key) {
                object[key] = value;
            });
            var json = JSON.stringify(object);
            progressShow();
            $.ajax({
                type: 'POST',
                url: '<?= api_url ?>/?r=CAdminChangePassword',
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
                        printMessage("" + obj.message, "danger", ".msg");
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
        $("#pass").keyup(function () {
            checkPassword();
        });
        $("#confirmpass").keyup(function () {
            confirmPassword();
        });
        function confirmPassword() {
            var cpwd = $("#confirmpass").val();
            var pwd = $("#pass").val();
            if (pwd != cpwd)
            {
                $("#confirmpass").addClass("is-invalid");
                $("#confirmpass").removeClass("is-valid");
                $("#error_cp").removeClass("valid-feedback");
                $("#error_cp").addClass("invalid-feedback");
                $("#error_cp").show();
                $("#error_cp").html("Password not match..!");
            } else {
                $("#confirmpass").removeClass("is-invalid");
                $("#confirmpass").addClass("is-valid");
                $("#error_cp").removeClass("invalid-feedback");
                $("#error_cp").addClass("valid-feedback");
                $("#error_cp").show();
                $("#error_cp").html("Password match..!");
            }
        }
        function checkPassword()
        {
            var pwd = $("#pass").val();
            var re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
            if (!re.test(pwd)) {
                $("#pass").addClass("is-invalid");
                $("#pass").removeClass("is-valid");
                $("#error_c").removeClass("valid-feedback");
                $("#error_c").addClass("invalid-feedback");
                $("#error_c").show();
                $("#error_c").html("at least one number, one lowercase and one uppercase letter and minimum 8 characters");
            } else {
                $("#pass").removeClass("is-invalid");
                $("#pass").addClass("is-valid");
                $("#error_c").removeClass("invalid-feedback");
                $("#error_c").addClass("valid-feedback");
                $("#error_c").show();
                $("#error_c").html("Success..!");
            }
        }
    });
</script>

<div class="hold-transition login-page" id="grad1">
    <div class="login-box">
        <div class="msg">

        </div>
        <div class="login-logo" id="login-logo">
            <a href="#"><b>Admin</b> Reset Password</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="progress" id="progress">
                <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" id="inner-progress" style="width:100%">Please wait....</div>
            </div>
            <div class="card-body login-card-body">
                <p class="login-box-msg">Create New Password</p>

                <form action="javascript:void(0)" method="post" name="newPassword" for="newPassword" id="newPassword">
                    <input type="hidden" name="token" value="<?= $main->encript->encTxt($id) ?>">
                    <input type="hidden" name="etoken" value="<?= $main->encript->encTxt($email) ?>">
                    <div class="form-group">
                        <label class="form-control-label" for="inputNewPassword">New Password <span class="text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control is_valid" required name="pass" id="pass" placeholder="New Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" autocomplete="off">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div id="error_c" class=""></div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="inputConfirmPassword">Confirm Password <span class="text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control is_valid" required name="confirmpass" id="confirmpass" placeholder="Confirm Password" autocomplete="off">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div id="error_cp" class=""></div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="icheck-primary">
                                Click here to <a href="/" >Login</a>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-6">
                            <button type="submit" id="btn_submit" class="btn btn-primary btn-block">Change Password</button>
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


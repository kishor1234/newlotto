
<div class="hold-transition login-page" id="grad1">
    <script>

        $("document").ready(function () {

            $("#loginForm").submit(function (e) {
                e.preventDefault();
                var formdata = new FormData($("#loginForm")[0]);
                var object = {};
                formdata.forEach(function (value, key) {
                    object[key] = value;
                });
                var json = JSON.stringify(object);
                //console.log(json);
                $.ajax({
                    type: 'POST',
                    url: '<?= api_url ?>/?r=login',
                    dataType: "json",
                    data: json,
                    xhr: function () {
                        progressShow();
                        var xhr = new XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function (e) {
                            var progressbar = Math.round((e.loaded / e.total) * 100);
                            $("#inner-progress").css('width', progressbar + '%');
                            $("#inner-progress").html("Please Wait... " + progressbar + '%');
                        });
                        return xhr;
                    },
                    success: function (obj) {
                        if (obj.message === "success")
                        {
                            $.session.set('loginEmail', obj.email);
                            $.session.set('id', obj._id);
                            setSession(obj);
                            printMessage("Loggin successfully..", "success", ".msg");
                            checkLogin();
                            $("#loginForm")[0].reset();
                            progressHide();
                        } else {
                            printMessage("Invalid email or password", "danger", ".msg");
                            $("#loginForm")[0].reset();
                            progressHide()
                        }
                    },
                    error: function (request, status, error) {
                        printMessage("Error on " + error, "danger", ".msg");
                        $("#loginForm")[0].reset();
                        progressHide()
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

                window.location.replace("/?r=dashboard&v=dashboard")
            }
        });
    </script>
    <div class="login-box">
        <div class="msg">

        </div>
        <div class="login-logo" id="login-logo">
            <a href="#"><b>Admin</b> Login</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="progress" id="progress">
                <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" id="inner-progress">Please wait....</div>
            </div>
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="javascript:void(0)" method="post" name="loginForm" for="loginForm" id="loginForm">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="userName" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <a href="#">I forgot my password</a>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" id="btn_submit" class="btn btn-primary btn-block">Sign In</button>
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
    </div>
    <!-- /.login-box -->
</div>



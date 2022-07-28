<?php
session_start();

if (isset($_SESSION['username'])) {
    header("location:dashboard.php");
}

include_once("./layout/head.php");
?>

<div class="container-fluid">
    <!-- custom alert start -->
    <div class="col-lg-4 col-md-4 col-sm-5 ml-auto d-none rightSideAlert">
        <div class="alert alert-success fade show add-alert-prop" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="True">&times;</span>
            </button>
            <h4 class="alert-heading"></h4>
            <p class="alert-message"></p>
        </div>
    </div>
    <!-- custom alert end -->
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-4 logo-image">
            <img src="./layout/assets/gmail.png" style="max-width: 100%;"  alt="">
        </div>
        <span class="logo-image-suffix font-weight-bolder"> AILMAN </span>
        <div class="col-md-5 reg-form login_form">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-left reg-label font-weight-bolder">Login with Your Account</h3>
                </div>
            </div>
            <hr>
            <form id="login-form" method="post">

                <div class="form-outline">
                    <label class="form-label font-weight-bolder" for="useremail">Email/Username</label>
                    <input type="text" class="form-control form-control-lg w-100 mb-3" id="user_name" name="user_name" placeholder="Enter Email or Username">
                    <span class="field-error font-weight-bolder" id="email_error"></span>
                </div>
                <br>

                <div class="form-outline mb-4">
                    <label class="form-label font-weight-bolder" for="userpassword">Password</label>
                    <input type="password" class="form-control form-control-lg w-100 mb-3" id="userpass" name="userpass"
                        placeholder="Enter Password">
                    <span class="field-error font-weight-bolder" id="pass_error"></span>
                </div>
                <br>
                <div class="form-outline mb-4">
                    <div class="col-md-8 font-weight-bolder">
                        <!-- <a href="" id="forgot_password">Forgot Password?</a> -->
                        <a href="forgotPassword.php" >Forgot Password?</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 text-danger font-weight-bolder" id="credential_error"></div>
                    <div class="col-md-6"></div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-primary btn-block mb-4 signup-btn btn-login">Sign In</button>
                    </div>
                    <div class="col-sm-6 mt-3 font-weight-bolder">
                        <span>Do not have an account? <a href="registration.php"> Create Account </a></span>
                    </div>
                </div>
                <br>

            </form>
        </div>
        <div class="col-md-2"></div>

    </div>
</div>



<?php include_once("./layout/footer.php"); ?>

<script>
$(document).ready(function() {
    $("#login-form").submit(function(e) {
        e.preventDefault();
        var user_name = $("#user_name").val();
        var user_pass = $("#userpass").val();
        var username_pattern = /^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/;
        var email_pattern = /^[\w.+\-]+@mailman\.com$/;

        if (user_name == '' || user_name == null) {
            $("#email_error").text("Please Enter Email or Username");
            $("#credential_error").text('');
        } else {
            $("#email_error").text("");
        }

        if (user_pass == '' || user_pass == null) {
            $("#pass_error").text("Please Enter Password");
            $("#credential_error").text('');
            return false;
        } else {
            $("#pass_error").text("");
        }

        if (user_name != '' && user_name != null && user_pass != '' && user_pass != null) {
            var loginFormData = new FormData(this);
            $.ajax({
                url: "./controllers/Login.php",
                method: "POST",
                data: loginFormData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    var res = JSON.parse(response);
                    console.log(res);
                    if (res.status == false) {
                        $("#pass_error").text("Credentials not mached.");
                    }
                    if (res.status == true && res.type == "password_matched") {
                        window.location.href = "dashboard.php";
                    }
                }
            });
        }
    });

    // $("#forgot_password").click(function(e) {
    //     e.preventDefault();
    //     var user_name = $("#user_name").val();
    //     var forgot_password = "forgot_password";

    //     if (user_name == '' || user_name == null) {
    //         $("#email_error").text("Please Enter Mailmail Address or Username");
    //         $("#credential_error").text('');
    //         return false;
    //     } else {
    //         $("#email_error").text("");
    //     }

    //     $.ajax({
    //         url: "./controllers/Login.php",
    //         method: "POST",
    //         data: {
    //             user_name,
    //             forgot_password
    //         },
    //         success: function(data) {
    //             var response = JSON.parse(data);
    //             if (response.status == true && response.type == "mail_sent") {
    //                 $("#credential_error").text('');
    //                 // alert(response.message);
    //                 alertSuccessMessage(response.message);
    //             } else if (response.status == false && response.type ==
    //                 "username_not_exist") {
    //                 $("#credential_error").text(response.message);
    //             } else if (response.type == "mail_not_sent") {
    //                 $("#credential_error").text('');
    //                 // alert(response.message);
    //                 alertErrorMessage(response.message);
    //             }
    //         }
    //     });
    // });

    // function alertSuccessMessage(message){
    //     setTimeout(function(){
    //         $(".rightSideAlert").addClass("d-none");
    //         $(".rightSideAlert").fadeOut(1000);
    //     }, 3000);
    //     $(".add-alert-prop").removeClass("alert-danger").addClass("alert-success");
    //     $(".alert-heading").text('').text("Success");
    //     $(".alert-message").text('').text(message);
    //     $(".rightSideAlert").removeClass("d-none");
    // }

    // function alertErrorMessage(message){
    //     setTimeout(function(){
    //         $(".rightSideAlert").addClass("d-none");
    //         $(".rightSideAlert").fadeOut(1000);
    //     }, 3000);
    //     $(".add-alert-prop").removeClass("alert-success").addClass("alert-danger");
    //     $(".alert-heading").text('').text("Error");
    //     $(".alert-message").text('').text(message);
    //     $(".rightSideAlert").removeClass("d-none");
    // }
});
</script>
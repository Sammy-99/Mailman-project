<?php

include_once("./layout/head.php");

?>

<div class="container">
    <div class="row">
        <div class="col-md-5">
            <!-- <h1 class="text-left">Registartion Form</h1>
            <p class="text-left">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Adipisci qui eligendi voluptatum inventore. Quis perferendis perspiciatis, ipsam quo in deserunt ad illo assumenda dicta excepturi explicabo aspernatur quos et culpa.</p> -->
        </div>
        <div class="col-md-7 reg-form">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-left reg-label">Login with Your Account</h3>
                </div>
            </div>
            <hr>
            <form action="#" id="login-form">
                <div class="row">
                    <label class="col-md-4 label control-label">Email/Username</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter Email">
                        <small class="field-error" id="email_error"></small>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-4 label control-label">Password</label>
                    <div class="col-md-8">
                        <input type="password" class="form-control" id="userpass" name="userpass" placeholder="Enter Password">
                        <small class="field-error" id="pass_error"></small>
                    </div>
                </div>
                <br>
                <div class="row">
                    <label class="col-md-4 label control-label"></label>
                    <div class="col-md-8">
                        <a href="" id="forgot_password">Forgot Password?</a>
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-md-6 text-danger" id="credential_error"></div>
                    <div class="col-md-6"></div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success btn-block btn-login">Log In</button>  
                    </div>
                    <div class="col-md-2"></div>
                    <label class="col-md-4 label control-label"><a href="./registration.php">Sign Up Instead</a> </label>
                </div>
                
                <br><br>  
            </form>
        </div>
        
    </div>
</div>



<?php include_once("./layout/footer.php"); ?>

<script>
    $(document).ready(function(){
        $("#login-form").submit(function(e){
            e.preventDefault();
            var user_name = $("#user_name").val();
            var user_pass = $("#userpass").val();
            var username_pattern = /^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/;
            var email_pattern = /^[\w.+\-]+@mailman\.com$/ ;

            if(user_name == '' || user_name == null){
                $("#email_error").text("Please Enter Email or Username");
            }else{
                $("#email_error").text("");
            }

            if(user_pass == '' || user_pass == null){
                $("#pass_error").text("Please Enter Password");
                return false;
            }else{
                $("#pass_error").text("");
            }

            if(user_name != '' && user_name != null && user_pass != '' && user_pass != null)
            {
                var loginFormData = new FormData(this);
                $.ajax({
                    url : "./controllers/Login.php",
                    method : "POST",
                    data : loginFormData,
                    cache : false,
                    processData: false,
                    contentType: false,
                    success : function(response){
                        var res = JSON.parse(response);
                        console.log(res)
                        if(res.status == false){
                            $("#credential_error").text(res.message);
                        }
                        if(res.status == true && res.type == "password_matched"){
                            window.location.href = "dashboard.php";
                        }
                    }
                });
            }
        });

        $("#forgot_password").click(function(e){
            e.preventDefault();
            var user_name = $("#user_name").val();
            var forgot_password = "forgot_password";

            $.ajax({
                url : "./controllers/Login.php",
                method : "POST",
                data : {
                    user_name,
                    forgot_password
                },
                success : function(data){
                    var response = JSON.parse(data);
                    // alert(response)
                    console.log(response);
                    if(response.status == true && response.type == "mail_sent"){
                        alert(response.message);
                    }
                    else if(response.status == false && response.type == "username_not_exist"){
                        $("#credential_error").text(response.message);
                    }
                    else if (response.type == "mail_not_sent"){
                        alert(response.message);
                    }
                }
            })
            // alert(" forgot password");
        })
    });
</script>


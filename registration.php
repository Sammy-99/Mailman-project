<!-- <div class="bgimage">

</div> -->
<!-- 
<div class="container-fluid bgimage">
    <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-12"></div>
        <div class="col-md-6 col-sm-6 col-xs-12 form-background"> -->
            <!-- registration form start -->

            <!-- <form class="form-container"> -->
                <!-- <div class="row">

                    <div class="col-lg-6">
                        <label for="Username">User Name</label>
                        <input type="text" class="form-control" id="username" name="username"  placeholder="Enter Username">
                    </div>
                    <div class="col-lg-6">
                        <label for="Firstname">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter First Name">
                    </div>
                </div> -->
                <!-- <button type="submit" class="btn btn-success btn-block">Submit</button> -->
            <!-- </form> -->

            <!-- form end -->
        <!-- </div>
        <div class="col-md-4 col-sm-4 col-xs-12"></div>
    </div>
</div> -->

<?php

include_once("./layout/head.php");

?>


<div class="alert alert-success d-none" role="alert">
    Your account created successfully. We are redirecting you on Login page, you can Login now with you creadentials.
</div>
<div class="container">
    <div class="row">
        <div class="col-md-5">
            <!-- <h1 class="text-left">Registartion Form</h1>
            <p class="text-left">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Adipisci qui eligendi voluptatum inventore. Quis perferendis perspiciatis, ipsam quo in deserunt ad illo assumenda dicta excepturi explicabo aspernatur quos et culpa.</p> -->
        </div>
        <div class="col-md-7 reg-form">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-left reg-label">Create Your Account</h3>
                </div>
            </div>
            <hr>
            <form action="" id="registration-form" method="post">
                <div class="row">
                    <div class="col-md-7 order-2 order-md-1">
                        <div class="row">
                            <div class="col-md-11">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">
                                <small class="field-error" id="username_error"></small>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-11">
                                <input type="text" class="form-control" id="firstname"  name="firstname" placeholder="Enter First Name">
                                <small class="field-error" id="fname_error"></small>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-11">
                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter Last Name">
                                <small class="field-error" id="lname_error"></small>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 col-sm-8 col-8">
                                <input type="text" class="form-control" id="useremail" name="useremail" placeholder="Enter Email"> 
                                <small class="field-error" id="email_error"></small>
                            </div>
                            <span class="col-md-5 col-sm-4 col-4 mail-suffix">@mailman.com</span>
                        </div>
                        <div class="row">
                            <div class="col-md-11">
                                <input type="password" class="form-control" id="userpassword" name="userpassword" placeholder="Enter Password">
                                <small class="field-error" id="pass_error"></small>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-11">
                                <input type="password" class="form-control" id="c-password" name="c-password" placeholder="Confirm Password">
                                <small class="field-error" id="cpass_error"></small>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                    <div class="col-md-5 order-1 order-md-2">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-9">
                                <!-- <div class="profile-picture">
                                </div>
                                <div class="upload-picture">
                                    <a href="">Upload picture</a>
                                </div> -->
                                <div class="mt-3">
                                    <img src="./layout/assets/p.png" alt="profile-picture" width="150px">

                                </div>
                                <br>
                                <input type="file" class="mt-2" name="user-image">
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-11">
                                <input type="email" class="form-control" id="secondary-email" name="secondary-email" placeholder="Enter Secondary Email">
                                <small class="field-error" id="semail_error"></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 dob-input">
                        <div class="row">
                            <div class="col-md-11">
                                <!-- <input type="date" class="form-control" id="birth-date" name="birth-date" placeholder="Enter your DOB">
                                <small id="emailHelp" class="form-text text-muted">Date of Birth.</small>
                                <small class="field-error" id="dob_error"></small> -->
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-8">
                        <input type="checkbox" id="checkbox"> Term and Conditions <br>
                        <small class="field-error" id="backend_error"></small>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-11">
                                
                                <button type="submit" class="btn btn-success btn-block signup-btn">Sign Up</button> 
                            </div>
                        </div>  
                    </div>
                    <div class="col-md-5 signin-msg mt-1">
                        <span>Already have an account? <a href="./index.php">Sign In</a></span>
                    </div>
                </div>
                <br><br>  
            </form>
        </div>
        
    </div>
</div>

<?php include_once("./layout/footer.php"); ?>

<script>
    $(document).ready(function(){
       
        $("#registration-form").on('submit', function(e){
            e.preventDefault();
            var formData = new FormData(this);

            var user_name = $("#username").val();
            var f_name = $("#firstname").val();
            var l_name = $("#lastname").val();
            var email = $("#useremail").val();
            var password = $("#userpassword").val();
            var c_password = $("#c-password").val();
            var second_email = $("#secondary-email").val();
            var checkbox = false;

            if(user_name == '' || user_name == null){
                $("#username_error").text("Please Enter Username");
                // return false;
            }else{
                $("#username_error").text("");
                var pattern = new RegExp('^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$');
                if(!pattern.test(user_name)){
                    $("#username_error").text("Username should be Alphanumeric!");
                    // return false;
                }else{
                    user_name = true; 
                }
            }

            if(f_name == '' || f_name == null){
                $("#fname_error").text("Please Enter First Name");
                // return false;
            }else{
                $("#fname_error").text("");
                var pattern = /^[a-zA-Z()]+$/ ;
                if(!pattern.test(f_name)){
                    $("#fname_error").text("Name should be Alphabetic!");
                    // return false;
                }else{
                    $("#fname_error").text("");
                    f_name = true ;
                }
            }

            if(l_name == '' || l_name == null){
                $("#lname_error").text("Please Enter Last Name");
                // return false;
            }else{
                $("#lname_error").text("");
                var pattern = /^[a-zA-Z()]+$/ ;
                if(!pattern.test(l_name)){
                    $("#lname_error").text("Name should be Alphabetic!");
                    // return false;
                }else{
                    $("#lname_error").text("");
                    l_name = true;
                }
            }

            if(email == '' || email == null){
                $("#email_error").text("Please Enter Email");
                // return false;
            }else{
                var properEmail = email + "@mailman.com";
                $("#email_error").text("");
                var pattern = /^[\w.+\-]+@mailman\.com$/ ;
                if(!pattern.test(properEmail)){
                    $("#email_error").text("Invalid Email Format");
                    // return false;
                }else{
                    $("#email_error").text("");
                    email = true ;
                }
            }

            if(password == '' || password == null){
                $("#pass_error").text("Please Enter Password");
                // return false;
            }else{
                $("#pass_error").text("");
                var pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/;
                if(password.length < 6){
                    $("#pass_error").text("Password must be 6 charactors long");
                    // return false;
                }else if(!pattern.test(password)){
                    $("#pass_error").text("Password must contain atleast 1 small character, 1 upper case character, 1 numeric key and 1 special");
                    // return false;
                }else{
                    $("#pass_error").text("");
                }
            }

            if(c_password == '' || c_password == null){
                $("#cpass_error").text("Please Enter Confirm password");
            }
            else if(password != c_password){
                $("#cpass_error").text("Password must be same");
            }
            else if(password == c_password){
                // alert(4444444444444)
                $("#cpass_error").text("");
                password = true ;
                c_password = true;
                password_matched = true;
            }

            if(second_email == '' || second_email == null){
                $("#semail_error").text("Please Enter Secondary Email");
                // return false;
            }else{
                $("#semail_error").text("");
                var pattern = /^[\w.+\-]+@gmail\.com$/ ;
                if(!pattern.test(second_email)){
                    $("#email_error").text("Invalid Email Address");
                    // return false;
                }else{
                    $("#email_error").text("");
                    second_email = true;
                }
            }

            if ($("#checkbox").is(":checked")) {
                checkbox = true;
            }

            if(user_name==true && f_name==true && l_name==true && email==true && password==true && c_password==true && password_matched==true && second_email==true && checkbox==true)
            {
                $.ajax({
                    url : "./controllers/Signup.php",
                    method : "POST",
                    data : formData,
                    // dataType: 'json',
                    cache : false,
                    processData: false,
                    contentType: false,
                    success : function(response){
                        var error_type = ['invalid_filetype', 'invalid_filesize', 'user_exist', 'not_inserted', 'error'];
                        console.log(response);
                        if(response.status == false){
                            $("#backend_error").text(response.message);
                        }
                        else if(response.status == true && response.type == "inserted"){
                            setTimeout(function(){
                                window.location.href = "index.php";
                           }, 5000);
                           $(".alert").removeClass("d-none")
                        }
                    },
                });
            }

        });
    });
</script>
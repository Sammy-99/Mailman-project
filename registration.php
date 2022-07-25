<?php

include_once("./layout/head.php");

?>

<div class="alert alert-success d-none" role="alert">
    Your account created successfully. We are redirecting you on Login page, you can Login now with you creadentials.
</div>
<div class="container">
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-10 reg-form">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-left reg-label font-weight-bold">Create Your Account</h3>
                </div>
            </div>
            <hr>

            <form id="registration-form" method="post">
                <div class="row mb-4">
                    <div class="col-sm-6 order-2 order-md-1">
                        <div class="form-outline">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                placeholder="Enter Username">
                            <small class="field-error" id="username_error"></small>
                        </div>
                        <br>
                        <div class="form-outline">
                            <label class="form-label" for="firstname">First name</label>
                            <input type="text" class="form-control" id="firstname" name="firstname"
                                placeholder="Enter Firstname">
                            <small class="field-error" id="fname_error"></small>
                        </div>
                        <br>
                        <div class="form-outline">
                            <label class="form-label" for="lastname">Lastname name</label>
                            <input type="text" class="form-control" id="lastname" name="lastname"
                                placeholder="Enter Lastname">
                            <small class="field-error" id="lname_error"></small>
                        </div>

                    </div>
                    <div class="col-sm-6 text-center order-1 order-md-2 mt-4">
                        <div class="form-outline">
                            <div>
                                <img src="./layout/assets/p.png" id="previews" class="mt-4" width="150px" alt="">
                            </div>
                            <br>
                            <input type="file" hidden id="user-image" class="form-control" name="user-image" />
                            <label class="form-label btn-link cursor-pointer font-weight-bold" for="user-image">Upload Image</label>
                            <br>
                            <span class="field-error" id="file_error"></span>
                        </div>
                    </div>
                </div>

                <div class="form-outline">
                    <label class="form-label" for="useremail">Email</label>
                    <div class="row">
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="useremail" name="useremail" placeholder="Enter Email">
                            <small class="field-error" id="email_error"></small>
                        </div>
                        <div class="col-md-3 mt-2 font-weight-bold">
                            <span class="mail-suffix">@mailman.com</span>
                        </div>
                    </div>
                </div>
                <br>

                <div class="form-outline mb-4">
                    <label class="form-label" for="userpassword">Password</label>
                    <input type="password" class="form-control" id="userpassword" name="userpassword"
                        placeholder="Enter Password">
                    <small class="field-error" id="pass_error"></small>
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="c-password">Confirm Password</label>
                    <input type="password" class="form-control" id="c-password" name="c-password"
                        placeholder="Confirm Password">
                    <small class="field-error" id="cpass_error"></small>
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="secondary-email">Secondary Email</label>
                    <input type="text" class="form-control" id="secondary-email" name="secondary-email"
                        placeholder="Enter Your Email Address">
                    <small class="field-error" id="semail_error"></small>
                </div>

                <div class="form-outline mb-4">
                    <input type="checkbox" id="checkbox">
                    <label class="form-label" for="checkbox">Term and Conditions</label><br>
                    <small class="field-error" id="checkbox_error"></small>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-primary btn-block mb-4 signup-btn">Sign up</button>
                    </div>
                    <div class="col-sm-6 font-weight-bold mt-2">
                        <span>Already have an account? <a href="index.php"> Sign In </a></span>
                    </div>
                </div>
                <br>

            </form>
        </div>
        <div class="col-md-1">
        </div>

    </div>
</div>

<?php include_once("./layout/footer.php"); ?>

<script>
$(document).ready(function() {

    $("#username").on("change keyup", function() {
        $("#username_error").text("");
    });

    $("#firstname").on("change keyup", function() {
        $("#fname_error").text("");
    });

    $("#lastname").on("change keyup", function() {
        $("#lname_error").text("");
    });

    $("#useremail").on("change keyup", function() {
        $("#email_error").text("");
    });

    $("#userpassword").on("change keyup", function() {
        $("#pass_error").text("");
    });

    $("#c-password").on("change keyup", function() {
        $("#cpass_error").text("");
    });

    $("#secondary-email").on("change keyup", function() {
        $("#semail_error").text("");
    });

    $("#user-image").on("change", function() {
        const [file] = (this).files
        if (file) {
            previews.src = URL.createObjectURL(file)
        } else {
            console.log('sdkl')
            $('#previews').prop('src', './layout/assets/p.png')
        }
    })

    $("#registration-form").on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        var user_name = $("#username").val();
        var f_name = $("#firstname").val();
        var l_name = $("#lastname").val();
        var email = $("#useremail").val();
        var password = $("#userpassword").val();
        var c_password = $("#c-password").val();
        var second_email = $("#secondary-email").val();
        var allowed_ext = ["jpg", "png"];
        var checkbox = false;
        var image_file = true;


        if (user_name == '' || user_name == null) {
            $("#username_error").text("Please Enter Username");
        }

        if (f_name == '' || f_name == null) {
            $("#fname_error").text("Please Enter First Name");
        }

        if (l_name == '' || l_name == null) {
            $("#lname_error").text("Please Enter Last Name");
        }

        if (email == '' || email == null) {
            $("#email_error").text("Please Enter Email");
        }

        if (password == '' || password == null) {
            $("#pass_error").text("Please Enter Password");
        }

        if (c_password == '' || c_password == null) {
            $("#cpass_error").text("Please Enter Confirm password");
        }

        if (second_email == '' || second_email == null) {
            $("#semail_error").text("Please Enter Secondary Email");
        }

        if (user_name != '' && f_name != '' && l_name != '' && email != '' && password != '' &&
            c_password != '' && second_email != '') {

            if ($("#checkbox").is(":checked")) {
                $("#checkbox_error").text('');
                checkbox = true;
            } else {
                $("#checkbox_error").text("Please tick Term and Conditions.")
                checkbox = false;
            }
        }

        var image_path = $("#user-image").val();
        if (image_path == '' || image_path == null) {
            image_file = true;
        } else {
            var extension = image_path.substring(image_path.lastIndexOf('.') + 1).toLowerCase();
            if (allowed_ext.indexOf(extension) !== -1) {
                var file_size = $("#user-image")[0].files[0].size;
                if (file_size > 2097152) {
                    $("#file_error").text("Please choose less than 2MB file");
                    image_file = false;
                } else {
                    image_file = true;
                }
            } else {
                $("#file_error").text("Choose only JPG, PNG image");
                image_file = false;
            }
        }

        if (checkbox == true && image_file == true) {
            $.ajax({
                url: "./controllers/Signup.php",
                method: "POST",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    var res = JSON.parse(response)
                    console.log(res);
                    if (res.status == false) {
                        $.each(res.error, function(key, val) {
                            $("#" + key + "").text(val);
                        });
                    } else if (res.status == true && res.type == "inserted") {
                        setTimeout(function() {
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
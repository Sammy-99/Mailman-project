<?php

session_start();

spl_autoload_register(function ($className) {
    require_once("./controllers/models/" . $className . ".php");
});

// $userData = Crud::getUserData($_SESSION['id']);
include_once("./layout/head.php"); 

if(empty($_GET['user_id']) && !isset($_SESSION['username'])){
    header("location:index.php");   
}
if(!empty($_GET['user_id'])){
    $user_id = $_GET['user_id'];
}
if(array_key_exists("reset_password", $_SESSION)){
    if($_SESSION["reset_password"] != "user_exist"){
        echo "<h1>You can only use once a url.</h1>"; die;
    }
}

// print_r(($_SESSION)); die(" jjj ");

?>

<div class="container-fluid">

    <?php
if(isset($_SESSION['username'])):
    $user_id = $_SESSION['id'];
    $userData = Crud::getUserData($_SESSION['id']);
?>


    <div class="row align-items-center">
        <div class="col-12 col-md-2 mt-2 font-weight-bolder">
            <h2 class="">Mailman</h2>
        </div>
        <div class="col-8 col-md-6">
            <div class="form-outline">
                <input type="search" id="form1" class="form-control border border-primery rounded"
                    style="margin:0 !important;" placeholder="Search" aria-label="Search" />
            </div>
        </div>
        <div class="col-4 col-md-4 mt-2">
            <nav class="navbar navbar-expand-sm">
                <div class="collapse navbar-collapse d-flex justify-content-end" id="navbar-list-4">
                    <div class="user-name"><?=$userData['username']?> </div> &nbsp;
                    <ul class="navbar-nav dashboard-profile">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="./uploadedimage/<?=$userData['user_image']?>" width="40" height="40"
                                    class="rounded-circle">
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="./dashboard.php">Home</a>
                                <a class="dropdown-item" href="./profile.php">Edit Profile</a>
                                <a class="dropdown-item" href="./logout.php">Log Out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <hr>

    <?php 
endif;
// echo $user_id; 
// // die(" user id ");
// print_r($_GET);
?>



    <div class="row m-5 h-100 justify-content-center align-items-center">
        <div class="col-10 col-md-6 col-lg-6">
            <form class="form-example" action="" method="post">
                <h2>Reset Password</h2>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control border password" id="userpassword"
                        placeholder="Enter Password" name="userpassword">
                    <small class="field-error" id="pass_error"></small>
                </div>
                <div class="form-group">
                    <label for="password">Confirm Password:</label>
                    <input type="password" class="form-control border password" id="c_password"
                        placeholder="Confirm Password" name="c_password">
                    <small class="field-error" id="cpass_error"></small>
                </div>
                <div class="text-danger" id="pass_error"></div>
                <div class="text-success" id="pass_updated"></div><br>
                <div class="row">
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-customized reset-button">Reset</button>
                    </div>
                    <?php if(!empty($_GET['user_id'])): ?>
                    <div class="col-md-10"><a href="./index.php">Back to Login!</a></div>
                    <?php endif ; ?>
                </div>

            </form>
        </div>
        <div class="col-md-6"></div>
    </div>
</div>

<?php include_once("./layout/footer.php"); ?>

<script>
$(document).ready(function() {
    $(".reset-button").click(function(e) {
        e.preventDefault();
        var reset_password = $("#userpassword").val();
        var c_password = $("#c_password").val();
        var user_id = <?=$user_id?>;
        var user_password;

        if (reset_password == '' || reset_password == null) {
            $("#pass_error").text("Please Enter Password");
            // return false;
        } else {
            $("#pass_error").text("");
            var pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/;
            if (reset_password.length < 6) {
                $("#pass_error").text("Password must be 6 charactors long");
            } else if (!pattern.test(reset_password)) {
                $("#pass_error").text(
                    "Password must contain atleast 1 small character, 1 upper case character, 1 numeric key and 1 special"
                );
            } else {
                $("#pass_error").text("");
            }
        }

        if (c_password == '' || c_password == null) {
            $("#cpass_error").text("Please Enter Confirm password");
        } else if (reset_password != c_password) {
            $("#cpass_error").text("Password must be same");
        } else if (reset_password == c_password && reset_password != '' && c_password != '') {
            // alert(4444444444444)
            $("#cpass_error").text("");
            user_password = true;
            c_password = true;
            password_matched = true;
        }

        if (user_password == true && c_password == true && password_matched == true) {

            $.ajax({
                url: "./controllers/Login.php",
                method: "POST",
                data: {
                    reset_password,
                    user_id
                },
                success: function(data) {
                    var response = JSON.parse(data);
                    if (response.type == "password_updated" && response.status == true) {
                        // $("#pass_update").addClass("text-primery");
                        $("#pass_updated").text(response.message);
                    } else if (response.status == false) {
                        // $("#pass_update").addClass("text-danger");
                        $("#pass_error").text(response.message);
                    }
                    console.log(response)
                }
            });
        }
    });
})
</script>
<?php

session_start();

spl_autoload_register(function ($className) {
    require_once("./controllers/models/" . $className . ".php");
});

include_once("./layout/head.php"); 

if(empty($_GET['user_id']) && !isset($_SESSION['username'])){
    header("location:index.php");   
}
if(!empty($_GET['user_id'])){
    $user_id = $_GET['user_id'];
}
if(array_key_exists("reset_password", $_SESSION)){
    if($_SESSION["reset_password"] != "user_exist" && empty($_SESSION['id'])){
        echo "<h2>Link Expired. You can only use once a url to reset the password.</h2>"; die;
    }
}

?>

<div class="container-fluid">

    <?php
    if(isset($_SESSION['username'])):
        $user_id = $_SESSION['id'];
        $userData = Crud::getUserData($_SESSION['id']);
        if (empty($userData['user_image'])) {
            $userData['user_image'] = "p.png";
        }
?>

    <div class="row align-items-center">
        <div class="col-12 col-md-2 mt-2 font-weight-bolder">
            <nav class="navbar navbar-expand-lg navbar-light">
                <h2 class="font-weight-bold"><a href="./dashboard.php"> Mailman </a></h2>
            </nav>
        </div>
        <div class="col-8 col-md-6">
            <div class="form-outline">
                <input type="search" id="searchData" class="form-control border border-primery rounded"
                    style="margin:0 !important;" placeholder="Search" aria-label="Search" />
            </div>
        </div>
        <div class="col-4 col-md-4 mt-2">
            <nav class="navbar navbar-expand-sm">
                <div class="collapse navbar-collapse d-flex justify-content-end" id="navbar-list-4">
                    <div class="user-name"> <?= $userData['username']; ?> </div> &nbsp;
                    <ul class="navbar-nav dashboard-profile">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="./uploadedimage/<?= $userData['user_image']; ?>" width="40" height="40"
                                    class="rounded-circle">
                            </a>
                            <div class="dropdown-menu " style="margin-left:-70px;"
                                aria-labelledby="navbarDropdownMenuLink">
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

    <?php else :?>

        <div class="row align-items-center ">
            <div class="col-12 col-md-2 mt-2 font-weight-bolder">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <h2 class="font-weight-bold"><a href="./dashboard.php"> Mailman </a></h2>
                </nav>
            </div>
            <div class="col-8 col-md-4">
                <div class="form-outline">
                </div>
            </div>
            <div class="col-4 col-md-6 mt-2">
                <div class="collapse navbar-collapse d-flex justify-content-end mr-4" id="navbar-list-4">
                    <button type="button" class="btn btn-primary"><a href="registration.php" class="text-light"> Sign
                            Up</a></button> &nbsp; &nbsp; &nbsp;
                    <button type="button" class="btn btn-primary"><a href="index.php" class="text-light"> Sign
                            In</a></button>
                </div>
            </div>
        </div>
        <hr>

    <?php endif;?>

    <div class="row h-100 align-items-center">
        <div class="col-md-1"></div>
        <div class="col-10 col-md-5 col-lg-5  password_reset_form">
            <form class="form-example" action="" method="post" style="padding:20px;">
                <h2 class="font-weight-bolder">Reset Password</h2>
                <div class="form-group">
                    <label class="font-weight-bolder" for="password">Password :</label>
                        <input type="password" id="userpassword" name="userpassword" class="form-control form-control-lg w-75 mb-3 password" placeholder="Enter Password" />
                        <div class="field-error font-weight-bolder" id="pass_error"></div>
                </div>
                <div class="form-group">
                    <label class="font-weight-bolder" for="password">Confirm Password :</label>
                    <input type="password" id="c_password" name="c_password" class="form-control form-control-lg w-75 mb-3 password" placeholder="Confirm Password" />
                    <div class="field-error font-weight-bolder" id="cpass_error"></div>
                </div>
                <div class="text-success font-weight-bolder" id="pass_updated"></div><br>
                <div class="row">
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-customized reset-button">Reset</button>
                    </div>
                    <?php if(!empty($_GET['user_id'])): ?>
                        <!-- <div class="col-md-10"><a href="./index.php">Back to Login!</a></div> -->
                    <?php endif ; ?>
                </div>

            </form>
        </div>
        <div class="col-md-5">
            <div class="key_photo">
                <img src="./layout/assets/key.png" width="400rem" alt="">
            </div>
        </div>
        <div class="col-md-1"></div>
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
            user_password = false;
        }else{
            $("#pass_error").text("");
            user_password = true;
        }

        if (c_password == '' || c_password == null) {
            $("#cpass_error").text("Please Enter Confirm password");
            c_pass = false;
        } else{
            $("#cpass_error").text("");
            c_pass = true;
        }

        if (user_password == true && c_pass == true ) {

            $.ajax({
                url: "./controllers/Login.php",
                method: "POST",
                data: {
                    reset_password,
                    c_password,
                    user_id
                },
                success: function(data) {
                    var response = JSON.parse(data);
                    if (response.type == "password_updated" && response.status == true) {
                        // $("#pass_update").addClass("text-primery");
                        $("#pass_updated").text(response.message);
                    } 
                    else if (response.status == false) {
                        // $("#pass_update").addClass("text-danger");
                        // $("#pass_error").text(response.message);
                        $.each(response.error, function(key, val) {
                            $("#" + key + "").text(val);
                        });
                    }
                    // console.log(response)
                }
            });
        }
    });
})
</script>
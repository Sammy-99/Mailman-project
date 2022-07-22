<?php

session_start();
if(!isset($_SESSION['username'])){
    header("location:index.php");  
}


spl_autoload_register(function ($className) {
    require_once("./controllers/models/" . $className . ".php");
});

$userData = Crud::getUserData($_SESSION['id']);

// print_r($userData); die(" user ");

if(empty($userData['user_image'])){
    $userData['user_image'] = "p.png";
}

include_once("./layout/head.php"); 

?>

<div class="container-fluid">
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
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-10"></div>
    </div>

    <div class="row my-4">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <form id="edit-user-details-form">
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label pt-3">Firstname</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control border" name="edit-firstname" id="edit-firstname"
                                    value="<?=$userData['firstname']?>" placeholder="Fisrtname">
                                <input type="hidden" name="user-id" value="<?=$_SESSION['id']?>">
                                <small class="text-danger" id="fname_error"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label pt-3">Lastname</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control border" name="edit-lastname"
                                    value="<?=$userData['lastname']?>" id="edit-lastname" placeholder="Lastname">
                                <small class="text-danger" id="lname_error"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label ">Recovery Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control border" name="edit-second-email"
                                    value="<?=$userData['secondary_email']?>" id="edit-second-email"
                                    placeholder="Fisrtname">
                                <small class="text-danger" id="email_error"></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <img src="./uploadedimage/<?=$userData['user_image']?>" alt="userimage" width="200px"
                            height="200px" class="rounded-circle">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-5">
                        <small class="backend_error text-danger"></small>
                        <small class="backend_success text-success"></small>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-success py-1 update-profile-btn">Submit</button>
                    </div>
                    <div class="col-md-5 ">
                        <input type="file" name="user-image">
                    </div>
                </div>
            </form>

        </div>
        <div class="col-md-2"></div>
    </div>
</div>

<?php include_once("./layout/footer.php"); ?>


<script>
$(document).ready(function() {
    $("#edit-user-details-form").submit(function(e) {
        e.preventDefault();
        var updateProfileData = new FormData(this);
        var f_name = $("#edit-firstname").val();
        var l_name = $("#edit-lastname").val();
        var second_email = $("#edit-second-email").val();
        // alert(f_name + l_name + email);

        if (f_name == '' || f_name == null) {
            // f_name = true;
            $(".backend_success").text('');
            $(".backend_error").text('');
            $("#fname_error").text("Please Enter First Name");
            f_name = false;
        } else {
            $("#fname_error").text("");
            var pattern = /^[a-zA-Z()]+$/;
            if (!pattern.test(f_name)) {
                $(".backend_success").text('');
                $(".backend_error").text('');
                $("#fname_error").text("Name should be Alphabetic!");
                f_name = false;
            } else {
                $("#fname_error").text("");
                f_name = true;
            }
        }

        if (l_name == '' || l_name == null) {
            // l_name = true;
            $(".backend_success").text('');
            $(".backend_error").text('');
            $("#lname_error").text("Please Enter Last Name");
            l_name = false;
        } else {
            $("#lname_error").text("");
            var pattern = /^[a-zA-Z()]+$/;
            if (!pattern.test(l_name)) {
                $(".backend_success").text('');
                $(".backend_error").text('');
                $("#lname_error").text("Name should be Alphabetic!");
                l_name = false;
            } else {
                $("#lname_error").text("");
                l_name = true;
            }
        }

        if (second_email == '' || second_email == null) {
            // email = true;
            $(".backend_success").text('');
            $(".backend_error").text('');
            $("#email_error").text("Please Enter Email");
            email = false;
        } else {
            $("#email_error").text("");
            var pattern = /^[\w.+\-]+@gmail\.com$/;
            if (!pattern.test(second_email)) {
                $(".backend_success").text('');
                $(".backend_error").text('');
                $("#email_error").text("Invalid Email Format");
                email = false;
            } else {
                $("#email_error").text("");
                email = true;
            }
        }

        if (f_name == true && l_name == true && email == true) {
            $.ajax({
                url: "./controllers/UpdateProfile.php",
                method: "POST",
                data: updateProfileData,
                // dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    var data = JSON.parse(response);
                    console.log(data);
                    if (data.status == false) {
                        $(".backend_success").text('');
                        $(".backend_error").text(data.message);
                    } else if (data.status == true && data.type == "user_details_updated") {
                        $(".backend_error").text('');
                        $(".backend_success").text(data.message);
                    }
                },
            });
        }
    })
})
</script>
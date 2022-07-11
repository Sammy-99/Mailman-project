<?php

session_start();
if(!isset($_SESSION['username'])){
    header("location:index.php");  
}


spl_autoload_register(function ($className) {
    require_once("./controllers/models/" . $className . ".php");
});

$userData = Crud::getUserData($_SESSION['id']);

if(empty($userData['user_image'])){
    $userData['user_image'] = "p.png";
}

include_once("./layout/head.php"); 

?>



<div class="container-fluid">
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
                    <div class="user-name"> <?=$userData['username']?> </div> &nbsp;
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
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-10"></div>
    </div>

    <div class="row my-4">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-7">
                    <h2> <?=$userData['username']?> </h2>
                    <h3> <?=$userData['user_email']?></h3>
                    <h3> <?=$userData['secondary_email']?></h3>
                    <h3> <?=$userData['firstname']?> <?=$userData['lastname']?> </h3>
                </div>
                <div class="col-md-5">
                    <img src="./uploadedimage/<?=$userData['user_image']?>" alt="userimage" width="200px" height="200px"
                        class="rounded-circle">
                </div>
            </div>
            <div class="row  m-5">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <a href="./edit-profile.php"><b> Edit Profile </b></a> &nbsp;&nbsp;
                    <span>|</span>&nbsp;&nbsp;
                    <a href="./resetpassword.php"><b> Change Password</b></a>
                </div>
                <div class="col-md-3">
                </div>
                <!-- <div class="col-md-2"></div> -->
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>



<?php include_once("./layout/footer.php"); ?>
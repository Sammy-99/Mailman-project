<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("location:index.php");
}

spl_autoload_register(function ($className) {
    require_once("./controllers/models/" . $className . ".php");
});

$userData = Crud::getUserData($_SESSION['id']);

if (empty($userData['user_image'])) {
    $userData['user_image'] = "p.png";
}

include_once("./layout/head.php");

?>

<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-12 col-md-2 mt-2 font-weight-bolder">
            <nav class="navbar navbar-expand-lg navbar-light">
                <!-- <h2 class="font-weight-bold">Mailman</h2> -->
                <h2 class="font-weight-bold"><a href="./dashboard.php"> Mailman </a></h2>
                <!-- <a class="navbar-brand" href="#">Navbar</a> -->
                <button class="navbar-toggler d-block d-sm-block d-md-none" type="button" data-toggle="collapse"
                    data-target="#sidebarMenu" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
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
                                <!-- <a class="dropdown-item" href="#">Dashboard</a> -->
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
        <div class="col-md-2"></div>
        <div class="col-md-10"></div>
    </div>
    <div class="row ">
        <div class="col-md-2 mb-3">
            <!-- <div class="border"> -->

            <!--Main Navigation-->
            <header>
                <!-- Sidebar -->
                <nav id="sidebarMenu" class="collapse d-lg-block sidebar bg-white">
                    <div class="position-sticky border">
                        <div class="list-group list-group-flush mx-3 mt-4">
                            <a href="#" class="list-group-item list-group-item-action py-2 ripple compose_email"
                                data-toggle="modal" data-target=".bd-example-modal-lg" aria-current="true">
                                <span>
                                    <h5 class="font-weight-bold">Compose</h5>
                                </span>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action py-2 ripple inbox"
                                data-inbox-value="inbox">
                                <span>Inbox</span>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action py-2 ripple sent"
                                data-sent-value="sent">
                                <span>Sent</span>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action py-2 ripple draft"
                                data-draft-value="draft">
                                <span>Draft</span>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action py-2 ripple trash"
                                data-trash-value="trash">
                                <span>Trash</span>
                            </a>
                        </div>

                    </div>
                </nav>
                <!-- Sidebar -->

            </header>
            <!--Main Navigation-->

            <!-- </div> -->
        </div>
        <div class="col-md-10 border">
            <div class="row">
                <div class="col-md-10 my-3 fix-button-row-height">
                    <div class="ml-1">
                        <div class="d-inline">
                            <input type="checkbox" id="mainCheckbox">
                            <input type="hidden" class="open-email" id="open-email" value="">
                            <input type="hidden" id="read_unread_email" value="">
                            <input type="hidden" id="page-number" value="">
                        </div>
                        <div class="buttons d-inline">
                            <div class="d-inline">
                                <button type="button"
                                    class="btn btn-outline-secondary py-1 ml-3 d-none backbutton">Back</button>
                            </div>
                            <div class="d-inline">
                                <button type="button" class="btn btn-outline-danger py-1 mx-3 d-none deleteEmail"
                                    value="delete">Delete</button>
                            </div>
                            <div class="d-inline">
                                <button type="button" class="btn btn-outline-primary py-1 mr-3 readUnread d-none"
                                    id="read-button" value="read"> Read</button>
                                <button type="button" class="btn btn-outline-secondary py-1 readUnread d-none"
                                    id="unread-button" value="unread">Unread</button>
                            </div>
                        </div>
                        <div class="d-inline ">
                            <button type="button"
                                class="btn btn-outline-success py-1 restoreEmail d-none">Restore</button>
                        </div>
                        <input type="hidden" id="current-sidebar" value="">
                    </div>
                </div>
                <div class="col-md-2">
                    <b>
                        <h5 class="mt-4 pl-4 text-capitalize font-weight-bold" id="breadcrumb">

                        </h5>
                    </b>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- <table> -->
                    <div class="main_content">

                    </div>
                    <!-- </table> -->

                    <!-- email page  start-->

                    <div class="card mb-5 d-none email_page">
                        <!-- <div class="card-header">
                            Featured
                        </div> -->
                        <div class="card-body">
                            <h5 class="card-title mail_subject font-weight-bold"></h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-9">
                                    <a href="#" id="email_participants">Participants </a>
                                    <div class="participants d-none">
                                        <small class="">From : <small class="" id="sender_email"></small></small><br>
                                        <small class=""> To : <small class="" id="to_reciever"></small></small><br>
                                        <small class="cc_reciever"> Cc : <small class="" id="cc_reciever"></small>
                                        </small><br>
                                        <small class="bcc_participants d-none"> Bcc : <small class=""
                                                id="bcc_reciever"></small></small>
                                    </div>
                                </div>
                                <div class="col-md-3 email_date"> </div>
                            </div>
                            <br>
                            <p class="card-text email_content">
                            </p>
                            <br>
                            <div class="attached_files"></div>
                            <a href="#!" class="btn btn-primary reply-email" data-btn-value="reply">Reply</a>
                            <a href="#!" class="btn btn-primary reply-email" data-btn-value="replyAll">Reply All</a>
                        </div>
                    </div>

                    <!-- email page end -->
                </div>
            </div>


        </div>

    </div>

</div>
<br><br><br><br>

<!-- modal html code start -->


<div class="modal fade bd-example-modal-lg" id="compose-email-modal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Email</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span> -->
                </button>
            </div>
            <div class="modal-body">
                <form id="compose-email" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2 mt-1">
                                <label for="recipient-name" class="col-form-label">To </label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control border" name="recipient-email"
                                    id="recipient-email">
                                <input type="hidden" class="form-control" name="button-id" id="button-id" value="1">
                                <input type="hidden" class="current-sidebar" name="current-sidebar" value="">
                                <input type="hidden" class="drafted_email" id="drafted_email" name="drafted_email" value="">
                                <input type="hidden" class="search-field" name="search-field" id="search-field" value="">
                                <small class="text-danger" id="email_error"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mt-1">
                                <label for="recipient-name" class="col-form-label">Cc </label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control border" name="cc-recipient-email"
                                    id="cc-recipient-email">
                                <small class="text-danger" id="cc_error"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mt-1">
                                <label for="recipient-name" class="col-form-label">Bcc </label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control border" name="bcc-recipient-email"
                                    id="bcc-recipient-email">
                                <small class="text-danger" id="bcc_error"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mt-1">
                                <label for="recipient-name" class="col-form-label">Subject </label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control border" name="email-subject" id="email-subject">
                                <small class="text-danger" id="subject_error"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mt-1">
                                <label for="recipient-name" class="col-form-label">Message </label>
                            </div>
                            <div class="col-md-10">
                                <textarea class="form-control border" name="email-content" id="email-content"
                                    rows="10"></textarea>
                                <small class="text-danger" id="content_error"></small>
                                <small class="text-success" id="email_sent"></small>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-9 append_file_input">
                            <input type="file" class="mr-5 file-input" onclick="myFunction(this)" multiple name="attachedfile[]" id="attached-files">
                            <input type="hidden" name="removed_files" id="removed_files" value="">

                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-danger close-email" data-dismiss="modal"
                                value="3">Close</button>
                            <button type="submit" class="btn btn-outline-success" id="send-email">Send</button>

                        </div>
                    </div>
                    <div class="filenames"></div>
                </form>
            </div>
            <!-- <div class="modal-footer">
                
            </div> -->
        </div>
    </div>
</div>

<!-- modal html code end -->

<?php include_once("./layout/footer.php"); ?>

<script src="./layout/assets/dashboard.js"></script>
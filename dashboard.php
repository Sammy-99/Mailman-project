<?php
// echo "<pre>";
// print_r($_SERVER); die(" llll ");
session_start();
if (!isset($_SESSION['username'])) {
    header("location:index.php");
}


spl_autoload_register(function ($className) {
    require_once("./controllers/models/" . $className . ".php");
});

$userData = Crud::getUserData($_SESSION['id']);

// echo "<pre>";
// print_r($_SERVER); die(" hh ");

if (empty($userData['user_image'])) {
    $userData['user_image'] = "p.png";
}
// print_r($userData);die(" session");

include_once("./layout/head.php");

?>


<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-12 col-md-2 mt-2 font-weight-bolder">
            <nav class="navbar navbar-expand-lg navbar-light">
                <h2 class="font-weight-bold">Mailman</h2>
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
                            <div class="dropdown-menu " style="margin-left:-50px;"
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
                            <h5 class="card-title mail_subject"></h5>
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
                <form id="compose-email">
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
                        <div class="col-md-9">
                            <input type="file" class="mr-5" multiple name="attachedfile[]" id="attached-files">

                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-danger close-email" data-dismiss="modal"
                                value="3">Close</button>
                            <button type="submit" class="btn btn-outline-success" id="send-email">Send</button>

                        </div>
                    </div>
                </form>
            </div>
            <!-- <div class="modal-footer">
                
            </div> -->
        </div>
    </div>
</div>

<!-- modal html code end -->

<?php include_once("./layout/footer.php"); ?>


<script>
$(document).ready(function() {

    // $(".rightSideAlert").removeClass("d-none");
    // // $(".rightSideAlert").fadeIn(1000);
    

    // setTimeout(function(){
    //     $(".rightSideAlert").fadeOut(400);
    // }, 5000);

    var identity = $(".inbox").data("inbox-value");
    if (identity == "inbox") {
        $("#current-sidebar").val('');
        $("#current-sidebar").val(identity);
        getDashboardData(identity);
    }

    $(".inbox").click(function() {
        $("#current-sidebar").val('');
        $("#read_unread_email").val("");
        $(".current-sidebar").val('');
        $("#search-field").val("");
        $("#searchData").val('');
        console.log($("#search-field").val());
        var identity = $(".inbox").data("inbox-value");
        $("#current-sidebar").val(identity);
        hideButtons()
        getDashboardData(identity);
    });

    $(".sent").click(function() {
        $("#current-sidebar").val('');
        $(".current-sidebar").val('');
        $("#search-field").val("");
        $("#searchData").val('');
        console.log($("#search-field").val());
        var identity = $(".sent").data("sent-value");
        $("#current-sidebar").val(identity);
        hideButtons()
        getDashboardData(identity);
    });

    $(".draft").click(function() {
        $("#current-sidebar").val('');
        $("#search-field").val("");
        $("#searchData").val('');
        console.log($("#search-field").val());
        var identity = $(".draft").data("draft-value");
        $("#current-sidebar").val(identity);
        $(".current-sidebar").val(identity);
        hideButtons()
        getDashboardData(identity);
    });

    $(".trash").click(function() {
        $("#current-sidebar").val('');
        $("#search-field").val("");
        $("#searchData").val('');
        console.log($("#search-field").val());
        var identity = $(".trash").data("trash-value");
        $("#current-sidebar").val(identity);
        $(".current-sidebar").val('');
        hideButtons();
        getDashboardData(identity);
    });

    /**
     * These two events (below) resposible for select and unselect the emails.
     */
    $('#mainCheckbox').click(function() {
        $("#open-email").val('');
        if (this.checked) {
            $('.checkbox').each(function() {
                this.checked = true;
            });
            showButtons();
        } else {
            $('.checkbox').each(function() {
                this.checked = false;
            });
            hideButtons();
        }
    });

    $(document).on("click", ".checkbox", function(event) {
        $("#open-email").val('');
        event.stopPropagation();
        if ($('.checkbox:checked').length > 0) {
            showButtons();
        } else {
            hideButtons()
        }
        if ($('.checkbox:checked').length == $('.checkbox').length) {
            $('#mainCheckbox').prop('checked', true);
        } else {
            $('#mainCheckbox').prop('checked', false);
        }
    });

    /**
     * These two function (below) are responsible to show and hide the buttons.
     */
    function showButtons() {
        var tab = $("#current-sidebar").val();
        if (tab == "inbox") {
            $(".deleteEmail").removeClass("d-none");
            $(".readUnread").removeClass("d-none");
        } else if (tab == "sent") {
            $(".deleteEmail").removeClass("d-none");
        } else if (tab == "draft") {
            $(".deleteEmail").removeClass("d-none");
            // $(".restoreEmail").removeClass("d-none");
        } else if (tab == "trash") {
            $(".deleteEmail").removeClass("d-none");
            $(".restoreEmail").removeClass("d-none");
        }
    }

    function hideButtons() {
        $(".deleteEmail").addClass("d-none");
        $(".readUnread").addClass("d-none");
        $(".restoreEmail").addClass("d-none");
        $(".backbutton").addClass("d-none");
    }

    /**
     * this function will return the dashboard data for inbox, sent, draft, trash.
     */
    function getDashboardData(identity, page_no = null) {

        $("#breadcrumb").text('');
        $("#breadcrumb").text(identity);

        if(identity != '' || identity != null){
            $.ajax({
                url: "./controllers/Dashboard.php",
                method: "POST",
                data: {
                    identity,
                    page_no
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    $(".participants").addClass("d-none");
                    if (data.status == false) {
                        $("#mainCheckbox").hide();
                        $(".email_page").addClass("d-none");
                        $('#mainCheckbox').prop('checked', false);
                        $(".main_content").html('');
                        $(".main_content").append(data.message);
                        $(".main_content").show();
                    }
                    if (data.status == true && data.type == "html_data_found") {
                        $("#mainCheckbox").show();
                        $(".email_page").addClass("d-none");
                        $('#mainCheckbox').prop('checked', false);
                        $(".main_content").html('');
                        $(".main_content").append(data.html);
                        $(".main_content").show();
                    }
                }
            });
        }
    }

    /**
     * This function responsible for pagination.
     * Will return the current paga data.
     */
    $(document).on("click", "#pagination a", function(e) {
        e.preventDefault;
        var page_no = $(this).attr("id");
        var identity = $("#current-sidebar").val();
        var current_field_action = $("#search-field").val();
        if(current_field_action == "search"){
            $("#page-number").val(page_no);
            search_value = $("#searchData").val();
            getSearchResult(search_value, page_no);
        }else{
            getDashboardData(identity, page_no);
        }
    });

    /**
     * this event will delete the slected emails from their respective area.
     */
    $(".deleteEmail").click(function() {
        var selected_mails = [];
        var open_email_id = $("#open-email").val();

        $('input[name="checkbox"]:checked').each(function() {
            selected_mails.push(this.value);
        });
        (selected_mails.length == 0) ? selected_mails.push(open_email_id): "";
        var current_tab = $("#current-sidebar").val();
        deleteEmail(selected_mails, current_tab);

    });

    function deleteEmail(selected_mails, current_tab) {
        var button_val = $(".deleteEmail").val();
        console.log(button_val);
        $.ajax({
            url: "./controllers/Dashboard.php",
            method: "POST",
            data: {
                selected_mails,
                current_tab,
                button_val
            },
            success: function(response) {
                var data = JSON.parse(response);
                if ((data.type == "email_deleted" || data.type == "email_permanent_deleted") && data
                    .status == true) {
                    alertSuccessMessage(data.message);
                    getDashboardData(data.tab);
                }
            }
        });
    }

    /**
     * this function will Restore the emails from trash.
     */
    $(".restoreEmail").click(function() {
        var selected_mails = [];
        var current_tab = $("#current-sidebar").val();
        var open_email_id = $("#open-email").val();
        $('input[name="checkbox"]:checked').each(function() {
            selected_mails.push(this.value);
        });
        (selected_mails.length == 0) ? selected_mails.push(open_email_id): "";
        restoreEmails(selected_mails, current_tab);
    });

    function restoreEmails(restore_mails, existing_tab) {
        $.ajax({
            url: "./controllers/Dashboard.php",
            method: "POST",
            data: {
                restore_mails,
                existing_tab
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.type == "email_restored" && data.status == true) {
                    getDashboardData(data.tab);
                    alertSuccessMessage(data.message);
                } 
                else if (data.status == false) {
                    alertErrorMessage(data.message)
                }
                hideButtons()
            }
        });
    }

    /**
     * This function is responsible to search the email result.
     */
    $("#searchData").keyup(function() {
        search_value = $(this).val();
        if(search_value != '' || search_value != null){
            $("#search-field").val("search");
            $("#page-number").val(1);
        }
        if(search_value == '' || search_value == null){
            $("#search-field").val("");
            $("#page-number").val('');
        }
        
        getSearchResult($(this).val());
    });

    function getSearchResult(search_value, search_page_no = null) {
        $.ajax({
            url: "./controllers/Dashboard.php",
            method: "POST",
            data: {
                search_value,
                search_page_no
            },
            success: function(response) {

                var data = JSON.parse(response);
                console.log(data);
                if (data.type == "html_data_found" && data.status == true) {
                    hideButtons();
                    $("#mainCheckbox").show();
                    $(".email_page").addClass("d-none");
                    $('#mainCheckbox').prop('checked', false);
                    $(".main_content").html('');
                    $(".main_content").append(data.html);
                    $(".main_content").show();

                } 
                else if (data.type == "no_html_data_found" && data.status == false) {
                    hideButtons();
                    $("#mainCheckbox").hide();
                    $(".main_content").html('');
                    $(".main_content").append(data.message);
                } 
                else if (data.type == "empty" && data.status == false) {
                    var current_tab = $("#current-sidebar").val();
                    getDashboardData(current_tab);
                }
            }
        });
    }

    /**
     * This script is responsible for compose the email.
     */

    $(".compose_email").click(function() {
        $(".current-sidebar").val('');
        $("#recipient-email").val('');
        $("#cc-recipient-email").val('');
        $("#bcc-recipient-email").val('');
        $("#email-subject").val('');
        $("#email-content").val('');
        $("#email_error").text('');
        $("#cc_error").text('');
        $("#bcc_error").text('');
        $("#content_error").text('');
        $("#subject_error").text('');
    })

    $("#compose-email").on("submit", function(e) {
        e.preventDefault();
        var to = $("#recipient-email").val();
        var cc = $("#cc-recipient-email").val();
        var bcc = $("#bcc-recipient-email").val();
        var subject = $("#email-subject").val();
        var content = $("#email-content").val();
        var modalFormData = new FormData(this);

        if (to == '' || to == null) {
            $("#email_error").text("Please Enter Email");
        } else {
            $("#email_error").text("");
            var pattern = /^[\w.+\-]+@mailman\.com$/;
            if (!pattern.test(to)) {
                $("#email_error").text("Invalid Email Format");
            } else {
                $("#email_error").text("");
                to_email = true;
            }
        }

        if (cc == '' || cc == null) {
            cc_email = true;
        } else {
            if (cc.indexOf(',') == -1) {
                var pattern = /^[\w.+\-]+@mailman\.com$/;
                if (!pattern.test(cc)) {
                    $("#cc_error").text("Invalid Email Format");
                    cc_email = false;
                } else {
                    $("#cc_error").text("");
                    cc_email = true;
                }
            } else {
                cc_array = cc.split(",");
                $.each(cc_array, function(index, val) {
                    var pattern = /^[\w.+\-]+@mailman\.com$/;
                    if (!pattern.test($.trim(val))) {
                        $("#cc_error").text("Invalid Email Format");
                        cc_email = false;
                        return false;
                    } else {
                        $("#cc_error").text("");
                        cc_email = true;
                    }
                });
            }

        }

        if (bcc == '' || bcc == null) {
            bcc_email = true;
        } else {
            if (bcc.indexOf(',') == -1) {
                var pattern = /^[\w.+\-]+@mailman\.com$/;
                if (!pattern.test(bcc)) {
                    $("#bcc_error").text("Invalid Email Format");
                    bcc_email = false;
                } else {
                    $("#bcc_error").text("");
                    bcc_email = true;
                }
            } else {
                bcc_array = bcc.split(",");
                $.each(bcc_array, function(index, val) {
                    var pattern = /^[\w.+\-]+@mailman\.com$/;
                    if (!pattern.test($.trim(val))) {
                        $("#bcc_error").text("Invalid Email Format");
                        bcc_email = false;
                        return false;
                    } else {
                        $("#bcc_error").text("");
                        bcc_email = true;
                    }
                });
            }

        }

        if (subject == '' || subject == null) {
            $("#subject_error").text("Please Mention a Subject");
            email_subj = false;
        } else {
            email_subj = true;
        }

        if (content == '' || content == null) {
            $("#content_error").text("Please Enter a Message");
            email_content = false;
        } else {
            email_content = true;
        }

        if (to_email == true && cc_email == true && bcc_email == true && email_subj && email_content) {
            $.ajax({
                url: "./controllers/Compose.php",
                method: "POST",
                data: modalFormData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.type == "email_not_found") {
                        $("#email_error").text(data.message);
                    } 
                    else if (data.type == "email_not_inserted") {
                        $("#content_error").text(data.message);
                    } 
                    else if (data.type == "file_count_error") {
                        alertErrorMessage(data.message);
                    } 
                    else if (data.type == "email_inserted") {
                        $('#compose-email-modal').modal('hide');
                        alertSuccessMessage(data.message);
                    } 
                    else if (data.type == "bcc_inserted_cc_updated" || data.type == "cc_inserted_bcc_updated") {
                        $('#compose-email-modal').modal('hide');
                        alertSuccessMessage(data.message);
                    } 
                    else if (data.type == "mail_reciever_error") {
                        if (data.to_error != '') {
                            $("#email_error").text(data.to_error);
                        }
                        if (data.cc_error != '') {
                            $("#cc_error").text(data.cc_error);
                        }
                        if (data.bcc_error != '') {
                            $("#bcc_error").text(data.bcc_error);
                        }

                    } 
                    else if (data.type == 'email_drafted') {
                        $('#compose-email-modal').modal('hide');
                        alertSuccessMessage(data.message);
                    }
                    $("#button-id").val('1');
                }
            });
        }

    });

    $('.close-email').click(function() {
        var to = $("#recipient-email").val();
        var cc = $("#cc-recipient-email").val();
        var bcc = $("#bcc-recipient-email").val();
        var current_tab = $("#current-sidebar").val();
        $("#button-id").val('');
        $("#button-id").val('2');
        if (to != '' && current_tab != "draft") {
            $('#compose-email').trigger('submit');
        }
    });

    /**
     * These two functions are responsible to read and unread the emails.
     */
    $("#read-button").click(function() {
        var selected_mails = [];
        var button_value = $("#read-button").val();
        var open_email_id = $("#open-email").val();

        $('input[name="checkbox"]:checked').each(function() {
            selected_mails.push(this.value);
        });
        (selected_mails.length == 0) ? selected_mails.push(open_email_id) : "";
        console.log(selected_mails);

        isReadUnread(selected_mails, button_value);
    });

    $("#unread-button").click(function() {
        var selected_mails = [];
        var button_value = $("#unread-button").val();
        var open_email_id = $("#open-email").val();

        $('input[name="checkbox"]:checked').each(function() {
            selected_mails.push(this.value);
        });
        (selected_mails.length == 0) ? selected_mails.push(open_email_id) : "";
        console.log(selected_mails);
        isReadUnread(selected_mails, button_value);
    });

    function isReadUnread(selected_mails, button_value) {
        $.ajax({
            url: "./controllers/Dashboard.php",
            method: "POST",
            data: {
                selected_mails,
                button_value
            },
            success: function(response) {
                var email_open = $("#read_unread_email").val();
                if (email_open != "email_opened") {
                    getDashboardData("inbox");
                }
                console.log(response);
            }
        });
    }

    /**
     * this function is responsible to open the Email page.
     */
    $(document).on("click", "#datatable tr", function() {

        var email_id = $(this).find('input:checkbox').val();
        var current_tab = $("#current-sidebar").val();
        var open_email = $("#open-email").val(email_id);
        var drafted_email = $("#drafted_email").val(email_id);
        var search_field_value = $("#searchData").val();
        $("#read_unread_email").val("email_opened");
        // $(".main_content").hide();
        // $("#mainCheckbox").hide();
        // $(".email_page").removeClass("d-none");

        $.ajax({
            url: "./controllers/Dashboard.php",
            method: "POST",
            data: {
                email_id,
                current_tab,
                search_field_value
            },
            success: function(response) {
                var data = JSON.parse(response);
                var current_tab = $("#current-sidebar").val();
                var selected_mails = [];
                var open_email_id = $("#open-email").val();
                var button_value = "read";
                selected_mails.push(open_email_id);
                console.log(data.attachment_file);

                if (data.status == true && data.current_tab != "draft") {
                    let to = data.reciever_email.indexOf(data.my_email);
                    let cc = data.cc_emails.indexOf(data.my_email);
                    $(".main_content").hide();
                    $("#mainCheckbox").hide();
                    $(".email_page").removeClass("d-none");

                    $("#sender_email").text(data.sender_email);
                    $("#to_reciever").text(data.reciever_email);
                    $("#cc_reciever").text(data.cc_emails);
                    $("#bcc_reciever").text(data.bcc_emails);
                    $(".mail_subject").text(data.subject);
                    $(".email_date").text(data.created_at);
                    $(".email_content").text(data.content);
                    $(".attached_files").html('');
                    $(".attached_files").html(data.attachment_file);
                    if (to == -1 && cc == -1) {
                        $(".bcc_participants").removeClass("d-none");
                    } else {
                        $(".bcc_participants").addClass("d-none");
                    }
                    if (data.cc_emails == '' || data.cc_emails == null) {
                        // $(".cc_reciever").hide();
                        $(".cc_reciever").addClass("d-none");
                    } else {
                        // $(".cc_reciever").hide();
                        $(".cc_reciever").removeClass("d-none");
                    }
                    if (data.bcc_emails == '' || data.bcc_emails == null) {
                        $(".bcc_participants").addClass("d-none");
                    }
                    if (data.current_tab == "inbox") {
                        $(".backbutton").removeClass("d-none");
                        $(".deleteEmail").removeClass("d-none");
                        $(".readUnread").removeClass("d-none");
                        isReadUnread(selected_mails, button_value);
                    }
                    if (data.current_tab == "sent") {
                        $(".backbutton").removeClass("d-none");
                        $(".deleteEmail").removeClass("d-none");
                    }
                    if (data.current_tab == "trash") {
                        $(".backbutton").removeClass("d-none");
                        $(".deleteEmail").removeClass("d-none");
                        $(".restoreEmail").removeClass("d-none");
                    }
                }

                if (data.current_tab == "draft") {
                    $("#compose-email-modal").modal("show");
                    console.log(data);
                    $("#recipient-email").val(data.reciever_email);
                    $("#cc-recipient-email").val(data.draft_participants.cc);
                    $("#bcc-recipient-email").val(data.draft_participants.bcc);
                    $("#email-subject").val(data.subject);
                    $("#email-content").val(data.content);
                }
            }
        });
    });

    /**
     * This function responsible to show and hide the email participants.
     */
    $(document).on("click", "#email_participants", function() {
        $(".participants").toggleClass("d-none");

    });

    /**
     * This function will render the current nav tab data when user will click on it.
     */
    $(".backbutton").click(function() {
        var identity = $("#current-sidebar").val();
        var open_email = $("#open-email").val('');
        var page_no = parseInt($("#pagination .active a").text());
        console.log(typeof parseInt(page_no))
        $("#read_unread_email").val("");
        $("#mainCheckbox").show();
        $(".participants").addClass("d-none");
        if($("#search-field").val() == "search" && $("#searchData").val() != ''){
            var identity = "";
            search_value = $("#searchData").val();
            page_no = $("#page-number").val();
            console.log("pageno--"+$("#page-number").val() + " " + "search Val--" + search_value);
            hideButtons();
            getSearchResult(search_value, page_no);
        }
        else{
            hideButtons();
            getDashboardData(identity, page_no);
        }
        // $(".main_content").show();
        // $("#mainCheckbox").show();
        // $(".email_page").addClass("d-none");
        
    });

    /**
     * This event will open a modal with some data to reply the email.
     */
    $(".reply-email").click(function() {
        open_email_id = $("#open-email").val();
        btn_value = $(this).data("btn-value");
        replyEmail(open_email_id, btn_value);
    });

    function replyEmail(open_email_id, btn_value) {
        $.ajax({
            url: "./controllers/Compose.php",
            method: "POST",
            data: {
                open_email_id,
                btn_value
            },
            success: function(response) {
                var data = JSON.parse(response);
                var current_tab = $("#current-sidebar").val();
                $("#recipient-email").val('');
                $("#cc-recipient-email").val('');
                $("#bcc-recipient-email").val('');
                $("#email-subject").val('');
                $("#email-content").val('');
                if (data.btnValue == "reply") {
                    $("#recipient-email").val(data.email_data.sender_email);
                    if (current_tab == "sent") {
                        $("#recipient-email").val(data.email_data.reciever_email);
                    }
                    $("#email-subject").val(data.email_data.subject);
                } else {
                    $("#recipient-email").val(data.sender);
                    if (current_tab == "sent") {
                        $("#recipient-email").val(data.reciever);
                    }
                    $("#cc-recipient-email").val(data.cc);
                    $("#email-subject").val(data.subject);
                }
                console.log(data);
                $("#compose-email-modal").modal("show");
            }
        });
    }

    $("#bcc-recipient-email").keyup(function() {
        if ($(this).val() == '') {
            $("#bcc_error").text('');
        }
    });
    
    $("#cc-recipient-email").keyup(function() {
        if ($(this).val() == '') {
            $("#cc_error").text('');
        }
    });

    function alertSuccessMessage(message){
        setTimeout(function(){
            $(".rightSideAlert").addClass("d-none");
            $(".rightSideAlert").fadeOut(1000);
        }, 3000);
        $(".add-alert-prop").removeClass("alert-danger").addClass("alert-success");
        $(".alert-heading").text('').text("Success");
        $(".alert-message").text('').text(message);
        $(".rightSideAlert").removeClass("d-none");
    }

    function alertErrorMessage(message){
        // setTimeout(() => $(".rightSideAlert").fadeOut(1000), 3000);
        // setTimeout(() => $(".rightSideAlert").addClass("d-none"), 6000);
        setTimeout(function(){
            $(".rightSideAlert").addClass("d-none");
            $(".rightSideAlert").fadeOut(1000);
        }, 3000);
        $(".add-alert-prop").removeClass("alert-success").addClass("alert-danger");
        $(".alert-heading").text('').text("Error");
        $(".alert-message").text('').text(message);
        $(".rightSideAlert").removeClass("d-none");
    }

})
</script>
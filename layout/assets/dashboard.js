/**
 * Function to hide last input[type="file"] and append new one.
 */
function myFunction(obj) {
    $(obj).removeAttr("id");
    $(obj).hide();
    $(".append_file_input").append("<input class='file-input' type='file' id='attached-files' onclick='myFunction(this)' name='attachedfile[]' multiple hidden />");
}

/**
 * Funtion to choose files one by one and create the html for those file.
 */
$(document).on("change",".file-input" , function(){

    var domArray = $('.file-input');
    $('.filenames').html('');
    $("#file_error").html("");

    var rm_files = $("#removed_files").val();
    var rm_files_Arr = [];
    if(rm_files != '' || rm_files != null){
        var rm_files_Arr = $.map(rm_files.split(','), function (el) {
            return el !== '' ? el : null;
        });
    } 

    for (var i = 0; i < domArray.length; i++) {
        var files =  domArray[i].files;
    
        for (var j = 0; j < files.length; j++){
            var result = $.inArray(files[j].name, rm_files_Arr);
            if(result == -1){
                $('.filenames').append('<div><label class="file_label"> x </label> &nbsp; <a href="#" data-size="' + files[j].size + '" class="name">' + files[j].name + '</a></div>');
            }
        }
    };

});

/**
 * Function to remove the attached files from selected files.
 */
$(document).on("click",".file_label" , function(){
    var removed_file = $(this).siblings("a").text();

    var all_removed_file = $("#removed_files").val();
    var rm_file_str = all_removed_file + "," + removed_file;
    $("#removed_files").val(rm_file_str);

    $(this).parent().html('');
});

$(document).ready(function() {

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
        var identity = $(".inbox").data("inbox-value");
        $("#current-sidebar").val(identity);
        // hideButtons()
        getDashboardData(identity);
    });

    $(".sent").click(function() {
        $("#current-sidebar").val('');
        $(".current-sidebar").val('');
        $("#search-field").val("");
        $("#searchData").val('');
        var identity = $(".sent").data("sent-value");
        $("#current-sidebar").val(identity);
        // hideButtons()
        getDashboardData(identity);
    });

    $(".draft").click(function() {
        $("#current-sidebar").val('');
        $("#search-field").val("");
        $("#searchData").val('');
        $(".filenames").html('');
        var identity = $(".draft").data("draft-value");
        $("#current-sidebar").val(identity);
        $(".current-sidebar").val(identity);
        // hideButtons()
        getDashboardData(identity);
    });

    $(".trash").click(function() {
        $("#current-sidebar").val('');
        $("#search-field").val("");
        $("#searchData").val('');
        var identity = $(".trash").data("trash-value");
        $("#current-sidebar").val(identity);
        $(".current-sidebar").val('');
        // hideButtons();
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

            ($("#search-field").val() != '') ? $(".deleteEmail").removeClass("d-none") : showButtons() ;

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
        
        ($('.checkbox:checked').length > 0) ? (($("#search-field").val() != '') ? $(".deleteEmail").removeClass("d-none") : showButtons()) : hideButtons() ;

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
                        hideButtons();
                    }
                    if (data.status == true && data.type == "html_data_found") {
                        $("#mainCheckbox").show();
                        $(".email_page").addClass("d-none");
                        $('#mainCheckbox').prop('checked', false);
                        $(".main_content").html('');
                        $(".main_content").append(data.html);
                        $(".main_content").show();
                        hideButtons();
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
        // hideButtons();
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
        console.log(selected_mails);
        deleteEmail(selected_mails, current_tab);

    });

    function deleteEmail(selected_mails, current_tab) {
        var button_val = $(".deleteEmail").val();
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
                if ((data.type == "email_deleted" || data.type == "email_permanent_deleted") && data.status == true) {
                        // hideButtons();
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
                hideButtons();
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
            hideButtons();
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
        $("#drafted_email").val('');
        $(".filenames").html('');
        $(".file-input").val('');
        $("#removed_files").val('');
        $("#file_error").text('');
    })

    $("#compose-email").on("submit", function(e) {
        e.preventDefault();
        var to = $("#recipient-email").val();
        var cc = $("#cc-recipient-email").val();
        var bcc = $("#bcc-recipient-email").val();
        var subject = $("#email-subject").val();
        var content = $("#email-content").val();
        var buttonVal = $("#button-id").val();
        var modalFormData = new FormData(this);
        var file_status = true;
        var to_email;
        // alert(buttonVal);


        if(buttonVal == "close"){
            to_email = true;
            email_subj = true;
            email_content = true;
            cc_email = true;
            bcc_email = true;
        }else{

            if (to == '' || to == null) {
                $("#email_error").text("Please Enter Email");
            } else {
                $("#email_error").text("");
                var pattern = /^[\w.+\-]+@mailman\.com$/;
                if (!pattern.test(to.trim())) {
                    $("#email_error").text("Invalid Email Format");
                } else {
                    $("#email_error").text("");
                    to_email = true;
                }
            }

            if (subject == '' || subject == null) {
                $("#subject_error").text("Please Mention a Subject");
                email_subj = false;
            } else {
                $("#subject_error").text("");
                email_subj = true;
            }

            if (content == '' || content == null) {
                $("#content_error").text("Please Enter a Message");
                email_content = false;
            } else {
                $("#content_error").text("");
                email_content = true;
            }

        

            if (cc == '' || cc == null) {
                cc_email = true;
            } 
            else {
                if (cc.indexOf(',') == -1) {
                    var pattern = /^[\w.+\-]+@mailman\.com$/;
                    if (!pattern.test(cc.trim())) {
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
                        } else {
                            $("#cc_error").text("");
                            cc_email = true;
                        }
                    });
                }
            }

            if (bcc == '' || bcc == null) {
                bcc_email = true;
            } 
            else {
                if (bcc.indexOf(',') == -1) {
                    var pattern = /^[\w.+\-]+@mailman\.com$/;
                    if (!pattern.test(bcc.trim())) {
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
                        } else {
                            $("#bcc_error").text("");
                            bcc_email = true;
                        }
                    });
                }
            }
        }

        // file validation starts -

        // var myFile = $('input[type="file"]').prop('files');

        if($('.filenames a').length  != 0){

            var file_size_arr = [];
            var total_file_size = 0;

            $('.filenames a').each(function () {
                one_file_size = $(this).data("size")
                file_size_arr.push(one_file_size);
                total_file_size += parseFloat(one_file_size) || 0; 
            });

            if(file_size_arr.length >20){
                $("#file_error").text("The number of files should not be greater than 20");
                file_status = false;
            }else{
                if(total_file_size > 12*1048576){
                    $("#file_error").text("File size too large. Please choose files less than 12MB");
                    file_status = false;
                }else{
                    file_status = true;
                    $("#file_error").text('');
                }
            }
        }else{
            $("#file_error").text('');
            file_status = true;
        }

        if (to_email && cc_email && bcc_email && email_subj && email_content && file_status) {
        
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
                        // alertErrorMessage(data.message);
                        $("#content_error").text(data.message);
                    } 
                    else if(data.type == "file_size_error"){
                        // alertErrorMessage(data.message);
                        $("#content_error").text(data.message);
                    }
                    else if (data.type == "email_inserted") {
                        $('#compose-email-modal').modal('hide');
                        alertSuccessMessage(data.message);
                        $("#removed_files").val('');
                        var current_tab = $("#current-sidebar").val();
                        getDashboardData(current_tab);
                    } 
                    else if (data.type == "bcc_inserted_cc_updated" || data.type == "cc_inserted_bcc_updated") {
                        $('#compose-email-modal').modal('hide');
                        alertSuccessMessage(data.message);
                        $("#removed_files").val('');
                        var current_tab = $("#current-sidebar").val();
                        getDashboardData(current_tab);
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
                        var current_tab = $("#current-sidebar").val();
                        getDashboardData(current_tab);
                    }
                    else if(data.type == 'drafted_email_updated'){
                        $('#compose-email-modal').modal('hide');
                        var current_tab = $("#current-sidebar").val();
                        getDashboardData(current_tab);
                    }
                    $("#button-id").val('1');
                    $("#removed_files").val('');
                }
            });
        }
    });

    $('.close-email').click(function() {
        var to = $("#recipient-email").val();
        var cc = $("#cc-recipient-email").val();
        var bcc = $("#bcc-recipient-email").val();
        var subject = $("#email-subject").val();
        var content = $("#email-content").val();
        var current_tab = $("#current-sidebar").val();
        var attached_file = $("#attached-files").val();
        $("#button-id").val('');
        $("#button-id").val('close');
        if (to != '' || cc != '' || bcc != '' || subject != '' || content != '' || attached_file !='') {
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
                    // hideButtons();
                    getDashboardData("inbox");
                }
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
                // console.log(data);

                if (data.status == true && data.current_tab != "draft" && data.draft_participants == '') {
                    
                    var bcc = data.bcc_emails.indexOf(data.my_email);
                
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
                    if (bcc != -1) {
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
                        (data.bcc_emails == '' || data.bcc_emails == null) ? 
                                $(".bcc_participants").addClass("d-none") : 
                                $(".bcc_participants").removeClass("d-none");
                        
                    }
                    if (data.current_tab == "trash") {
                        $(".backbutton").removeClass("d-none");
                        $(".deleteEmail").removeClass("d-none");
                        $(".restoreEmail").removeClass("d-none");
                    }
                }

                if (data.current_tab == "draft" || data.draft_participants != '') {
                    $("#email_error").text('');
                    $("#cc_error").text('');
                    $("#bcc_error").text('');
                    $("#content_error").text('');
                    $("#subject_error").text('');
                    $("#compose-email-modal").modal("show");
                    (data.reciever_email != null) ? $("#recipient-email").val(data.reciever_email) : $("#recipient-email").val(data.draft_participants.to) ;
                    $("#cc-recipient-email").val(data.draft_participants.cc);
                    $("#bcc-recipient-email").val(data.draft_participants.bcc);
                    $("#email-subject").val(data.subject);
                    $("#email-content").val(data.content);
                    // $(".filenames").append(data.attachment_file);
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
        $("#read_unread_email").val("");
        $("#mainCheckbox").show();
        $(".participants").addClass("d-none");

        if($("#search-field").val() == "search" && $("#searchData").val() != ''){
            var identity = "";
            search_value = $("#searchData").val();
            page_no = $("#page-number").val();
            hideButtons();
            getSearchResult(search_value, page_no);
        }
        else{
            // hideButtons();
            getDashboardData(identity, page_no);
        }
    });

    /**
     * This event will open a modal with some data to reply the email.
     */
    $(".reply-email").click(function() {
        $(".filenames").html('');
        $(".file-input").val('');
        $("#removed_files").val('');
        $("#file_error").text('');
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
                    if(data.email_data.subject.indexOf("Re") == -1){
                        $("#email-subject").val("Re - " + data.email_data.subject);
                    }else{
                        $("#email-subject").val(data.email_data.subject);
                    }
                } 
                else {
                    $("#recipient-email").val(data.sender);
                    if (current_tab == "sent") {
                        $("#recipient-email").val(data.reciever);
                    }
                    $("#cc-recipient-email").val(data.cc);
                    // $("#email-subject").val("Re - " + data.subject);
                    if(data.subject.indexOf("Re") == -1){
                        $("#email-subject").val("Re - " + data.subject);
                    }else{
                        $("#email-subject").val(data.subject);
                    }
                }
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

});
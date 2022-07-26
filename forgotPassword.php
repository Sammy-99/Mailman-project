<?php

include_once("./layout/head.php"); 

?>

<div class="container-fluid">
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

    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-5 my-auto">
            <div class="">
                <label class="font-weight-bolder" for="user_name" style="font-size:25px;">Enter Your Username/Mailman Address : </label>
                <input type="text" id="user_name" name="user_name" class="form-control form-control-lg w-75 mb-3" placeholder="Enter Username/Mailman Address" />
            </div>
            
                <div class="col-md-6 text-danger font-weight-bolder" id="email_error"></div><br>
            
            <div>
                <input class="btn btn-primary" type="submit" id="forgot_password" value="Submit">
            </div>
        </div>
        <div class="col-md-5 my-auto">
            <img src="./layout/assets/gmail.png" style="max-width: 100%;" alt="">
        </div>
        <div class="col-md-1"></div>
    </div>
</div>

<?php include_once("./layout/footer.php"); ?>

<script>
    $(document).ready(function(){

        $("#user_name").on("change keyup", function() {
            $("#email_error").text("");
        });

        $("#forgot_password").click(function(e) {
            e.preventDefault();
            var user_name = $("#user_name").val();
            var forgot_password = "forgot_password";

            if (user_name == '' || user_name == null) {
                $("#email_error").text("Please Enter Mailmail Address or Username");
                return false;
            } else {
                $("#email_error").text("");
            }

            console.log(user_name + "   " + forgot_password)

            $.ajax({
                url: "./controllers/Login.php",
                method: "POST",
                data: {
                    user_name,
                    forgot_password
                },
                success: function(data) {
                    var response = JSON.parse(data);
                    if (response.status == true && response.type == "mail_sent") {
                        $("#email_error").text('');
                        alertSuccessMessage(response.message);
                    } 
                    else if (response.status == false && response.type == "username_not_exist") {
                        $("#email_error").text(response.message);
                    } 
                    else if (response.type == "mail_not_sent") {
                        $("#email_error").text('');
                        alertErrorMessage(response.message);
                    }
                }
            });
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
</script>
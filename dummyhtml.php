<li class="page-item disabled">
    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
</li>


<li class="page-item">
    <a class="page-link" href="#">Next</a>
</li>



Group by cc_bcc.email_id


2097152

var FileUploadPath = document.getElementById('imageupload').value;
Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

if (FileUploadPath == "") {
                document.getElementById('photos').innerHTML = " **Please upload an image";
                user_photo = false;
                // }
                // else if (FileUploadPath.files[0].size > 2097152) {
                //     document.getElementById('photos').innerHTML = "Please select image size less than 2 MB";
                //     user_photo = false;
            } else {
                if (allowed_ext.indexOf(Extension) !== -1) {
                    document.getElementById('photos').innerHTML = "";
                    user_photo = true;
                    // alert('match');
                } else {
                    document.getElementById('photos').innerHTML = " **photo only allows file types of PNG, JPG ";
                }
            }
1:24
if (first_name != true || last_name != true || user_name != true || user_photo != true || user_email != true || r_email != true || user_pass != true || user_cpass != true) {
                // alert("some error occur! please retry!");
                return false;
            }


###########################################################################################################################

loginform --- 

<!-- <form action="#" id="login-form">
                <div class="row">
                    <label class="col-md-4 label control-label">Email/Username</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="user_name" name="user_name"
                            placeholder="Enter Email">
                        <small class="field-error" id="email_error"></small>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-4 label control-label">Password</label>
                    <div class="col-md-8">
                        <input type="password" class="form-control" id="userpass" name="userpass"
                            placeholder="Enter Password">
                        <small class="field-error" id="pass_error"></small>
                    </div>
                </div>
                <br>
                <div class="row">
                    <label class="col-md-4 label control-label"></label>
                    <div class="col-md-8">
                        <a href="" id="forgot_password">Forgot Password?</a>
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-md-6 text-danger" id="credential_error"></div>
                    <div class="col-md-6"></div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success btn-block btn-login">Log In</button>
                    </div>
                    <div class="col-md-2"></div>
                    <label class="col-md-4 label control-label"><a href="./registration.php">Sign Up Instead</a>
                    </label>
                </div>

                <br><br>
            </form> -->
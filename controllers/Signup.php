<?php

error_reporting( E_ALL );
ini_set( "display_errors", 1 );
// header('Content-type: application/json');

/**
 * SignUp class handles all server side validation on new users to create thier the account.
 * validate the Files.
 * Validate the users email and username.
 */
class SignUp{

    // const BASE_URL = "/tse/Mailman-project/";
    protected $username;
    protected $firstname;
    protected $lastname;
    protected $email;
    protected $password;
    protected $secondary_email;
    protected $dob;
    protected $profile_image = null;

    public function getUserData()
    {
        $checkImageDetails = !empty($_FILES['user-image']['name']) ? Validate::checkImageType($_FILES) : null ;
        if(!empty($checkImageDetails) && $checkImageDetails != null){
            $jsonImageMessage = json_decode($checkImageDetails, true);
            if($jsonImageMessage['type'] == 'invalid_filetype'){
                echo $checkImageDetails; exit;
            }
            elseif($jsonImageMessage['type'] == 'invalid_filesize'){
                echo $checkImageDetails; exit;
            }
            elseif($jsonImageMessage['type'] == 'valid_image')
            {
                // $todir = "/var/www/html/launchpadtwo/uploadedimage/";
                // $todir = StoreUrl::$baseUrl . "uploadedimage/";
                $todir = "../uploadedimage/";
                $uniqueSaveName = time()."-".$_FILES['user-image']['name'] ;
                if ( move_uploaded_file( $_FILES['user-image']['tmp_name'], $todir . $uniqueSaveName)){
                    $this->profile_image = $uniqueSaveName;
                }   
            }
        }

        if(isset($_POST['username']) && isset($_POST['userpassword'])){
            $validation = $this->isValid($_POST);
            if($validation !== true){
                echo json_encode(["status" => false, "error" => $validation]); exit;
            }

            $checkDuplicateUser = Validate::checkDuplicatekUser($this->username, $this->email);
            $jsonMessage = json_decode($checkDuplicateUser, true);
            if($jsonMessage['type'] == 'user_exist'){
                echo $checkDuplicateUser; exit;
            }
            if($jsonMessage['type'] == 'no_user_found'){
                $createUser = Crud::createUser($this->username, $this->firstname, $this->lastname, $this->email, $this->password, $this->secondary_email, $this->profile_image);
                echo $createUser; exit;
            }
        }

        echo json_encode(["type" => "error", "message" => "Something went wrong", "status" => false]); exit;
    }

    public function isValid($post)
    {
        $result = [];
        $username = trim($_POST['username']);
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $email = trim($_POST['useremail']);
        $password = trim($_POST['userpassword']);
        $cPassword = trim($_POST['c-password']);
        $secondEmail = trim($_POST['secondary-email']);

        switch ($username) {
            case "":
                $result['username_error'] = "Please Enter Username";
                break;
            case (strpos($username, " ") > 0):
                $result['username_error'] = "Username should not contain spaces";
                break;
            case (strlen($username) < 5):
                $result['username_error'] = "Username should be atleast 5 characters long";
                break;
            case ((strpos($username, "'") !== false) || (strpos($username, "=") !== false)):
                $result['username_error'] = "Illegal Characters";
                break;
            case ((strpos($username, "<") !== false) || (strpos($username, ">") !== false)):
                $result['username_error'] = "Illegal Characters";
                break;
            default:
                
                if(preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/i', $username)){
                    $result['username_error'] = "";
                    $this->username = $username;
                }else{
                    $result['username_error'] = "Username should be Alphanumeric!";
                }
        }
          
        switch ($firstname) {
            case "":
                $result['fname_error'] = "Please Enter Firstname";
                break;
            case (strlen($firstname) < 3):
                $result['fname_error'] = "Firstname should be atleast 3 characters long";
                break;
            default:
                
                if(preg_match('/^[a-zA-Z]+$/i', $firstname)){
                    $result['fname_error'] = "";
                    $this->firstname = $firstname;
                }else{
                    $result['fname_error'] = "Firstname should be Alphabatic!";
                }
        }
          
        switch ($lastname) {
            case "":
                $result['lname_error'] = "Please Enter Lastname";
                break;
            case (strlen($lastname) < 3):
                $result['lname_error'] = "Lastname should be atleast 3 characters long";
                break;
            default:
                
                if(preg_match('/^[a-zA-Z]+$/i', $lastname)){
                    $result['lname_error'] = "";
                    $this->lastname = $lastname;
                }else{
                    $result['lname_error'] = "Lastname should be Alphabatic!";
                }
        }
          
        switch ($email) {
            case "":
                $result['email_error'] = "Please Enter Email";
                break;
            case (strpos($email, " ") > 0):
                $result['email_error'] = "Email should not contain spaces";
                break;
            case ((strpos($email, "'") !== false) || (strpos($email, "=") !== false)):
                $result['email_error'] = "Illegal Characters";
                break;
            case ((strpos($email, "<") !== false) || (strpos($email, ">") !== false)):
                $result['email_error'] = "Illegal Characters";
                break;
            case (strlen($email) < 3):
                $result['email_error'] = "Email should be atleast 3 characters long";
                break;
            default:

                if(preg_match('/^[\w.+\-]+$/i', $email)){
                    $email = $email . "@mailman.com";
                    $this->email = $email;
                    $result['email_error'] = '';
                }else{
                    $result['email_error'] = "Just enter Alpha or Alphanumeric value";
                }
        }
          
        switch ($password) {
            case "":
                $result['pass_error'] = "Please Enter Password";
                break;
            case (strpos($password, " ") > 0):
                $result['pass_error'] = "Password should not contain spaces";
                break;
            case ((strpos($password, "'") !== false) || (strpos($password, "=") !== false)):
                $result['pass_error'] = "Illegal Characters";
                break;
            case ((strpos($password, "<") !== false) || (strpos($password, ">") !== false)):
                $result['pass_error'] = "Illegal Characters";
                break;
            case (strlen($password) < 6):
                $result['pass_error'] = "Password should be atleast 6 characters long";
                break;
            default:
                if(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/i', $password)){
                    $result['pass_error'] = "";
                    $this->password = password_hash($password, PASSWORD_DEFAULT);
                }else{
                    $result['pass_error'] = "Password must contain atleast 1 small character, 1 upper case character, 1 numeric key and 1 special character";
                }
        }
          
        switch ($cPassword) {
        case "":
            $result['cpass_error'] = "Please Enter Confirm Password";
            break;
        default:
            $result['cpass_error'] = ($password == $cPassword) ? "" : "Password must be same" ;
        }
          
        switch ($secondEmail) {
        case "":
            $result['semail_error'] = "Please Enter Email";
            break;
        case (strpos($secondEmail, " ") > 0):
            $result['semail_error'] = "Email should not contain spaces";
            break;
        case (strlen($secondEmail) < 3):
            $result['semail_error'] = "Email should be atleast 3 characters long";
            break;
        default:

            if(preg_match('/^[\w.+\-]+@gmail\.com$/i', $secondEmail) || preg_match('/^[\w.+\-]+@yahoo\.com$/i', $secondEmail)){
                $result['semail_error'] = "";
                $this->secondary_email = $secondEmail;
            }else{
                $result['semail_error'] = "Not a valid email format!";
            }
        }
        
        if($result['username_error'] == '' && $result['fname_error'] == '' && $result['lname_error'] == '' && $result['email_error'] == '' && $result['pass_error'] == '' && $result['cpass_error']=='' && $result['semail_error'] == ''){
            return true;
        }

        return $result;
    }
}
    
spl_autoload_register(function ($className) {
    require_once("./models/" . $className . ".php");
});
    
$signup = new SignUp();
$signup->getUserData();



?>
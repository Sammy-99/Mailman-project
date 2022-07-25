<?php
session_start();
error_reporting( E_ALL );
ini_set( "display_errors", 1 );

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

/**
 * Class LogIn handles the all logical part to authenticate the users.
 * class Validate handle database logic for this class.
 */
class Login{

    protected $username;

    protected $email;

    protected $password;

    /**
     * This function will check the authentication for the users.
     */
    public function checkUserAuthentication()
    {
        if(isset($_POST['user_name']) && isset($_POST['userpass'])){
            
            $checkValidDetails = $this->isValidDetails($_POST['user_name'], $_POST['userpass']);

            if($checkValidDetails !== true){
                echo json_encode(["status" => false, "type" => "login_error", "error" => $checkValidDetails]); exit;
            }
            
            if(filter_var($_POST['user_name'], FILTER_VALIDATE_EMAIL)){
                $userAuth = Validate::authenticateUser($this->username, $this->password);
            }else{
                $userAuth = Validate::authenticateUser($this->username, $this->password);
            }

            $userAuthJson = json_decode($userAuth, true);
            if($userAuthJson['type'] == 'no_user_found'){
                echo $userAuth; exit;
            }
            elseif($userAuthJson['type'] == 'password_not_matched'){
                echo $userAuth; exit;
            }
            elseif($userAuthJson['type'] == 'password_matched'){
                
                $_SESSION["username"] = $userAuthJson['username'];
                $_SESSION["email"] = $userAuthJson['email'];
                $_SESSION["id"] = $userAuthJson['userId'];
                echo $userAuth; exit;
            }
        }

    }

    public function isValidDetails($username, $password)
    {
        $result = [];
        $username = trim($username);
        $password = trim($password);

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
                $result['username_error'] = "";
                $this->username = $username;
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
                $result['pass_error'] = "";
                $this->password = $password;
        }

        if($result['username_error'] == '' && $result['pass_error'] == ''){
            return true;
        }

        return $result;
    }

    /**
     * Function to reset the password.
     */
    public function resetPassword(){

        if($_POST['forgot_password'] == "forgot_password"){
            $getRecoveryEmail = Validate::getRecoveryEmail($_POST['user_name']);
            $getRecoveryEmailJson = json_decode($getRecoveryEmail, true);
            if($getRecoveryEmailJson['type'] == "username_exist" && !empty($getRecoveryEmailJson['recoveryEmail'])){
                $sendEmail = $this->sendEmailForPasswordReset($getRecoveryEmailJson['recoveryEmail'], $getRecoveryEmailJson['userId']);
                echo $sendEmail; exit;
            }else{
                echo $getRecoveryEmail; exit;
            }
        }
    }

    public function updateUserPassword($newPasssword, $userId)
    {
        if(!empty($newPasssword) && !empty($userId)){
            $newPasssword = password_hash(trim($newPasssword), PASSWORD_DEFAULT);
            $updatePassword = Crud::updatePassword($newPasssword, $userId);
            $updatePasswordJson = json_decode($updatePassword, true);
            if($updatePasswordJson['type'] == "password_updated"){
                echo $updatePassword; exit;
            }

            echo $updatePassword; exit; 
        }
    }

    /**
     * This function will send the reset link on the recovery email.
     * when user click on the Forgot password.
     */
    public function sendEmailForPasswordReset($recoveryEmail, $userId)
    {
        $mail = new PHPMailer(true);

        try {
                  
            $mail->isSMTP();                                           
            $mail->Host       = 'smtp.gmail.com';                     
            $mail->SMTPAuth   = true;                                   
            $mail->Username   = Config::EMAIL;                    
            $mail->Password   = Config::APP_PASSWORD;                             
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
            $mail->Port       = 465;                                    

            $mail->setFrom($recoveryEmail, 'Email For Password Reset');
            $mail->addAddress($recoveryEmail);             
            $mail->isHTML(true);                                 
            $mail->Subject = 'Reset Password'.time();
            // $mail->Body    = html_entity_decode("Please Click on the link to Reset the Password <a href='http://localhost/launchpadtwo/resetpassword.php?user_id=".$userId."'>Click Here</a>");
            $mail->Body    = html_entity_decode("Please Click on the link to Reset the Password <a href='http://hestalabs.com/tse/Mailman-project/resetpassword.php?user_id=".$userId."'>Click Here</a>");

            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if($mail->send()){
                $_SESSION["reset_password"] = "user_exist";
                return json_encode(["status" => true, "type" => "mail_sent", "message" => "We are sending you a Password Reset Link on your recovery Email."]);
            }
        } catch (Exception $e) {
            return json_encode(["status" => false, "type" => "mail_not_sent", "message" => "Mail could not be sent."]);
        }
    }
}

spl_autoload_register(function ($className) {
    require_once("./models/" . $className . ".php");
});

// print_r($_POST); die(" kkkkk ");
$login = new Login();

if(isset($_POST['user_name']) && isset($_POST['userpass'])){
    $login->checkUserAuthentication();
}

if(isset($_POST['user_name']) && isset($_POST['forgot_password'])){
    $login->resetPassword();
}

if(isset($_POST['reset_password']) && isset($_POST['user_id'])){
    $login->updateUserPassword($_POST['reset_password'], $_POST['user_id']);
}

// print_r($_POST); die(" reset ");
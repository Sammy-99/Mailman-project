<?php

error_reporting( E_ALL );
ini_set( "display_errors", 1 );
// header('Content-type: application/json');

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
            $this->password = trim($_POST['userpass']);

            if(filter_var($_POST['user_name'], FILTER_VALIDATE_EMAIL)){
                $this->email = trim($_POST['user_name']);
                $userAuth = Validate::authenticateUser($this->username, $this->email, $this->password);
            }else{
                $this->username = trim($_POST['user_name']);
                $userAuth = Validate::authenticateUser($this->username, $this->email, $this->password);
            }

            $userAuthJson = json_decode($userAuth, true);
            if($userAuthJson['type'] == 'no_user_found'){
                echo $userAuth; exit;
            }
            elseif($userAuthJson['type'] == 'password_not_matched'){
                echo $userAuth; exit;
            }
            elseif($userAuthJson['type'] == 'password_matched'){
                session_start();
                $_SESSION["username"] = $userAuthJson['username'];
                $_SESSION["email"] = $userAuthJson['email'];
                $_SESSION["id"] = $userAuthJson['userId'];
                echo $userAuth; exit;
            }
        }

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
                // $sendEmailJson = json_decode($sendEmail, true);
                // if($sendEmailJson['status'] == true && $sendEmailJson['type'] == "mail_sent"){
                // }
            }else{
                echo $getRecoveryEmail; exit;
            }
        }
    }

    public function updateUserPassword($newPasssword, $userId)
    {
        // print_r([$newPasssword, $userId]); die (" get id ");
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
            $mail->Username   = 'samirhestabit999@gmail.com';                    
            $mail->Password   = 'ojsdtutobkfxayxw';                             
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

$login = new Login();
$login->checkUserAuthentication();

if(isset($_POST['user_name']) && isset($_POST['forgot_password'])){
    $login->resetPassword();
}

if(isset($_POST['reset_password']) && isset($_POST['user_id'])){
    $login->updateUserPassword($_POST['reset_password'], $_POST['user_id']);
}

// print_r($_POST); die(" reset ");
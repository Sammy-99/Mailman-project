<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


$mail = new PHPMailer(true);

try {

    $mail->IsSMTP();  // telling the class to use SMTP
           $mail->SMTPDebug = 2;
           $mail->Mailer = "smtp";
           $mail->Host = "ssl://smtp.gmail.com";
           $mail->Port = 587;
           $mail->SMTPAuth = true; // turn on SMTP authentication
           $mail->Username = "myemail@example.com"; // SMTP username
           $mail->Password = "mypasswword"; // SMTP password
           $Mail->Priority = 1;
           $mail->AddAddress("samirahamad999@gmail.com","Name");
           $mail->SetFrom("myemail@example.com", $name);
           $mail->AddReplyTo("myemail@example.com",$name);
           $mail->Subject  = "This is a Test Message";
           $mail->Body     = "sdsfsdfsdfsdfsdfsdfsfs";
           $mail->WordWrap = 50;
           $mail->Send();
        //    if(!$mail->Send()) {
        //    echo 'Message was not sent.';
        //    echo 'Mailer error: ' . $mail->ErrorInfo;
        //    } else {
        //    echo 'Message has been sent.';
        //    }
 
                  
    // $mail->isSMTP();                                           
    // $mail->Host       = 'smtp.gmail.com';                     
    // $mail->SMTPAuth   = true;                                   
    // $mail->Username   = 'samirahamad999@gmail.com';                    
    // $mail->Password   = 'ojsdtutobkfxayxw';                             
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
    // // $mail->Port       = 465;    
    // $mail->Port       = 587;                                    

    // $mail->setFrom('samirahamad999@gmail.com', 'Dev Ninja Youtube');
    // $mail->addAddress('samirahamad999@gmail.com');             

    // $mail->isHTML(true);                                 
    // $mail->Subject = 'Here is the subject'.time();
    // $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    // $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


$mail = new PHPMailer(true);

try {
 
                  
    $mail->isSMTP();                                           
    $mail->Host       = 'smtp.gmail.com';                     
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'samirhestabit999@gmail.com';                    
    $mail->Password   = 'ojsdtutobkfxayxw';                             
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  
    // $mail->SMTPSecure = "ssl";          
    $mail->Port       = 465;    
    // $mail->Port       = 587;                                    

    $mail->setFrom('samirhestabit999@gmail.com', 'Dev Ninja Youtube');
    $mail->addAddress('samirahamad999@gmail.com');             

    $mail->isHTML(true);                                 
    $mail->Subject = 'Here is the subject'.time();
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

//$mail->isSMTP();
// $mail->SMTPDebug = 2;
// $mail->Host = "smtp.gmail.com";
// $mail->SMTPAuth = true;

// // But you can comment from here
// $mail->SMTPSecure = "tls";
// $mail->Port = 587;
// $mail->CharSet = "UTF-8";
// // To here. 'cause default secure is TLS.

// $mail->setFrom("samirhestabit999@gmail.com", "Ololoev");
// $mail->Username = "samirhestabit999@gmail.com";
// $mail->Password = "ojsdtutobkfxayxw";

// $mail->Subject = "Тест";
// $mail->msgHTML("Test");
// $mail->addAddress("samirhestabit999@gmail.com", "Alex");

// if (!$mail->send()) {
// echo " not send ";
// } else {
// echo "mail send ";
// }
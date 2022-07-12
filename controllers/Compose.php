<?php
session_start();

error_reporting( E_ALL );
ini_set( "display_errors", 1 );

/**
 * This class handle the logic of Email Compose.
 * ComposeModel class handle all the database lagic for this class.
 */
class Compose{

    protected $attachmentFiles;

    /**
     * This function will check the validation on attached files with the compose email and then
     * save the value in database table. 
     */
    public function composedEmail($post, $files)
    {
        if(!empty($post['recipient-email'])){
            $attachedFiles = NULL;
            if(array_key_exists('0', $_FILES["attachedfile"]["name"])){
                $attachedFiles = !empty($_FILES["attachedfile"]["name"][0]) ? $this->chechFilesValidation() : false ;
            }

            $userId = $_SESSION['id'];
            $to = trim($_POST['recipient-email']);
            $cc = $_POST['cc-recipient-email'];
            $bcc = $_POST['bcc-recipient-email'];
            $subject = $_POST['email-subject'];
            $content = $_POST['email-content'];
            $buttonId = $_POST['button-id']; 
            $currentTab = $_POST['current-sidebar'];
            $draftEmailId = $_POST['drafted_email'];
            // print_r($_POST); die(" compose ");
            $saveComposeEmail = ComposeModel::saveComposeEmailData($to, $cc, $bcc, $subject, $content, $attachedFiles, $userId, $buttonId, $currentTab, $draftEmailId);

            echo $saveComposeEmail; exit;
        }
    }

    /**
     * This function check the validation of the attached Files.
     */
    public function chechFilesValidation()
    {
        $fileNameArray = [];
        $filesName = array_filter($_FILES["attachedfile"]["name"]);
        $fileSize = array_filter($_FILES["attachedfile"]["size"]);
        $fileTmpName = array_filter($_FILES["attachedfile"]["tmp_name"]);
        $total_files = count($_FILES["attachedfile"]["name"]);
        $checkFilestype = ComposeModel::checkFileType($filesName);
        $filesInfoJson = json_decode($checkFilestype, true);
        if($filesInfoJson['status'] == false){
            echo $checkFilestype; exit;
        }
        $totalFilesSize = array_sum($fileSize);
        if ($totalFilesSize > 0 && $totalFilesSize < 20 * Validate::MB){      
            // $todir = "/var/www/html/launchpadtwo/attachedfiles/";
            $todir = StoreUrl::$baseUrl . "attachedfiles/";
            for($i=0; $i<$total_files; $i++){
                $uniqueSaveName = time()."-".$_FILES['attachedfile']['name'][$i] ;
                if (move_uploaded_file( $_FILES['attachedfile']['tmp_name'][$i], $todir . $uniqueSaveName)){
                    array_push($fileNameArray, $uniqueSaveName);
                } 
            }
            $this->attachmentFiles = join(", ", $fileNameArray);
        }
        
        return $this->attachmentFiles;
    }

    /**
     * This function return the Open email data for reply the email.
     */
    public function getOpenEmailReplyData($emailId, $btnValue)
    {
        $emailData = ComposeModel::getReplyData($emailId, $btnValue);
        if($btnValue == "reply"){
            echo json_encode(["type" => "reply_email", "email_data" => $emailData, "btnValue" => $btnValue]); exit;
        }else{
            $sender = $emailData[0]['sender_email'];
            $reciever = $emailData[0]['reciever_email'];
            $subject = $emailData[0]['subject'];
            $cc_id = array_filter(array_column($emailData, 'cc_id'));
            $cc_emailArr = DashboardModel::getCcBccEmails($cc_id);
            $cc_emails = (count($cc_emailArr) > 0) ? implode(", ", $cc_emailArr) : "" ;
            $bcc_id = array_filter(array_column($emailData, 'bcc_id'));
            $bcc_emailArr = DashboardModel::getCcBccEmails($bcc_id);
            $bcc_emails = (count($bcc_emailArr) > 0) ? implode(", ", $bcc_emailArr) : "" ;
            
            echo json_encode([
                "type" => "reply_all_email", 
                "sender" => $sender, 
                "reciever" => $reciever, 
                "cc" => $cc_emails, 
                "bcc" => $bcc_emails, 
                "subject" => $subject, 
                "btnValue" => $btnValue
            ]); exit;
        }
    }
}

spl_autoload_register(function ($className) {
    require_once("./models/" . $className . ".php");
});

$compose = new Compose();

/**
 * This function responsible to compose the email.
 */
if(isset($_POST['recipient-email'])){
    $compose->composedEmail($_POST, $_FILES);
}

if(!empty($_POST['open_email_id'])){
    $compose->getOpenEmailReplyData($_POST['open_email_id'], $_POST['btn_value']);
}

// print_r($_SESSION);
// die(" kkkk ");

print_r($_POST);
print_r($_FILES);
die(" testingggg ");
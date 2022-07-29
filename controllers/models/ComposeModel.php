<?php

error_reporting( E_ALL );
ini_set( "display_errors", 1 );

/**
 * This class handle the Database logic for Email Compose.
 * ComposeModel insert and update the data for Compose class.
 */
class ComposeModel{

    protected static $dbc;

    public function __construct(){
        self::$dbc = DB::getDbConn();
    }

    /**
     * This function insert and update the cc and bcc related data for a new or drafted Email.
     */
    public static function saveComposeEmailData($to, $cc, $bcc, $subject, $content, $attachedFiles, $userId, $buttonId, $currentTab, $draftEmailId)
    {
        $toError = '';
        $ccError = '';
        $bccError = '';
        $date = date('Y-m-d H:i:s');
        $reciever = self::checkUser($to);

        if($buttonId == 'close'){
            $recieverId = ($reciever != '' && count($reciever) > 0) ? $reciever['id'] : 0 ;
            $ccBccArray = ["to" => $to, "cc" => $cc, "bcc" => $bcc];
            $serializeCcBcc = serialize($ccBccArray);            

            if($draftEmailId != '' && !empty($draftEmailId)){
                $updateRow = "UPDATE email_inbox SET sender_id='$userId', reciever_id='$recieverId', subject='$subject', content='$content', 
                                attachment_file='$attachedFiles', cc_bcc_draft_participants='$serializeCcBcc' WHERE id=$draftEmailId";
                $rowData = self::$dbc->query($updateRow);

                return json_encode(["type" => "drafted_email_updated", "message" => "Email Updated.", "status" => true]);
            }
            
            $insertQuery = "INSERT INTO email_inbox (sender_id, reciever_id, subject, content, attachment_file, cc_bcc_draft_participants, is_draft, created_at)
                            VALUES ('$userId', '$recieverId', '$subject', '$content', '$attachedFiles', '$serializeCcBcc', 1, '$date')";
        
            $result = self::$dbc->query($insertQuery); 
            
            if($result){
                return json_encode(["type" => "email_drafted", "message" => "Email Saved as Draft.", "status" => true]);
            }
            
            return json_encode(["type" => "email_not_drafted", "message" => "Something went wrong to saved email as Draft.", "status" => false]);
        }
            
        if($reciever == '' || empty($reciever)){
            $toError = "Not a registered Mailman Address";
        }

        if(!empty($cc) && $cc != null){
            $ccMailArray = array_map('trim', explode(",", $cc));
            $invalidCc = self::checkCcBccUser($ccMailArray);
            if(count($invalidCc) > 0){
                $ccError = "Invalid or non registered Mailman Addresses - ". join(", ", $invalidCc) . "";
            }
        }

        if(!empty($bcc) && $bcc != null){
            $bccMailArray = array_map('trim', explode(",", $bcc));
            $invalidBcc = self::checkCcBccUser($bccMailArray);
            if(count($invalidBcc) > 0){
                $bccError = "Invalid or non registered Mailman Addresses - ". join(", ", $invalidBcc) . "";
            }
        }

        if($toError != '' || $ccError != '' || $bccError != ''){
            return json_encode(["type" => "mail_reciever_error", "to_error" => $toError, "cc_error" => $ccError, "bcc_error" => $bccError, "status" => false]);
        }
        
        if($reciever != '' && $buttonId == '1'){
            
            $recieverId = $reciever['id'];
            if($currentTab == "draft"){
                $deleteQuery = self::$dbc->query("DELETE FROM email_inbox WHERE id=$draftEmailId");
            }
            $insertQuery = "INSERT INTO email_inbox (sender_id, reciever_id, subject, content, attachment_file, created_at)
                            VALUES ('$userId', '$recieverId', '$subject', '$content', '$attachedFiles', '$date')";
                            
            $result = self::$dbc->query($insertQuery); 

            if($result && (!empty($cc) || !empty($bcc))){
                    $insertCcBccData = self::insertData($cc, $bcc);
                    echo $insertCcBccData; exit;
            }
            if($result){
                return json_encode(["type" => "email_inserted", "message" => "Email has been sent", "status" => true]);
            }
            return json_encode(["type" => "email_not_inserted", "message" => "Email not Sent", "status" => false]);   
        }
        return json_encode(["type" => "email_not_found", "message" => "This Mailman address not found", "status" => false]); 
    }

    /**
     * This function insert the CC and BCC data
     */
    public static function insertData($cc, $bcc)
    {
        $date = date('Y-m-d H:i:s');
        $ccArr = [];
        $bccArr = [];
        if(!empty($cc) || $cc != ''){
            $ccArr = explode(",", $cc);
        }
        if(!empty($bcc) || $bcc != ''){
            $bccArr = explode(",", $bcc);
        }
        if(!empty($ccArr[0]) || !empty($bccArr[0])){
            if(count($ccArr) > count($bccArr)){
                $result = self::insertCcDataFirst($ccArr, $bccArr, $date);
            }
            else{
                $result = self::insertBccDataFirst($ccArr, $bccArr, $date);                
            }
            return $result;
        }
    }

   public static function insertCcDataFirst($ccArr, $bccArr, $date)
   {
        $getLastId = self::$dbc->query("SELECT id from email_inbox Order BY id DESC LIMIT 1"); 
        $email_id = $getLastId->fetch_assoc();
        foreach($ccArr as $email){
            $selectCcUserId = self::$dbc->query("SELECT id from users where LOWER(user_email)=LOWER('" .trim($email). "')"); 
            $ccUserId = $selectCcUserId->fetch_assoc();
            $insertdata = " INSERT INTO cc_bcc (email_id, cc_id, created_at) VALUES (". $email_id['id'] .", ". $ccUserId['id'] .", '$date')";
            $result = self::$dbc->query($insertdata);    
        }
        $getLastInsertedRows = self::$dbc->query("SELECT id from cc_bcc Where email_id=" .$email_id['id']. " Order BY id ASC");
        $lastIdsArray = array_column($getLastInsertedRows->fetch_all(), 0);
        for($i = 0; $i < count($bccArr); $i++){
            if(array_key_exists($i, $bccArr) && !empty($bccArr[$i])){
                $selectBccUserId = self::$dbc->query("SELECT id from users where LOWER(user_email)=LOWER('".$bccArr[$i]."')");
                $bccUserId = $selectBccUserId->fetch_assoc();
                $result = self::$dbc->query("UPDATE cc_bcc SET bcc_id=". $bccUserId['id'] ." WHERE id=" .$lastIdsArray[$i]. "");
            }
        }

        if($result){
            return json_encode(["type" => "cc_inserted_bcc_updated", "message" => "Email has been sent", "status" => true]);
        }
        return json_encode(["type" => "not_cc_inserted_bcc_updated", "message" => "Email not sent", "status" => false]);
   }

    public static function insertBccDataFirst($ccArr, $bccArr, $date)
    {        
        $getLastId = self::$dbc->query("SELECT id from email_inbox Order BY id DESC LIMIT 1"); 
        $email_id = $getLastId->fetch_assoc();
        foreach($bccArr as $email){
            $selectBccUserId = self::$dbc->query("SELECT id from users where LOWER(user_email)=LOWER('" .trim($email). "')"); 
            $bccUserId = $selectBccUserId->fetch_assoc();
            $insertdata = " INSERT INTO cc_bcc (email_id, bcc_id, created_at) VALUES (". $email_id['id'] .", ". $bccUserId['id'] .", '$date')";
            $result = self::$dbc->query($insertdata);   
        }
        
        $getLastInsertedRows = self::$dbc->query("SELECT id from cc_bcc Where email_id=" .$email_id['id']. " Order BY id ASC");
        $lastIdsArray = array_column($getLastInsertedRows->fetch_all(), 0);
        for($i = 0; $i < count($ccArr); $i++){
            if(array_key_exists($i, $ccArr) && !empty($ccArr[$i])){
                $selectCcUserId = self::$dbc->query("SELECT id from users where LOWER(user_email)=LOWER('".trim($ccArr[$i])."')");
                $ccUserId = $selectCcUserId->fetch_assoc();
                $result = self::$dbc->query("UPDATE cc_bcc SET cc_id=". $ccUserId['id'] ." WHERE id=" .$lastIdsArray[$i]. "");
            }
        }

        if($result){
            return json_encode(["type" => "bcc_inserted_cc_updated", "message" => "Email has been sent", "status" => true]);
        }
        return json_encode(["type" => "not_bcc_inserted_cc_updated", "message" => "Email not sent", "status" => false]);
    }

    /**
    * Validate the cc and bcc users.
    */
    public static function checkCcBccUser($mailArray)
    {
        $runQuery = self::$dbc->query("SELECT user_email from users");
        if($runQuery->num_rows > 0){
            $allUserMail = array_column($runQuery->fetch_all(), 0);
            $invalidMails = array_diff(array_map('strtolower', $mailArray), array_map('strtolower', $allUserMail));
            return $invalidMails;
        }
        return [];
    }

    /**
     * This function Validate the direct reciever.
     */
    public static function checkUser($to)
    {
        $runQuery = self::$dbc->query("SELECT id from users WHERE user_email='$to'");
        $reciever = ($runQuery->num_rows > 0) ? $runQuery->fetch_assoc() : "" ;
        return $reciever;
    }

    /**
     * This function return the data for email page reply and reply all button.
     */
    public static function getReplyData($emailId, $btnValue)
    {
        if($btnValue == "reply"){
            $selectQuery = self::$dbc->query(" SELECT email_inbox.id, users.user_email as sender_email, u.user_email as reciever_email, email_inbox.subject 
                                            from email_inbox 
                                            JOIN users ON users.id=email_inbox.sender_id
                                            join users as u ON u.id=email_inbox.reciever_id
                                            WHERE email_inbox.id=$emailId");
            $data = $selectQuery->fetch_assoc();

        }else{
            $selectQuery = "SELECT email_inbox.id as email_id, users.user_email as sender_email, u.user_email as reciever_email, email_inbox.subject , cc_bcc.cc_id, cc_bcc.bcc_id
                            from email_inbox 
                            left join cc_bcc on email_inbox.id=cc_bcc.email_id
                            JOIN users ON users.id=email_inbox.sender_id
                            join users as u ON u.id=email_inbox.reciever_id
                            WHERE email_inbox.id=$emailId or cc_bcc.email_id=$emailId";
            $rowData = self::$dbc->query($selectQuery);
            $data = $rowData->fetch_all(MYSQLI_ASSOC);
        }
        return $data;
    }

}

spl_autoload_register(function ($className) {
    require_once("./" . $className . ".php");
});

$composemodel = new ComposeModel();
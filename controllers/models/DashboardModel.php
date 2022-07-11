<?php

error_reporting( E_ALL );
ini_set( "display_errors", 1 );

/**
 * This class is responsible to fetch the all dashboard data from Database.
 * This class works like as Database Model.
 * Only Database logic, queries included in this class.
 */
class DashboardModel{

    protected static $dbc;

    public function __construct(){
        self::$dbc = DB::getDbConn();
    }

    /**
     * Returns the Inbox Emails to the logged in user.
     */
    public static function getInboxEmails($tableName, $userId, $identity)
    {
        $select = " SELECT ei.id AS email_id, ei.reciever_id, cc_bcc.cc_id, cc_bcc.bcc_id, cc_bcc.id AS ccbcc_id, users.user_email, ei.subject, 
                    cc_bcc.cc_read, cc_bcc.bcc_read, ei.is_read, ei.created_at
                    FROM email_inbox AS ei 
                    JOIN users ON ei.sender_id=users.id 
                    JOIN cc_bcc ON ei.id=cc_bcc.email_id
                    WHERE (
                    (ei.reciever_id=$userId AND ei.delete_by_reciever=0) OR 
                    (cc_bcc.cc_id=$userId AND cc_bcc.delete_by_cc=0) OR
                    (cc_bcc.bcc_id=$userId AND cc_bcc.delete_by_bcc=0)) 
                    ORDER BY ei.id DESC ";
        $inboxEmailData = self::$dbc->query($select);
        if($inboxEmailData){
            $emailArray = $inboxEmailData->fetch_all(MYSQLI_ASSOC);
            return json_encode(["type" => "inbox_data_found", "message" => "Data Found", "data" =>$emailArray,  "status" => true]);
        }
        return json_encode(["type" => "inbox_data_not_found", "message" => "No Data Found", "status" => false]);
    }

    /**
     * This function return the sent emails data that has been sent by currently logged in user.
     */
    public static function getSentEmails($tableName, $userId, $identity)
    {
        $isDraft = ($identity == "draft") ? 1 : 0 ;
        $select = " SELECT ei.id as email_id, users.user_email, ei.subject, ei.created_at
                    FROM email_inbox as ei
                    JOIN users ON ei.reciever_id=users.id
                    WHERE ei.sender_id=$userId AND ei.delete_by_sender=0 AND ei.is_draft=$isDraft
                    ORDER BY ei.id DESC";
        $sendEmailData = self::$dbc->query($select);
        if($sendEmailData){
            $emailArray = $sendEmailData->fetch_all(MYSQLI_ASSOC);
            return json_encode(["type" => "send_data_found", "message" => "Data Found", "data" =>$emailArray,  "status" => true]);
        }
        return json_encode(["type" => "send_data_not_found", "message" => "No Data Found", "status" => false]);
    }

    /**
     * This function return the trashed emails that has been trashed by currently logged in user.
     */
    public static function getTrashEmails($tableName, $userId, $identity)
    {
        $select = " SELECT ei.id as email_id, ei.sender_id as current_id, users.user_email as reciever, u.user_email, ei.subject, ei.deleted_at as created_at
                    FROM email_inbox as ei
                    JOIN users as u ON ei.sender_id=u.id
                    JOIN users ON ei.reciever_id=users.id
                    JOIN cc_bcc as cb ON ei.id=cb.email_id
                    WHERE ((ei.sender_id=$userId AND ei.delete_by_sender=1 AND ei.permanent_deleted_by_sender=0) 
                    OR (ei.reciever_id=$userId AND ei.delete_by_reciever=1 AND ei.permanent_deleted_by_reciever=0)
                    OR (cb.cc_id=$userId AND cb.delete_by_cc=1 AND cb.permanent_del_by_cc=0)
                    OR (cb.bcc_id=$userId AND cb.delete_by_bcc=1 AND cb.permanent_del_by_bcc=0)
                    ) 
                    ORDER BY ei.deleted_at DESC";
        $sendEmailData = self::$dbc->query($select);
        if($sendEmailData){
            $emailArray = $sendEmailData->fetch_all(MYSQLI_ASSOC);
            return json_encode(["type" => "trash_data_found", "message" => "Data Found", "data" =>$emailArray,  "status" => true]);
        }
        return json_encode(["type" => "trash_data_not_found", "message" => "No Data Found", "status" => false]);
    }

    /**
     * This function is responsible to delete the emails and restore the emails.
     */
    public static function deleteEmails($selectedEmail, $tableName, $tab, $userId, $buttonVal)
    {
        $value = ($tab == "trash") ? 0 : 1 ;
        if($tab == "trash" && $buttonVal == "delete"){
            // echo " in delete "; die(" jjjjjj ");
            $deletePermanent = self::deleteEmailPermanently($selectedEmail, $userId, $tab);
            return $deletePermanent;
        }
        foreach($selectedEmail as $emailId){
            $selectReciever = self::$dbc->query(" SELECT id  From email_inbox Where id=$emailId AND sender_id=$userId");
            $senderId = $selectReciever->fetch_assoc();
            if($senderId){
                $updateQuery = "UPDATE email_inbox SET delete_by_sender=$value WHERE id=$emailId AND sender_id=$userId";
                $result = self::$dbc->query($updateQuery);
            }

            $selectReciever = self::$dbc->query(" SELECT id  From email_inbox Where id=$emailId AND reciever_id=$userId");
            $recieverId = $selectReciever->fetch_assoc();
            if($recieverId){
                $updateQuery = "UPDATE email_inbox SET delete_by_reciever=$value WHERE id=$emailId AND reciever_id=$userId";
                $result = self::$dbc->query($updateQuery);
            }

            $selectCcReciever = self::$dbc->query(" SELECT id From cc_bcc Where email_id=$emailId AND cc_id=$userId");
            $ccId = $selectCcReciever->fetch_assoc();
            if($ccId){
                $updateQuery = "UPDATE cc_bcc SET delete_by_cc=$value WHERE id=" .$ccId['id']. "";
                $result = self::$dbc->query($updateQuery);
            }

            $selectBccReciever = self::$dbc->query(" SELECT id From cc_bcc Where email_id=$emailId AND bcc_id=$userId");
            $bccId = $selectBccReciever->fetch_assoc();
            if($bccId){
                $updateQuery = "UPDATE cc_bcc SET delete_by_bcc=$value WHERE id=".$bccId['id']."";
                $result = self::$dbc->query($updateQuery);
            }
        }
        if($result){
            if($tab == "trash"){
                return json_encode(["type" => "email_restored", "message" => "Email Restored Successfully", "tab" => $tab, "status" => true]);
            }
            return json_encode(["type" => "email_deleted", "message" => "Email Deleted Successfully", "tab" => $tab, "status" => true]); 
        }
        if($tab == "trash"){
            return json_encode(["type" => "email_not_restored", "message" => "Email Not Restored for some reasons", "status" => false]); 
        }
        return json_encode(["type" => "email_not_deleted", "message" => "Email not deleted for some reasons", "status" => false]);
    }

    /**
     * Function to delete Emails Permanently.
     */
    public static function deleteEmailPermanently($selectedEmail, $userId, $tab)
    {
        $emailId = $selectedEmail[0];
        if(count($selectedEmail) > 0){
            $senderDel = self::$dbc->query("UPDATE email_inbox SET permanent_deleted_by_sender=1 WHERE id=$emailId AND sender_id=$userId");
            $recieverDel = self::$dbc->query("UPDATE email_inbox SET permanent_deleted_by_reciever=1 WHERE id=$emailId AND reciever_id=$userId");
            $ccDel = self::$dbc->query("UPDATE cc_bcc SET permanent_del_by_cc=1 WHERE email_id=$emailId AND cc_id=$userId");
            $bccDel = self::$dbc->query("UPDATE cc_bcc SET permanent_del_by_bcc=1 WHERE email_id=$emailId AND bcc_id=$userId");
            if($senderDel || $recieverDel || $ccDel || bccDel){
                return json_encode(["type" => "email_permanent_deleted", "message" => "Email Deleted Successfully", "tab" => $tab, "status" => true]);
            }
        }
    }

    /**
     * This function filter the Emails from the logged in user data.
     */
    public static function getSearchEmails($value, $userId)
    {
        $serchQuery = " SELECT ei.id as email_id, ei.sender_id as current_id, ei.reciever_id, users.user_email, u.user_email as reciever, ei.subject, ei.created_at
                        from email_inbox as ei
                        left join cc_bcc on ei.id=cc_bcc.email_id
                        JOIN users ON users.id=ei.sender_id
                        JOIN users as u ON ei.reciever_id=u.id
                        WHERE (ei.sender_id=$userId or ei.reciever_id=$userId or cc_bcc.cc_id=$userId or cc_bcc.bcc_id=$userId)
                        and ei.subject like '%$value%'";
        $searchResult = self::$dbc->query($serchQuery);
        if($searchResult){
            $searchResultRows = $searchResult->fetch_all(MYSQLI_ASSOC);
            // print_r($searchResultRows); die(" pp search ");
            return $searchResultRows;
        }
    } 

    /**
     * This function upadte the read and unread status of emails.
     */
    public static function updateReadUnreadEmails($selectedEmails, $value, $userId)
    {

        foreach($selectedEmails as $emailId){
            $selectReciever = self::$dbc->query(" SELECT id  From email_inbox Where id=$emailId AND reciever_id=$userId");
            $recieverId = $selectReciever->fetch_assoc();
            if($recieverId){
                $updateQuery = "UPDATE email_inbox SET is_read=$value WHERE id=$emailId AND reciever_id=$userId";
                $result = self::$dbc->query($updateQuery);
            }

            $selectCcReciever = self::$dbc->query(" SELECT id From cc_bcc Where email_id=$emailId AND cc_id=$userId");
            $ccId = $selectCcReciever->fetch_assoc();
            if($ccId){
                $updateQuery = "UPDATE cc_bcc SET cc_read=$value WHERE id=" .$ccId['id']. "";
                $result = self::$dbc->query($updateQuery);
            }

            $selectBccReciever = self::$dbc->query(" SELECT id From cc_bcc Where email_id=$emailId AND bcc_id=$userId");
            $bccId = $selectBccReciever->fetch_assoc();
            if($bccId){
                $updateQuery = "UPDATE cc_bcc SET bcc_read=$value WHERE id=".$bccId['id']."";
                $result = self::$dbc->query($updateQuery);
            }
        }

        if($result){
            return json_encode(["type" => "is_read_status_updated","message" => "Status Updated", "status" => true]);
        }
        return json_encode(["type" => "is_read_status_not_updated","message" => "Can't change the status at the moment", "status" => false]);
    }

    /**
     * This function will return the Email page data.
     */
    public static function getEmailPageData($emailId, $userId, $currenntTab)
    {
        $selectQuery = "SELECT ei.id, ei.sender_id, u.user_email as sender_email, ei.reciever_id, users.user_email as reciever_email, ei.subject, ei.content, ei.attachment_file, cb.cc_id, cb.bcc_id, ei.cc_bcc_draft_participants, ei.created_at 
                        from email_inbox as  ei
                        left join cc_bcc cb on ei.id=cb.email_id
                        join users u on ei.sender_id=u.id
                        join users on ei.reciever_id=users.id
                        where ei.id=$emailId or cb.email_id=$emailId";
        $result = self::$dbc->query($selectQuery);
        $searchResultRows = $result->fetch_all(MYSQLI_ASSOC);
        // print_r($searchResultRows); die(" kkkk ");
        return $searchResultRows;
    }

    public static function getCcBccEmails($ids)
    {
        if(count($ids) > 0){
            $idsStr = implode(", ", $ids);
            $selectEmails = self::$dbc->query("SELECT user_email from users where id IN (" .$idsStr. ")");
            $searchResultRows = $selectEmails->fetch_all(MYSQLI_ASSOC);
            return array_column($searchResultRows, "user_email");
        }
    }
}

spl_autoload_register(function ($className) {
    require_once("./" . $className . ".php");
});

$dashboardModel = new DashboardModel();
















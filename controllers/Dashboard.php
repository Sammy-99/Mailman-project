<?php
session_start();

error_reporting( E_ALL );
ini_set( "display_errors", 1 );

/**
 * This class is responsible to render the all dashboard data.
 * This class works like as Controller.
 * Only logical parts included in this class.
 * All database logic written in DashboardModel class to fetch the data for dashboard.
 */
class Dashboard{

    protected $tableName = "email_inbox";

    /**
     * This function will return email data on the basis of provided expression
     */
    public function getEmailData($identity, $pageNo)
    {
        $userId = $_SESSION['id'];

        switch ($identity) {
            case "inbox":
              echo $this->getInboxEmails($this->tableName, $userId, $identity, $pageNo);
              break;
            case "sent":
              echo $this->getSentEmails($this->tableName, $userId, $identity, $pageNo);
              break;
            case "draft":
              echo $this->getSentEmails($this->tableName, $userId, $identity, $pageNo);
              break;
            default:
                echo $this->getTrashEmails($this->tableName, $userId, $identity, $pageNo);
          }
    }

    /**
     * This function will return all the Inbox Emails of the Logged In user.
     */
    public function getInboxEmails($tableName, $userId, $identity, $pageNo)
    {
        $emailsDataJson = DashboardModel::getInboxEmails($tableName, $userId, $identity, $pageNo);
        $emailsData = json_decode($emailsDataJson, true);
        if($emailsData['status'] == true ){
            $emailHtml = $this->getEmailDataInHtml($emailsData['data'], $identity);
            return $emailHtml;
        }
        return $emailsDataJson;
    }

    /**
     * This function returns all sent and draftes respectively emails of logged in user.
     */
    public function getSentEmails($tableName, $userId, $identity, $pageNo)
    {
        $emailsDataJson = DashboardModel::getSentEmails($tableName, $userId, $identity, $pageNo);
        $emailsData = json_decode($emailsDataJson, true);
        if($emailsData['status'] == true ){
            $emailHtml = $this->getEmailDataInHtml($emailsData['data'], $identity);
            return $emailHtml;
        }
        return $emailsDataJson;
    }

    /**
     * This function returns all trashed emails of logged in user.
     */
    public function getTrashEmails($tableName, $userId, $identity, $pageNo)
    {
        $emailsDataJson = DashboardModel::getTrashEmails($tableName, $userId, $identity, $pageNo);
        $emailsData = json_decode($emailsDataJson, true);
        if($emailsData['status'] == true ){
            $emailHtml = $this->getEmailDataInHtml($emailsData['data'], $identity);
            return $emailHtml;
        }
        return $emailsDataJson;
    }

    /**
     * This function return the HTML for all dashboard tab.
     */
    public function getEmailDataInHtml($emailsData, $identity)
    {
        $html = '';
        $userId = $_SESSION['id'];
        $emailIdArr = [];
        if(count($emailsData) > 0){
            $html.= "<table class='table table-sm' id='datatable'>";
            $html.= "<tbody>";
            foreach($emailsData as $key => $email){
                if(!in_array($email['email_id'], $emailIdArr)){
                    array_push($emailIdArr, $email['email_id']);
                    if(array_key_exists("is_read", $email)){
                        if(($email["is_read"] == 0 && $email['reciever_id'] == $userId) || 
                        ($email["cc_read"] == 0 && $email['cc_id'] == $userId) ||
                        ($email["bcc_read"] == 0 && $email['bcc_id'] == $userId))
                        {
                            $html.= "<tr class='table'>";
                            $html.= "<td scope='row'> <input type='checkbox' class='pick-checkbox checkbox' name='checkbox' value = '".$email['email_id']."'> </td>";
                            $html.= "<th>". $email['user_email'] ."</th>";
                            $html.= "<th>". $email['subject'] ."</th>";
                            $html.= "<th>". $email['created_at'] ."</th>";
                            $html.= "</tr>";
                        }else{
                            $html = $this->isReadOrUnread($html, $email);
                        }
                    }else{
                            $html = $this->isReadOrUnread($html, $email);
                    }
                }
            }
            $html.= "</tbody>";
            $html.= "</table>";
            $html = $this->getPaginationHtml($html);
            echo json_encode(["type" => "html_data_found", "html" => $html, "status" => true]); exit;
        }else{
            echo json_encode(["type" => "no_html_data_found", "message" => "No Data Found", "status" => false]); exit;
        }
    }

    /**
     * This function return the html that has been read by the logged in user.
     */
    public function isReadOrUnread($html, $email)
    {                   
        if(array_key_exists("current_id", $email)){
            if($email['current_id'] == $_SESSION['id']){
                $email['user_email'] = $email['reciever'];
            }
        }
        $html.= "<tr class='table'>";
        $html.= "<td scope='row'> <input type='checkbox' class='pick-checkbox checkbox' name='checkbox' value = '".$email['email_id']."'> </td>";
        $html.= "<td>". $email['user_email'] ."</td>";
        $html.= "<td>". $email['subject'] ."</td>";
        $html.= "<td>". $email['created_at'] ."</td>";
        $html.= "</tr>";

        return $html;

    }

    public function getPaginationHtml($html)
    {
        $totalPages = ceil(DashboardModel::$totalRecords/DashboardModel::$per_page_limit);
        $pageNo = DashboardModel::$pageNumber;
        $html.='<div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-10 my-3" id="pagination">
                <ul class="pagination">';
        for($i = 1; $i <= $totalPages; $i++){
            $class = ($i == $pageNo) ? "active" : "" ;
            $html.= '<li class="page-item ' .$class. '"><a class="page-link" href="#" id="'.$i.'"> '.$i.' </a></li>';
        }       
                           
        $html.='</ul>
                </div>
                </div>';
        return $html;
    }

    /**
     * This function will delete the Emails from the current page.
     */
    public function deleteSelectedEmails($selectedEmail, $tab, $buttonVal)
    {
        $tableName = $this->tableName;
        $userId = $_SESSION['id'];
        if(count($selectedEmail) > 0 && !empty($tab)){
            $deleteEmails = DashboardModel::deleteEmails($selectedEmail, $tableName, $tab, $userId, $buttonVal);
            echo $deleteEmails; exit ;
        }
    }

    /**
     * This function will restore the emails from trash.
     */
    public function restoreSelectedEmails($restoreEmails, $tab)
    {
        $buttonVal = '';
        $tableName = $this->tableName;
        $userId = $_SESSION['id'];
        if(count($restoreEmails) > 0){
            $restoreEmails = DashboardModel::deleteEmails($restoreEmails, $tableName, $tab, $userId, $buttonVal);
            echo $restoreEmails; exit ;
        }
        echo json_encode(["type" => "no_data_selected", "message" => "No Data Selected", "status" => false]); exit;
    }

    /**
     * This function is responsible for searching the emails.
     */
    public function getSearchResult($value)
    {
        $userId = $_SESSION['id'];
        if($value != '' && !empty($value)){
            $searchDataRows = DashboardModel::getSearchEmails($value, $userId);
            $searchRowsHtml = $this->getEmailDataInHtml($searchDataRows, "search");
        }
        echo json_encode(["type" => "empty","message" => "empty value", "status" => false]);exit;
    }

    /**
     * This function is responsible to mark as read or unread the emails. 
     */
    public function markAsReadUnreadEmails($selectedEmail, $btnValue)
    {
        $userId = $_SESSION['id'];
        if(count($selectedEmail) > 0 && !empty($selectedEmail)){
            $value = ($btnValue == "read") ? "1" : "0" ;
            $updateReadUnreadEmails = DashboardModel::updateReadUnreadEmails($selectedEmail, $value, $userId);
            echo $updateReadUnreadEmails; exit;
        }
    }

    /**
     * This Function will return the dedicated email page data.
     */
    public function getDedicatedEmailPage($emailId, $currenntTab)
    {
        $userId = $_SESSION['id'];
        $userEmail = $_SESSION['email'];
        if(!empty($emailId)){
            $emailData = DashboardModel::getEmailPageData($emailId, $userId, $currenntTab);
            $email_id = $emailData[0]['id'];
            $sender_email = $emailData[0]['sender_email'];
            $reciever_id = $emailData[0]['reciever_email'];
            $subject = $emailData[0]['subject'];
            $content = $emailData[0]['content'];
            $attachment_file = $emailData[0]['attachment_file'];
            $cc_id = array_filter(array_column($emailData, 'cc_id'));
            $bcc_id = array_filter(array_column($emailData, 'bcc_id'));
            $cc_emailArr = DashboardModel::getCcBccEmails($cc_id);
            $cc_emails = (count($cc_emailArr) > 0) ? implode(", ", $cc_emailArr) : "" ;
            $bcc_emailArr = DashboardModel::getCcBccEmails($bcc_id);
            $bcc_emails = (count($bcc_emailArr) > 0) ? implode(", ", $bcc_emailArr) : "" ;
            $email_date = $emailData[0]['created_at'];
            $attachment_html = $this->getAttachmentFileHtml($attachment_file);

            $draft_participants = '';
            if(!empty($emailData[0]['cc_bcc_draft_participants']) && $emailData[0]['cc_bcc_draft_participants'] != NULL){
                $draft_participants = unserialize($emailData[0]['cc_bcc_draft_participants']);
            }
            echo json_encode([
                "type" => "email_page_data_found", 
                "message" => "Dedicated Email data found", 
                "status" => true,
                "my_email" => $userEmail,
                "email_id" => $email_id,
                "sender_email" => $sender_email,
                "reciever_email" => $reciever_id, 
                "subject" => $subject, 
                "content" => $content,
                "attachment_file" => $attachment_html,
                "cc_emails" => $cc_emails,
                "bcc_emails" => $bcc_emails,
                "draft_participants" => $draft_participants,
                "created_at" => $email_date
            ]); exit;
        }
        echo json_encode(["type" => "email_not found", "status" => false, "message" => "Email Not Found"]);
    }

    public function getAttachmentFileHtml($attachment_file)
    {
        if(!empty($attachment_file)){
            $fileArray = explode(",", $attachment_file);
            $fileHtml = '';
            foreach($fileArray as $file){
                $fileName = explode("-",$file);
                // $fileHtml .= "<a href='/launchpadtwo/attachedfiles/" . trim($file) . "' target='_blank'>" . trim($fileName[1]) . "</a></br>";
                $fileHtml .= "<a href='/Mailman-project/attachedfiles/" . trim($file) . "' target='_blank'>" . trim($fileName[1]) . "</a></br>";
            }
            $fileHtml .= "</br>";
            return $fileHtml;
        }
    }
}

spl_autoload_register(function ($className) {
    require_once("./models/" . $className . ".php");
});

$dashboard = new Dashboard();

// to fetch data  for dashboard
if(isset($_POST['identity']) && !empty($_POST['identity'])){
    $dashboard->getEmailData($_POST['identity'], $_POST['page_no']);
}

//function to delete the mails
if(isset($_POST['selected_mails']) && !empty($_POST['current_tab'])){
    $dashboard->deleteSelectedEmails($_POST['selected_mails'], $_POST['current_tab'], $_POST['button_val']);
}

//function to restore the email
if(isset($_POST['restore_mails'])){
    $dashboard->restoreSelectedEmails($_POST['restore_mails'], $_POST['existing_tab']);
}

// funtion for searching
if(isset($_POST['search_value'])){
    $dashboard->getSearchResult($_POST['search_value']);
}

// function for read and unread functionality
if(!empty($_POST['button_value'])){
    $dashboard->markAsReadUnreadEmails($_POST['selected_mails'], $_POST['button_value']);
}
// print_r($_POST); die(" pppp ");
if(!empty($_POST['email_id'])){
    $dashboard->getDedicatedEmailPage($_POST['email_id'], $_POST['current_tab']);
}





?>
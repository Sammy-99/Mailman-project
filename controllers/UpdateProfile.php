<?php

error_reporting( E_ALL );
ini_set( "display_errors", 1 );

/**
 * This class handle the logic to update the users profile.
 */
class UpdateProfile{

    protected $firstname;
    protected $lastname;
    protected $second_email;
    protected $profile_image;
    protected $userId;

    public function updateUserProfile(){
        $checkImage = $this->checkImageInfo();

        if(!empty($_POST['edit-firstname']) || !empty($_POST['edit-lastname']) || !empty($_POST['edit-second-email']) || !empty($_FILES['update-profile-image']['name'])){
            $this->firstname = trim($_POST['edit-firstname']);
            $this->lastname = trim($_POST['edit-lastname']);
            $this->second_email = trim($_POST['edit-second-email']);
            $this->user_id =  $_POST['user-id'];
            // print_r($_SESSION); die(" lllll ");

            $updateUserDetails = Crud::updateUserData($this->user_id, $this->firstname, $this->lastname, $this->second_email, $this->profile_image);
            echo $updateUserDetails; exit;
        }
    }

    /**
     * This function validate the attached file and move that file to the uploaded path.
     */
    public function checkImageInfo(){
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
                $todir = $_SERVER['HTTP_HOST']."../launchpadtwo/uploadedimage/";
                $uniqueSaveName = time()."-".$_FILES['user-image']['name'] ;
                if ( move_uploaded_file( $_FILES['user-image']['tmp_name'], $todir . $uniqueSaveName)){
                    $this->profile_image = $uniqueSaveName;
                    return true;
                }   
            }
        }   
    }
}

spl_autoload_register(function ($className) {
    require_once("./models/" . $className . ".php");
});
    
$updateProfile = new UpdateProfile();

if(isset($_POST) || isset($_FILES)){
    $updateProfile->updateUserProfile();
}

// print_r($_SESSION);
// print_r($_POST);
// print_r($_FILES); die(" kkk ");
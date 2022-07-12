<?php

error_reporting( E_ALL );
ini_set( "display_errors", 1 );
header('Content-type: application/json');

/**
 * SignUp class handles all server side validation on new users to create thier the account.
 * validate the Files.
 * Validate the users email and username.
 */
class SignUp{

    const BASE_URL = "/tse/Mailman-project/";
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
                $todir = StoreUrl::$baseUrl . "uploadedimage/";
                $uniqueSaveName = time()."-".$_FILES['user-image']['name'] ;
                if ( move_uploaded_file( $_FILES['user-image']['tmp_name'], $todir . $uniqueSaveName)){
                    $this->profile_image = $uniqueSaveName;
                }   
            }
        }

        if(isset($_POST['username']) && isset($_POST['userpassword'])){
            $this->username = trim($_POST['username']);
            $this->firstname = trim($_POST['firstname']);
            $this->lastname = trim($_POST['lastname']);
            $this->email = trim($_POST['useremail'] . "@mailman.com");
            $this->password = password_hash(trim($_POST['userpassword']), PASSWORD_DEFAULT);
            $this->secondary_email = trim($_POST['secondary-email']);
            $checkDuplicateUser = Validate::checkDuplicatekUser($this->username, $this->email);
            $jsonMessage = json_decode($checkDuplicateUser, true);
            if($jsonMessage['type'] == 'user_exist'){
                echo $checkDuplicateUser; exit;
            }
            if($jsonMessage['type'] == 'no_user_found'){
                $createUser = Crud::createUser($this->username, $this->firstname, $this->lastname, $this->email, $this->password, $this->secondary_email, $this->profile_image);
                $createUserJson = json_decode($createUser, true);
                if($createUserJson['type'] == 'inserted'){
                    echo $createUser; exit;
                }else{
                    echo $createUser; exit;
                }
            }
        }

        echo json_encode(["type" => "error", "message" => "Something went wrong", "status" => false]); exit;
    }
}
    
spl_autoload_register(function ($className) {
    require_once("./models/" . $className . ".php");
});
    
$signup = new SignUp();
$signup->getUserData();



?>
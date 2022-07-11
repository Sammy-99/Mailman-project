<?php

error_reporting( E_ALL );
ini_set( "display_errors", 1 );

/**
 * This class validate the new Users.
 * username, email, image etc.
 */
class Validate{

    public const MB = 1048576;
    public static $allowedFileExtension = ["png", "jpg"];
    protected static $dbc;

    public function __construct(){
        self::$dbc = DB::getDbConn();
    }

    /**
     * Check the duplicate username and useremail to create the account.
     */
    public static function checkDuplicatekUser($username, $email)
    {
        try{
            $sql = "Select * from users where status=1 AND (username='".$username."' OR user_email='".$email."')";
            $result = self::$dbc->query($sql);
            $rows = $result->fetch_all();
            if(count($rows) > 0){
                return json_encode([
                    "type" => "user_exist", 
                    "message" => "Username or Email already exist.",
                    "status" => false
                ]);
            }

            return json_encode(["type" => "no_user_found", "message" => "User does not exist.", "status" => true]);
        } catch(Exception $e){
            echo "Error : " . $e->getMessage();
        }
    } 

    /**
     * Check type of the image.
     * png OR jpg.
     */
    public static function checkImageType($file)
    {
        ini_set('upload_max_filesize', 5*self::MB);
        $filename = $file['user-image']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($ext, self::$allowedFileExtension)) {
            return json_encode(["type" => "invalid_filetype", "message" => "Please select only jpg or png file.", "status" => false]);
        }
        if ($file['user-image']['size'] > 0 && $file['user-image']['size'] < 2 * self::MB){      
            return json_encode(["type" => "valid_image", "image_name" => $filename, "status" => true]);
        }
        return json_encode(["type" => "invalid_filesize", "message" => "Please select less than 2 MB file.", "status" => false]);
    } 

    /**
     * This function Authenticate the user for SignIn.
     */
    public static function authenticateUser($username = null, $email = null, $password)
    {
        $selectQuery = "Select * from users where (username='".$username."' OR user_email='".$email."') AND status=1";
        $result = self::$dbc->query($selectQuery);
        $row = $result->fetch_assoc();
        if(empty($row)){
            return json_encode([
                "type" => "no_user_found",
                "message" => "Credentials not matched",
                "status" => false
            ]);
        }else{
            if(password_verify($password, $row['password'])){ 
                return json_encode([
                    "type" => "password_matched",
                    "message" => "Credentials matched",
                    "username" => $row['username'],
                    "email" => $row['user_email'],
                    "userId" => $row['id'],
                    "status" => true
                ]);
            }

            return json_encode([
                "type" => "password_not_matched",
                "message" => "Credentials not matched",
                "status" => false
            ]);
        }
    }

    /**
     * Returns the recovery Email for forgot password.
     */
    public static function getRecoveryEmail($username)
    {
        $recoveryEmail = "SELECT * from users where (username='$username' OR user_email='$username') AND status=1";
        $runQuery = self::$dbc->query($recoveryEmail);
        $row = $runQuery->fetch_assoc();

        if(!empty($row)){
            return json_encode([
                "type" => "username_exist",
                "message" => "Credentials matched for forgot password",
                "recoveryEmail" => $row['secondary_email'],
                "userId" => $row['id'],
                "status" => true
            ]);
        }else{
            return json_encode([
                "type" => "username_not_exist",
                "message" => "Credentials not matches for forgot password",
                "status" => false
            ]);
        }
    }

}

$validate = new Validate();

spl_autoload_register(function ($className) {
    require_once("./" . $className . ".php");
});




?>
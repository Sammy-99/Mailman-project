<?php

error_reporting( E_ALL );
ini_set( "display_errors", 1 );

/**
 * This class is respomsible for some crud operation related to user profile.
 * Insert the user data.
 * Update the user data.
 */
class Crud{

    protected static $dbc;

    public function __construct()
    {
        self::$dbc = DB::getDbConn();
    }

    /**
     * This function create the user account.
     */
    public static function createUser($username, $firstname, $lastname, $email, $password, $secondEmail, $profileImage)
    {
        $insertQuery = "INSERT INTO users (username, firstname, lastname, user_email, password, secondary_email, user_image, status)
                        VALUES ('$username', '$firstname', '$lastname', '$email', '$password', '$secondEmail', '$profileImage', 1)";

        $result = self::$dbc->query($insertQuery); 
        if($result){
            return json_encode(["type" => "inserted", "message" => "data inserted", "status" => true]);
        }

        return json_encode(["type" => "not_inserted", "message" => "data not inserted", "status" => false]);
    }

    public static function getUserData($id)
    {
        $selectQuery = " SELECT * from users where id=$id";
        $result = self::$dbc->query($selectQuery);
        $row = $result->fetch_assoc();
        return $row;

    }

    /**
     * Responsible to update the user password.
     */
    public static function updatePassword($newPassword, $userId)
    {
        $updateQuery = "UPDATE users SET password='".$newPassword."' WHERE id=".$userId."";
        $result = self::$dbc->query($updateQuery); 
        if($result){
            return json_encode(["type" => "password_updated", "message" => "Password Successfully Updated.", "status" => true]);
        }

        return json_encode(["type" => "password_not_updated", "message" => "Something went wrong.", "status" => false]);
    }

    /**
     * this function responsible to update the user data.
     */
    public static function updateUserData($userId, $firstname, $lastname, $second_email, $profile_image = null)
    {
        $selectQuery = " SELECT * from users where id=$userId";
        $result = self::$dbc->query($selectQuery);
        $user = $result->fetch_assoc();
        if(empty($firstname)){
            $firstname = $user['firstname'];
        }
        if(empty($lastname)){
            $lastname = $user['lastname'];
        }
        if(empty($second_email)){
            $second_email = $user['secondary_email'];
        }
        if(empty($profile_image)){
            $profile_image = $user['user_image'];
        }
        if(!empty($userId)){
            $updateQuery = "UPDATE users SET firstname='$firstname', lastname='$lastname', secondary_email='$second_email', user_image='$profile_image' WHERE id=".$userId."";
            $result = self::$dbc->query($updateQuery);
            if($result){
                return json_encode(["type" => "user_details_updated", "message" => "Details Successfully Updated.", "status" => true]);
            }
            return json_encode(["type" => "user_details_not_updated", "message" => "Details not Updated.", "status" => false]);  
        }
    }
}

$crud = new Crud();

spl_autoload_register(function ($className) {
    require_once("./" . $className . ".php");
});

?>
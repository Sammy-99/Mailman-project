<?php

error_reporting( E_ALL );
ini_set( "display_errors", 1 );

/**
 *  Class: DB follow the Singleton pattern.
 *  Some functions and properties to connect with the database.
 */

 class DB 
 {
    /**
     * This property contains the host for database connection.
     * @var string
     */
    private const HOST = "localhost"; 

    /**
     * This property contains the username for database connection.
     * @var string
     */
    // private const USERNAME = "root";
    private const USERNAME = "tse"; 

    /**
     * This property contain the password for database connection.
     * @var string
     */
    // private const PASSWORD = "hestabit"; 
    private const PASSWORD = "bPmtHasjyTJ2SgZJ"; 

    /**
     * This property contain the database name for database connection.
     * @var string
     */
    // private const DB = "hesta_mail";
    private const DB = "samir";

    private static $_instance = null;

    private $_conn;

    private function __construct()  
    {  
        // echo "database connected ";
    } 

    public static function getInstance()
    {
        if(self::$_instance == null){
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    public static function getDbConn(){
        try{
            $db = self::getInstance();
            $db = self::$_instance;
            $db->_conn = new Mysqli(self::HOST, self::USERNAME, self::PASSWORD, self::DB);
            return $db->_conn;
        }catch(Exception $e){
            echo "Error : " . $e->getMessage();
        }
    }
 }

?>
<?php

error_reporting( E_ALL );
ini_set( "display_errors", 1 );

class StoreUrl{

    public static $baseUrl;
    
    public function __construct($hostUrl, $projectUrl)
    {
        Self::$baseUrl = $hostUrl . $projectUrl;
    }
}

$url = new StoreUrl($_SERVER['HTTP_HOST'], "/tse/Mailman-project/");
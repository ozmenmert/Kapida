<?php
class Config
{
    const HOST = "localhost";
    const DB = "mrtcknsi_favim1334";
    const USER = "mrtcknsi_favim1334";
    const PASS = "Q4gYChwCx6sFz4L8fxzF";

    //const USER = "root";
    //const PASS = "";

    protected $baglan;
    protected $array;

    protected $sart;
    protected $alanlar;
    protected $veriler;

    function __construct()
    {
        try{
            $this->baglan = new \PDO("mysql:host=".self::HOST.";dbname=".self::DB.";charset=utf8mb4;",self::USER,self::PASS);
            $this->baglan->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (Exception $e){
            echo "Error: " . $e->getMessage();
        }
    }

    function __destruct()
    {
        $this->baglan = null;
    }
}
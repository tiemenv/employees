<?php
class Config
{
    private static $configInstance = null;

    private $server;
    private $database;
    private $username;
    private $password;

    private function __construct()
    {
        $this->server = "localhost";
        $this->database = "lesdb";
        $this->username = "root";
        $this->password = "";
    }

    public static function getConfigInstance()
    {
        if(is_null(self::$configInstance))
        {
            self::$configInstance = new Config();
        }
        return self::$configInstance;
    }

    public function getServer()
    {
        return $this->server;
    }
    public function getDatabase()
    {
        return $this->database;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getPassword()
    {
        return $this->password;
    }
}

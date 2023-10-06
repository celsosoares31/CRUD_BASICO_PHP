<?php

class DbConnect
{
    private $user = 'root';
    private $password = '';
    private $host = 'localhost';
    private $database;

    public function __construct($db)
    {
        $this->database = $db;
    }

    public function getConnection()
    {
        try {
            $conn = new PDO("mysql:host=$this->host;dbname=$this->database", $this->user, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            $_SESSION["db_err"] = $e->getMessage();
        }

    }
}

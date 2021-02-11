<?php

class Database
{
    private $host = '192.168.0.254';
    private $user = 'root';
    private $pass = '1234';
    private $db = 'bdgim';
    // private $charset;

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        try {
            $this->conexion = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return true;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    //fin conectar

    /* public function conectar()
    {
        try {
            // $connection = 'mysql:host='.$this->host.';dbname='.$this->db.';charset='.$this->charset;
            $connection = 'mysql:host='.$this->host.';dbname='.$this->db;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $pdo = new PDO($connection, $this->user, $this->password, $options);

            return $pdo;
        } catch (PDOException $e) {
            print_r('Error connection: '.$e->getMessage());
        }
    }

    //fin connect */
}

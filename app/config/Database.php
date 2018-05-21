<?php

namespace app\config;

class Database
{
    private $host;
    private $user;
    private $pass;
    private $db;
    private $conn;

    public function __construct() {

        $this->host = 'localhost:3307';
        $this->user = 'root';
        $this->pass = 'root';
        $this->db = 'cadastrocrud';

        try {
            $this->conn = new \PDO("mysql:host=" . $this->host . ";dbname=" . $this->db, $this->user, $this->pass);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function query($sql) {
        return $this->conn->query($sql);
    }

    public function prepare($sql) {
        return $this->conn->prepare($sql);
    }

    public function lastInsertId() {
        return $this->conn->lastInsertId();
    }

}
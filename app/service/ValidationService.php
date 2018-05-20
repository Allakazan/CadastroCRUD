<?php

namespace app\service;

use app\config\Database;

class ValidationService
{
    private static $instance;
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public static function getInstance()
    {
        if ( is_null( self::$instance ) )
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function isNumeric ($value) {
        return filter_var($value, FILTER_VALIDATE_INT);
    }

}
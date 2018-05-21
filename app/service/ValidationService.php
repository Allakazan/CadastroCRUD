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

    public function validateMinMaxChars($value, $min, $max) {
        return ($min <= strlen($value)) && (strlen($value) <= $max);
    }

    public function sanitizeString ($value) {
        return filter_var($value, FILTER_SANITIZE_STRING);
    }

}
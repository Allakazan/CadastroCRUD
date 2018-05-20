<?php

namespace app\service;

use app\config\Database;
use app\service\UserGroup;

class UserService
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

    public function get($user)
    {

        $sql = 'select id, name, last_name from user where id = :id';
        $sth = $this->db->prepare($sql);

        $sth->bindValue(':id', $user->getId(), \PDO::PARAM_INT);
        $sth->execute();

        $userData = $sth->fetch(\PDO::FETCH_ASSOC);
        $userData['groups'] = UserGroup::getInstance()->getByUserId($user);

        $user->setAllParams($userData);

        return $user;
    }

    public function list()
    {
        $sql = 'select id, name, last_name from user';
        $sth = $this->db->query($sql);

        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

}
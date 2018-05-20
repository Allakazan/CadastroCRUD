<?php

namespace app\service;

use app\config\Database;
use app\service\UserGroupService;
use app\model\User;

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

    public function userExists($userId) {
        $sql = 'select 1 as user from user where id = :id';
        $sth = $this->db->prepare($sql);

        $sth->bindValue(':id', $userId, \PDO::PARAM_INT);
        $sth->execute();

        return array_key_exists('user', $sth->fetch(\PDO::FETCH_ASSOC));
    }

    public function get($user)
    {

        $sql = 'select id, name, last_name from user where id = :id';
        $sth = $this->db->prepare($sql);

        $sth->bindValue(':id', $user->getId(), \PDO::PARAM_INT);
        $sth->execute();

        $userData = $sth->fetch(\PDO::FETCH_ASSOC);
        $userData['groups'] = UserGroupService::getInstance()->getByUserId($user);

        $user->setAllParams($userData);

        return $user;
    }

    public function list()
    {
        $sql = 'select id, name, last_name from user';
        $sth = $this->db->query($sql);
        $userArray = [];

        foreach ($sth->fetchAll(\PDO::FETCH_ASSOC) as $userData) {
            $user = new User();
            $user->setAllParams($userData);
            $user->setGroups(UserGroupService::getInstance()->getByUserId($user));

            $userArray[] = $user;
        }

        return $userArray;
    }

}
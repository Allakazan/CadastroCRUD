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

        return $sth->fetch(\PDO::FETCH_ASSOC) ==! false;
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

    public function insert($user)
    {
        try {
            $sql = "
            INSERT INTO user
            (name, last_name)
            VALUES(:name, :lastName);
            ";
            $sth = $this->db->prepare($sql);

            $sth->bindValue(':name', $user->getName(), \PDO::PARAM_STR);
            $sth->bindValue(':lastName', $user->getName(), \PDO::PARAM_STR);

            $sth->execute();
            $id = $this->db->lastInsertId();

            $sqlGroups = "
            INSERT INTO user_has_group
            (user_id, group_id)
            VALUES(:userId, :groupId);
            ";

            foreach ($user->getGroups() as $group) {

                $sthGroups = $this->db->prepare($sqlGroups);

                $sthGroups->bindValue(':userId', $id, \PDO::PARAM_INT);
                $sthGroups->bindValue(':groupId', $group->getId(), \PDO::PARAM_STR);

                $sthGroups->execute();
            }

            return $id;
        }
        catch(\PDOException $e) {
            //var_dump($e->getMessage());
            return false;
        }
    }

    public function update($user)
    {
        try {
            $sql = "
                UPDATE user
                SET name=:name, last_name=:lastName, update_date=now()
                WHERE id=:id;
            ";
            $sth = $this->db->prepare($sql);
            $sth->bindValue(':name', $user->getName(), \PDO::PARAM_INT);
            $sth->bindValue(':lastName', $user->getLastName(), \PDO::PARAM_INT);
            $sth->bindValue(':id', $user->getId(), \PDO::PARAM_INT);

            $sth->execute();

            $sqlGroups = "
            INSERT INTO user_has_group
            (user_id, group_id)
            VALUES(:userId, :groupId);
            ";
            $sqlDelGroup = "
            DELETE FROM user_has_group 
            WHERE user_id = :userId and group_id = :groupId
            ";

            $userGroups = UserGroupService::getInstance()->getByUserId($user);
            $groupIds = [];

            foreach ($user->getGroups() as $group) {
                $groupIds[] = $group->getId();
                if (!UserGroupService::getInstance()->userHasGroup($user->getId(), $group->getId())) {

                    $sthGroups = $this->db->prepare($sqlGroups);

                    $sthGroups->bindValue(':userId', $user->getId(), \PDO::PARAM_INT);
                    $sthGroups->bindValue(':groupId', $group->getId(), \PDO::PARAM_STR);

                    $sthGroups->execute();
                }
            }

            foreach($userGroups as $userGroup) {
                if (!in_array($userGroup->getId(), $groupIds)) {

                    $sthDelGroups = $this->db->prepare($sqlDelGroup);

                    $sthDelGroups->bindValue(':userId', $user->getId(), \PDO::PARAM_INT);
                    $sthDelGroups->bindValue(':groupId', $userGroup->getId(), \PDO::PARAM_STR);

                    $sthDelGroups->execute();
                }
            }

            return $user->getId();
        }
        catch(\PDOException $e) {
            //var_dump($e->getMessage());
            return false;
        }
    }

    public function remove($user) {
        try{
            $userGroups = UserGroupService::getInstance()->getByUserId($user);
            $sqlDelGroup = "
            DELETE FROM user_has_group 
            WHERE user_id = :userId and group_id = :groupId
            ";

            foreach($userGroups as $userGroup) {
                $sthDelGroups = $this->db->prepare($sqlDelGroup);

                $sthDelGroups->bindValue(':userId', $user->getId(), \PDO::PARAM_INT);
                $sthDelGroups->bindValue(':groupId', $userGroup->getId(), \PDO::PARAM_STR);

                $sthDelGroups->execute();
            }

            $sql = 'DELETE FROM user WHERE id = :id';
            $sth = $this->db->prepare($sql);

            $sth->bindValue(':id', $user->getId(), \PDO::PARAM_INT);
            $sth->execute();

            return true;
        }
        catch (\PDOException $e) {
            //var_dump($e->getMessage());
            return false;
        }
    }

}
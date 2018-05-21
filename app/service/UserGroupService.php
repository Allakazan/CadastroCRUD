<?php

namespace app\service;

use app\config\Database;
use app\model\Group;

class UserGroupService
{
    private static $instance;
    private $db;

    public function __construct() {
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

    public function groupExists($groupId) {
        $sql = 'select 1 as user_group from user_group where id = :id';
        $sth = $this->db->prepare($sql);

        $sth->bindValue(':id', $groupId, \PDO::PARAM_INT);
        $sth->execute();

        return $sth->fetch(\PDO::FETCH_ASSOC) ==! false;
    }

    public function userHasGroup($userId, $groupId) {
        $sql = '
            select 1 as user_has_group_exists from user_has_group 
            where user_id = :userId and group_id = :groupId
        ';
        $sth = $this->db->prepare($sql);

        $sth->bindValue(':userId', $userId, \PDO::PARAM_INT);
        $sth->bindValue(':groupId', $groupId, \PDO::PARAM_INT);
        $sth->execute();

        return $sth->fetch(\PDO::FETCH_ASSOC) ==! false;
    }

    public function list() {
        $sql = 'select id, user_group from user_group';

        $sth = $this->db->prepare($sql);
        $sth->execute();

        $groupValues = $sth->fetchAll(\PDO::FETCH_ASSOC);

        return (new Group())->setArrayToAllParams($groupValues);
    }

    public function getByUserId($user) {
        $sql = '
        select
            ug.id,
            ug.user_group
        from
            user_has_group uhg
        join user_group ug on
            ug.id = uhg.group_id
        where
            uhg.user_id = :id
        ';

        $sth = $this->db->prepare($sql);

        $sth->bindValue(':id', $user->getId(), \PDO::PARAM_INT);
        $sth->execute();

        $groupValues = $sth->fetchAll(\PDO::FETCH_ASSOC);

        return (new Group())->setArrayToAllParams($groupValues);
    }

    public function getByIds($ids) {
        $sql = 'select id, user_group from user_group where id in ('.implode(',',$ids).')';

        $sth = $this->db->prepare($sql);
        $sth->execute();

        $groupValues = $sth->fetchAll(\PDO::FETCH_ASSOC);

        return (new Group())->setArrayToAllParams($groupValues);
    }
}
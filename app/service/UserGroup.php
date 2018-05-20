<?php

namespace app\service;

use app\config\Database;
use app\model\Group;

class UserGroup
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
}
<?php

namespace app\model;


class Group
{
    private $id;
    private $userGroup;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserGroup()
    {
        return $this->userGroup;
    }

    /**
     * @param mixed $userGroup
     */
    public function setUserGroup($userGroup)
    {
        $this->userGroup = $userGroup;
    }

    /**
     * @param $groupValues
     */
    public function setArrayToAllParams($groupValues) {
        $groupData = [];

        foreach ($groupValues as $groupValue) {
            $group = new Group();

            $group->setId($groupValue['id']);
            $group->setUserGroup($groupValue['user_group']);
            $groupData[] = $group;
        }

        return $groupData;
    }
}
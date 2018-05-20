<?php

namespace app\model;


class User
{

    private $id;
    private $name;
    private $last_name;
    private $groups;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param mixed $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

    /**
     * @param $userArray
     */
    public function setAllParams($userArray) {
        if (array_key_exists('id', $userArray)) {
            $this->setId($userArray['id']);
        }
        if (array_key_exists('name', $userArray)) {
            $this->setName($userArray['name']);
        }
        if (array_key_exists('last_name', $userArray)) {
            $this->setLastName($userArray['last_name']);
        }
        if (array_key_exists('groups', $userArray)) {
            $this->setGroups($userArray['groups']);
        }
    }

    /**
     * @return mixed
     */
    public function toArray() {
        $groups = [];

        foreach ($this->getGroups() as $group) {
            $groups[$group->getId()] = $group->getUserGroup();
        }

        return [
            'name' => $this->getName(),
            'lastName' => $this->getLastName(),
            'groups' => $groups
        ];
    }
}
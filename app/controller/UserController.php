<?php

namespace app\controller;

use app\model\User;
use app\service\UserService;

class UserController extends Controller
{
    private static $instance;

    public function __construct()
    {

    }

    public static function getInstance()
    {
        if ( is_null( self::$instance ) )
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function get($id)
    {
        $user = new User();
        $user->setId($id);

        $user = UserService::getInstance()->get($user);

        return $user->toArray();
    }

    public function list()
    {
        return UserService::getInstance()->list();
    }

    public function update($id, $fields = array())
    {

    }

    public function delete($id)
    {

    }
}
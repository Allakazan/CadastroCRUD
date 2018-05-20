<?php

namespace app\controller;

use app\model\User;
use app\service\UserService;
use app\service\ValidationService;

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

        if (!ValidationService::getInstance()->isNumeric($id)) {
            return 'invalid';
        }
        if (!UserService::getInstance()->userExists($id)) {
            return 'non exists';
        }

        $user = new User();
        $user->setId($id);

        $user = UserService::getInstance()->get($user);

        return $user->toArray();
    }

    public function list()
    {
        $userData = [];

        foreach(UserService::getInstance()->list() as $user) {
            $userData[] = $user->toArray();
        }

        return $userData;
    }

    public function update($id, $fields = array())
    {

    }

    public function delete($id)
    {

    }
}
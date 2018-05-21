<?php

include 'autoload.php';

use app\controller\UserController;


if (!$_GET) { exit('Precisa de parametros GET'); }

$params = $_GET;
$fields = $_POST;

switch ($params['action']) {
    case 'edit':
        UserController::getInstance()->get($params['id']);
        break;
    case 'new':
        UserController::getInstance()->new();
        break;
    case 'list':
        if (array_key_exists('message', $params)) {
            UserController::getInstance()->list($params['message']);
        } else {
            UserController::getInstance()->list();
        }
        break;
    case 'insert':
        UserController::getInstance()->insert($fields);
        break;
    case 'update':
        UserController::getInstance()->update($fields);
        break;
    case 'remove':
        UserController::getInstance()->delete($params['id']);
        break;
    default:
        echo 'Selecione uma opçao valida';
        break;
}
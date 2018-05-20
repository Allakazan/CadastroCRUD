<?php

include 'autoload.php';

use app\controller\UserController;
echo '<pre>';
print_r(UserController::getInstance()->get(1));
print_r(UserController::getInstance()->list());

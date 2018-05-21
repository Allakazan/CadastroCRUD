<?php

namespace app\controller;

use app\model\User;
use app\service\UserService;
use app\service\UserGroupService;
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

    public function new()
    {
        $allGroupsArray = UserGroupService::getInstance()->list();

        $allGroups = [];

        foreach ($allGroupsArray as $groupArray) {
            $allGroups[$groupArray->getId()] = [
                'checked' => false,
                'label' => $groupArray->getUserGroup()
            ];
        }

        $this->view('UserGet', ['action' => ['new'], 'allGroupsChecked' => $allGroups]);
    }

    public function get($id)
    {

        if (!ValidationService::getInstance()->isNumeric($id)) {
            $this->view('error', ['errors' => ['Id invalido']]);
            return false;
        }
        if (!UserService::getInstance()->userExists($id)) {
            $this->view('error', ['errors' => ['Usuario não existente']]);
            return false;
        }

        $user = new User();
        $user->setId($id);

        $user = UserService::getInstance()->get($user);
        $userDataArray = $user->toArray();

        $allGroupsArray = UserGroupService::getInstance()->list();

        $allGroups = [];

        foreach ($allGroupsArray as $groupArray) {
            $allGroups[$groupArray->getId()] = [
                'checked' => in_array($groupArray->getId(), array_keys($userDataArray['groups'])),
                'label' => $groupArray->getUserGroup()
            ];
        }

        $this->view('UserGet', ['userData' => $userDataArray, 'action' => ['edit'], 'allGroupsChecked' => $allGroups]);
    }

    public function list($messageReq = null)
    {
        $usersDataArray = [];

        foreach(UserService::getInstance()->list() as $user) {
            $usersDataArray[] = $user->toArray();
        }

        if (empty($messageReq)) {
            $viewData = ['users' => $usersDataArray];
        } else {
            $viewData = ['users' => $usersDataArray, 'message' => [$messageReq]];
        }

        $this->view('UserList', $viewData);
    }

    public function insert($fields)
    {

        if (count($fields['groups']) < 2) {
            $this->view('error', ['errors' => ['O usuario precisa estar cadastrado em no minimo 2 grupos']]);
            return false;
        }

        if (!ValidationService::getInstance()->validateMinMaxChars($fields['name'], 3, 50)) {
            $this->view('error', ['errors' => ['Nome deve ter no minimo 3 caracteres, e no maximo 50']]);
            return false;
        }

        if (!ValidationService::getInstance()->validateMinMaxChars($fields['lastName'], 3, 100)) {
            $this->view('error', ['errors' => ['Sobrenome deve ter no minimo 3 caracteres, e no maximo 100']]);
            return false;
        }

        $user = new User();
        $user->setName(ValidationService::getInstance()->sanitizeString($fields['name']));
        $user->setLastName(ValidationService::getInstance()->sanitizeString($fields['lastName']));
        $user->setGroups(UserGroupService::getInstance()->getByIds($fields['groups']));

        if(!UserService::getInstance()->insert($user)) {
            $this->view('error', ['errors' => ['Nao foi possivel inserir usuario']]);
            return false;
        } else {
            header('Location: /?action=list&message='.urlencode('Usuario inserido com sucesso'));
        }

    }

    public function update($fields)
    {

        if (!UserService::getInstance()->userExists($fields['id'])) {
            $this->view('error', ['errors' => ['Usuario não existente']]);
            return false;
        }

        if (count($fields['groups']) < 2) {
            $this->view('error', ['errors' => ['O usuario precisa estar cadastrado em no minimo 2 grupos']]);
            return false;
        }

        if (!ValidationService::getInstance()->validateMinMaxChars($fields['name'], 3, 50)) {
            $this->view('error', ['errors' => ['Nome deve ter no minimo 3 caracteres, e no maximo 50']]);
            return false;
        }

        if (!ValidationService::getInstance()->validateMinMaxChars($fields['lastName'], 3, 100)) {
            $this->view('error', ['errors' => ['Sobrenome deve ter no minimo 3 caracteres, e no maximo 100']]);
            return false;
        }

        $user = new User();
        $user->setId($fields['id']);
        $user->setName(ValidationService::getInstance()->sanitizeString($fields['name']));
        $user->setLastName(ValidationService::getInstance()->sanitizeString($fields['lastName']));
        $user->setGroups(UserGroupService::getInstance()->getByIds($fields['groups']));

        if(!UserService::getInstance()->update($user)) {
            $this->view('error', ['errors' => ['Nao foi possivel atualizar usuario']]);
            return false;
        } else {
            header('Location: /?action=list&message='.urlencode('Usuario atualizado com sucesso'));
        }
    }

    public function delete($id)
    {
        if (!ValidationService::getInstance()->isNumeric($id)) {
            $this->view('error', ['errors' => ['Id invalido']]);
            return false;
        }
        if (!UserService::getInstance()->userExists($id)) {
            $this->view('error', ['errors' => ['Usuario não existente']]);
            return false;
        }

        $user = new User();
        $user->setId($id);

        if(!UserService::getInstance()->remove($user)) {
            $this->view('error', ['errors' => ['Nao foi possivel deletar usuario']]);
            return false;
        } else {
            header('Location: /?action=list&message='.urlencode('Usuario deletado com sucesso'));
        }

    }
}
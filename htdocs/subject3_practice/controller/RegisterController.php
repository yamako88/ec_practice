<?php
require_once('../../include/model/UserModel.php');
require_once('SessionController.php');
require_once('../../include/validation/RegisterValidation.php');

class RegisterController extends SessionController
{

    public function __construct()
    {
        parent::loggedIn();
    }

    public function index()
    {
        $errors    = array();
        $success   = array();

        include_once '../../include/view/ec_view_practice/register.php';
    }

    public function post()
    {
        $errors    = array();
        $success   = array();
        $user_name = '';
        $password  = '';

        parent::sessionStart();

        $user_name = parent::getPostData('user_name');
        $password = parent::getPostData('password');

        $registerValidation = new RegisterValidation;
        $errors = $registerValidation->addValidation($user_name, $password);

        $userModel = new UserModel();

        if ($userModel->checkUnique($user_name) !== TRUE) {
            $errors[] = 'このユーザー名は既に使われています';
        }

        if (count($errors) === 0) {
            if ($userModel->insertUser($user_name, $password) === TRUE) {
                $success[] = '新しくユーザーを登録しました';
            } else {
                $errors[] = 'users_table: insertエラー';
            }
        }

        include_once '../../include/view/ec_view_practice/register.php';
    }
}

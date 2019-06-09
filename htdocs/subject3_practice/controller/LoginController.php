<?php
require_once('../../include/model/UserModel.php');
require_once('SessionController.php');

class LoginController extends SessionController
{

  function __construct()
  {
    parent::loggedIn();
  }

  function index()
  {
    $errors    = array();
    $success   = array();
    $user_name = '';
    $password  = '';

    $login_error = parent::getGetData('errors');

    if ($login_error === 'login') {
        $errors[] = 'ログインに失敗しました。正しい名前とパスワードを入力してください。';
    }

    include_once '../../include/view/ec_view_practice/login.php';
  }

  function login()
  {
    parent::sessionStart();

    // POST値取得
    $user_name = parent::getPostData('user_name');
    $password = parent::getPostData('password');

    parent::setCookieYear('user_name', $user_name);

    $userModel = new UserModel();

    $data = $userModel->getLoginUser($user_name, $password);

    // 登録データを取得できたか確認
    if (isset($data[0]['id'])) {
        // セッション変数にuser_idを保存
        $_SESSION['user_id'] = $data[0]['id'];
        if($data[0]['name'] === 'admin' && $data[0]['password'] === 'admin') {
            $_SESSION['is_admin'] = TRUE;
            header('Location: ./admin_item');
            exit;
        }
        // ログイン済みユーザのホームページへリダイレクト
        header('Location: ./top');
        exit;
      } else {
        // セッション変数にログインのエラーフラグを保存
        $_SESSION['login_err_flag'] = TRUE;
        // ログインページへリダイレクト
        header('Location: ./login.php?errors=login');
        exit;
      }
  }

  public function logout()
  {
      parent::sessionStart();

    // セッション名取得 ※デフォルトはPHPSESSID
    $session_name = session_name();

    // ログアウト処理
    parent::logoutSession($session_name);

    // ログアウトの処理が完了したらログインページへリダイレクト
    header('Location: ./login');
  }
}

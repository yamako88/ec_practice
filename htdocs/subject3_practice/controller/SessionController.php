<?php

class SessionController
{

    public function __construct()
    {

    }

    public function sessionStart()
    {
        // セッション開始
        session_start();
    }

    public function loggedIn()
    {
        // セッション変数からログイン済みか確認
        if (isset($_SESSION['user_id']) === TRUE) {
            // ログイン済みの場合、ホームページへリダイレクト
            header('Location: ./top');
            exit;
        }
    }

    public function checkLogin()
    {
        // セッション変数からuser_id取得
        if (isset($_SESSION['user_id']) === TRUE) {
            return $_SESSION['user_id'];
        } else {
            // 非ログインの場合、ログインページへリダイレクト
            header('Location: ./login');
            exit;
        }
    }

    public function checkUserName($name) {
        // ユーザ名を取得できたか確認
        if (isset($name)) {
            return $name;
        } else {
            // ユーザ名が取得できない場合、ログアウト処理へリダイレクト
            header('Location: ./logout');
            exit;
        }
    }

    public function getPostData($key)
    {
        $str = '';
        if (isset($_POST[$key]) === TRUE) {
            $str = $_POST[$key];
        }
        return $str;
    }

    public function getGetData($key) {
        $str = '';
        if (isset($_GET[$key]) === TRUE) {
            $str = $_GET[$key];
        }
        return $str;
    }

    public function setCookieYear($cookie_name, $value) {
        setcookie($cookie_name, $value, time() + 60 * 60 * 24 * 365);
    }

    public function logoutSession($session_name) {
        // セッション変数を全て削除
        $_SESSION = array();

        // ユーザのCookieに保存されているセッションIDを削除
        if (isset($_COOKIE[$session_name])) {
            // sessionに関連する設定を取得
            $params = session_get_cookie_params();

            // sessionに利用しているクッキーの有効期限を過去に設定することで無効化
            setcookie($session_name, '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // セッションIDを無効化
        session_destroy();
    }

    public function getRequestMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

}

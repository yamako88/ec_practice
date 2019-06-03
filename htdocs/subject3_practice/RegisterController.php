<?php

require_once('../../include/model/UserModel.php');

$errors    = array();
$success   = array();
$user_name = '';
$password  = '';

// （例）DBの接続、デストラクタで切断の処理だけを書く。
// $link = new DatabaseClass();

// セッション開始
session_start();

// セッション変数からログイン済みか確認
if (isset($_SESSION['user_id']) === TRUE) {
   // ログイン済みの場合、ホームページへリダイレクト
   header('Location: http://codecamp26607.lesson7.codecamp.jp//subject3_practice/top.php');
   exit;
}

// リクエストメソッド取得
$request_method = getRequestMethod();

if (isset($_GET['errors']) === TRUE && $_GET['errors'] === 'login') {
    $errors[] = 'すでに登録されているユーザー名です。別のユーザー名を登録してください';
}

if ($request_method === 'POST') {
    $user_name = getPostData('user_name');
    $password = getPostData('password');

    if (checkEmpty($user_name, 'ユーザー名') !== TRUE) :
    elseif (checkHalfwidthAlphanumeric($user_name, 'ユーザー名') !== TRUE) :
    elseif (checkUnique($link, $user_name) !== TRUE) :
    endif;
    if (checkEmpty($password, 'パスワード') !== TRUE) :
    elseif (checkHalfwidthAlphanumeric($password, 'パスワード') !== TRUE) :
    endif;

    if (count($errors) === 0) {
      // 上記のインスタンス化したDB処理をモデルを呼び出す時にだけ使う方法
      // $userModel = new UserModel($link);
      $userModel = new UserModel();
        if ($userModel->insertUser($link, $user_name, $password) === TRUE) {
            $success[] = '新しくユーザーを登録しました';
        } else {
            $errors[] = 'users_table: insertエラー';
        }
    }
}

include_once '../../include/view/ec_view_practice/register.php';

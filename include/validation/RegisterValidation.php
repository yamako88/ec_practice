<?php
require_once('Validation.php');

class RegisterValidation extends Validation
{

  public function __construct()
  {

  }

  public function addValidation($user_name, $password)
  {
    $errors = array();

    $userModel = new UserModel();

    if (parent::checkEmpty($user_name) !== TRUE) :
      $errors[] = 'ユーザー名を入力してください';
    elseif (parent::checkHalfwidthAlphanumeric($user_name) !== TRUE) :
      $errors[] = 'ユーザー名は6文字以上16文字以内で入力してください';
    endif;
    if (parent::checkEmpty($password) !== TRUE) :
      $errors[] = 'パスワードを入力してください';
    elseif (parent::checkHalfwidthAlphanumeric($password) !== TRUE) :
      $errors[] = 'パスワードは6文字以上16文字以内で入力してください';
    endif;

    return $errors;
  }
}

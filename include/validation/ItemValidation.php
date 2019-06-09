<?php
require_once('Validation.php');

class ItemValidation extends Validation
{

    public function __construct()
    {

    }

    public function addValidation($name, $price, $stocks, $status, $category_id)
    {
        $errors = array();

        if (parent::checkEmpty($name) !== TRUE) :
            $errors[] = '名前を入力してください';
        elseif (parent::checkLength($name, 20) !== TRUE) :
            $errors[] = '名前は20文字以内で入力してください';
        elseif (parent::checkSpace($name) !== TRUE) :
            $errors[] = '名前は空白以外で入力してください';
        endif;
        if (parent::checkEmpty($price) !== TRUE) :
            $errors[] = '値段を入力してください';
        elseif (parent::checkNumberIsValid($price, 5) !== TRUE) :
            $errors[] = '値段は半角数字5桁以内で入力してください';
        endif;
        if (parent::checkEmpty($stocks) !== TRUE) :
            $errors[] = '個数を入力してください';
        elseif (parent::checkNumberIsValid($stocks, 3) !== TRUE) :
            $errors[] = '個数は半角数字3桁以内で入力してください';
        endif;
        if (parent::checkEmpty($status) !== TRUE) :
            $errors[] = 'ステータスを入力してください';
        elseif (parent::checkBoolean($status, 'ステータス') !== TRUE) :
            $errors[] = '正しいステータスを選択してください';
        endif;
        if (parent::checkEmpty($category_id) !== TRUE) :
            $errors[] = 'カテゴリーを入力してください';
        endif;

        return $errors;
    }
}

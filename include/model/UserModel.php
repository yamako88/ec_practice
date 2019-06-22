<?php
require_once('Model.php');

class UserModel extends Model
{
    private $link;

    function __construct()
    {
        $this->link = parent::getLink();
    }

    public function insertUser($user_name, $password) {
        $prepare = $this->link->prepare(
            'INSERT INTO EC_users(name, password, create_datetime, update_datetime)
               VALUES (?, ?, now(), now())'
        );
        $prepare->bindValue(1, $user_name, PDO::PARAM_STR);
        // $password = password_hash($password, PASSWORD_DEFAULT);
        $prepare->bindValue(2, $password, PDO::PARAM_STR);

        return parent::insertDB($prepare);
    }

    public function getLoginUserName($user_id) {
        $prepare = $this->link->prepare(
            'SELECT name FROM EC_users WHERE id = ?'
        );
        $prepare->bindValue(1, (int)$user_id, PDO::PARAM_INT);

        return parent::getAsArray($prepare);
    }

    public function checkUnique($user_name) {
        $prepare = $this->link->prepare(
            'select count(name) as "unique" from EC_users where name=?'
        );
        $prepare->bindValue(1, $user_name, PDO::PARAM_STR);

        return parent::uniqueDB($prepare);
    }

    function getLoginUser($user_name, $password) {
        $prepare = $this->link->prepare(
            'SELECT id, name, password
            FROM EC_users
            WHERE name = ?
            AND password = ?'
        );
        $prepare->bindValue(1, $user_name, PDO::PARAM_STR);
        $prepare->bindValue(2, $password, PDO::PARAM_STR);

        return parent::getAsArray($prepare);
    }
}

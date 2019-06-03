<?php
require_once('Model.php');

class UserModel extends Model
{
    private $link;

    // function __construct($link)
    function __construct()
    {
      // $this->link = $link;
        parent::__construct();
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

        return parent::insert($prepare);
    }
}

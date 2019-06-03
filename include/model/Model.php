<?php
// require_once '../conf/ec_conf_practice/const.php';
require_once ('conf/Database.php');
// require_once ('../../conf/Database.php');

class Model
{
    private $link;

    public function __construct()
    {
        try {
            $this->link = new PDO(
              // sprintf('mysql:host=%s;dbname=%s;charset=utf8', DataBase::DB_HOST, DataBase::DB_NAME),
                'mysql:host='.Database::DB_HOST.';dbname='.Database::DB_NAME.';',
                Database::DB_USER,
                Database::DB_PASSWD,
                [
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
            // return $link;
        } catch (PDOException $e) {
            // $errors[] = 'DBの接続ができていません。。';
            exit('データベース接続失敗。残念。。' . $e->getMessage());
        }
    }

    public function getLink()
    {
        return $this->link;
    }

    public function executePrepare($prepare)
    {
        if ($prepare->execute() === TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function insert($prepare)
    {
        // if ($prepare->execute() === TRUE) {
        //     return TRUE;
        // } else {
        //     return FALSE;
        // }
        return $this->executePrepare($prepare);
    }

    public function update($prepare)
    {
        return executePrepare($prepare);
    }

    public function delete($prepare)
    {
        return executePrepare($prepare);
    }

    public function getAsArray($prepare) {
        global $errors;

        if ($prepare->execute() === TRUE) {
            $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $errors[] = '[error] SQL失敗';
        }
        return $result;
    }
}

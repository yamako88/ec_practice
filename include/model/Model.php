<?php
require_once ('conf/Database.php');

class Model
{
    private $link;

    public function __construct()
    {
      
    }

    public function getLink()
    {
      try {
          $this->link = new PDO(
              'mysql:host='.Database::DB_HOST.';dbname='.Database::DB_NAME.';',
              Database::DB_USER,
              Database::DB_PASSWD,
              [
                  PDO::ATTR_EMULATE_PREPARES => false,
              ]
          );
          return $this->link;
      } catch (PDOException $e) {
          exit('データベース接続失敗。' . $e->getMessage());
      }
    }

    public function dbAutocommitOff() {
        $this->link->beginTransaction();
    }

    public function dbCommit() {
        $this->link->commit();
    }

    public function dbRollback() {
        $this->link->rollback();
    }

    public function executePrepare($prepare)
    {
        if ($prepare->execute() === TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function insertDB($prepare)
    {
        if ($prepare->execute() === TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
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

    public function uniqueDB($prepare) {
        if ($prepare->execute() === TRUE) {
            $result = $prepare->fetch(PDO::FETCH_ASSOC);
            $count = $result['unique'];
            if ($count > 0) {
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }

    public function alreadyDB($prepare) {
        if ($prepare->execute() === TRUE) {
            $result = $prepare->fetch(PDO::FETCH_ASSOC);
            $count = $result['unique'];
            if ($count > 0) {
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }

    public function entityAssocArray($assoc_array) {
        foreach ($assoc_array as $key => $value) {
            foreach ($value as $keys => $values) {
                // 特殊文字をHTMLエンティティに変換
                $assoc_array[$key][$keys] = $this->entityStr($values);
            }
        }
        return $assoc_array;
    }

    public function entityStr($str) {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
}

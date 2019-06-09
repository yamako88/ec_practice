<?php
require_once('Model.php');

class ItemModel extends Model
{
    private $link;

    public function __construct()
    {
        $this->link = parent::getLink();
    }

    public function getItemTableListPublic($start) {
        $prepare = $this->link->prepare(
            'SELECT
        EC_items.id,
        EC_items.name,
        EC_items.price,
        EC_items.img,
        EC_items.status,
        EC_item_stocks.stock,
        EC_item_category.category_id,
        EC_categories.name AS category_name
        FROM EC_items
        JOIN EC_item_stocks ON EC_items.id = EC_item_stocks.item_id
        JOIN EC_item_category ON EC_items.id = EC_item_category.item_id
        JOIN EC_categories ON EC_item_category.category_id = EC_categories.id
        WHERE EC_items.status = 1
        ORDER BY id DESC
        LIMIT ?, 3'
        );
        $prepare->bindValue(1, (int)$start, PDO::PARAM_INT);

        return parent::getAsArray($prepare);
    }

    public function getItemTableCountPublic() {
        $prepare = $this->link->prepare(
            'SELECT
            count(id) as total
        FROM EC_items
        WHERE status = 1'
        );

        return parent::getAsArray($prepare);
    }

    public function getItemTableList() {
        $prepare = $this->link->prepare(
            'SELECT
            EC_items.id,
            EC_items.name,
            EC_items.price,
            EC_items.img,
            EC_items.status,
            EC_item_stocks.stock,
            EC_item_category.category_id,
            EC_categories.name AS category_name
        FROM
            EC_items
        JOIN
            EC_item_stocks ON EC_items.id = EC_item_stocks.item_id
        JOIN
            EC_item_category ON EC_items.id = EC_item_category.item_id
        JOIN
            EC_categories ON EC_item_category.category_id = EC_categories.id
        ORDER BY id DESC'
        );
        // クエリ実行
        return parent::getAsArray($prepare);
    }

    public function getCategoryTableList() {
        $prepare = $this->link->prepare(
            'SELECT id, name FROM EC_categories ORDER BY id DESC'
        );
        return parent::getAsArray($prepare);
    }

    public function insertItemTable($name, $price, $new_name, $status) {
        $prepare = $this->link->prepare(
            'INSERT INTO EC_items(name, price, img, status, create_datetime, update_datetime)
            VALUES(?, ?, ?, ?, now(), now())'
        );
        $prepare->bindValue(1, $name, PDO::PARAM_STR);
        $prepare->bindValue(2, (int)$price, PDO::PARAM_INT);
        $prepare->bindValue(3, $new_name, PDO::PARAM_STR);
        $prepare->bindValue(4, (int)$status, PDO::PARAM_INT);

        return parent::insertDB($prepare);
    }

    public function insertID()
    {
        mysqli_insert_id($this->link);
    }

    public function insertItemStockTable($stocks, $insert_id) {
        $prepare = $this->link->prepare(
            'INSERT INTO EC_item_stocks(item_id, stock, create_datetime, update_datetime)
            VALUES (?, ?, now(), now())'
        );
        $prepare->bindValue(1, (int)$insert_id, PDO::PARAM_INT);
        $prepare->bindValue(2, (int)$stocks, PDO::PARAM_INT);

        return parent::insertDB($prepare);
    }

    function insertItemCategory($category_id, $insert_id) {
        $prepare = $this->link->prepare(
            'INSERT INTO EC_item_category(item_id, category_id, create_datetime, update_datetime)
            VALUES (?, ?, now(), now())'
        );
        $prepare->bindValue(1, (int)$insert_id, PDO::PARAM_INT);
        $prepare->bindValue(2, (int)$category_id, PDO::PARAM_INT);

        return parent::insertDB($prepare);
    }

}
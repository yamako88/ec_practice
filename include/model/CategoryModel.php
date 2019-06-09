<?php
class CategoryModel extends Model
{
    private $link;

    public function __construct()
    {
        $this->link = parent::getLink();
    }

    public function checkCategoryID($category_id) {
        $prepare = $this->link->prepare(
            'SELECT count(id) as "unique" FROM EC_categories WHERE id=?'
        );
        $prepare->bindValue(1, (int)$category_id, PDO::PARAM_INT);

        return parent::alreadyDB($prepare);
    }
}
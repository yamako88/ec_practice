<?php
require_once('../../include/model/UserModel.php');
require_once('../../include/model/ItemModel.php');
require_once('../../include/model/CategoryModel.php');
require_once('../../include/model/Model.php');
require_once('../../include/validation/ItemValidation.php');
require_once('../../include/validation/ImageValidation.php');

class AdminItemController extends SessionController
{
    public $user_name;
    public $request_method;

    public function __construct()
    {
        parent::sessionStart();
        $user_id = parent::checkLogin();

        $userModel = new UserModel();
        $data = $userModel->getLoginUserName($user_id);
        // 参照渡し（&を変数の最初に書く）、値渡し
        $this->user_name = parent::checkUserName($data[0]['name']);

        // リクエストメソッド取得
        $this->request_method = parent::getRequestMethod();
    }

    public function index()
    {
        $errors        = array();
        $success       = array();
        $name          = '';
        $price         = '';
        $stocks        = '';
        $status        = '';
        $sql_kind      = '';
        $update_stock  = '';
        $change_status = '';
        $item_id       = '';
        $user_id       = '';
        $category_id   = '';

        $user_name = $this->user_name;

        if (isset($_GET['success']) === TRUE && $_GET['success'] === 'insert') {
            $success[] = '新規商品追加しました';
        }
        if (isset($_GET['success']) === TRUE && $_GET['success'] === 'delete') {
            $success[] = '商品削除に成功しました';
        }

        $itemModel = new ItemModel();

        $item_data = $itemModel->getItemTableList();
        $category_data = $itemModel->getCategoryTableList();

        $model = new Model();

        $item_lists = $model->entityAssocArray($item_data);
        $category_lists = $model->entityAssocArray($category_data);

        include_once '../../include/view/ec_view_practice/admin_item.php';
    }

    public function post()
    {
        $errors        = array();
        $success       = array();
        $name          = '';
        $price         = '';
        $stocks        = '';
        $status        = '';
        $sql_kind      = '';
        $update_stock  = '';
        $change_status = '';
        $item_id       = '';
        $user_id       = '';
        $category_id   = '';

        $name     = parent::getPostData('name');
        $price    = parent::getPostData('price');
        $stocks   = parent::getPostData('stocks');
        $status   = parent::getPostData('status');
        $category_id = parent::getPostData('category');

        // バリデーション
        $itemValidation = new ItemValidation();
        $errors = $itemValidation->addValidation($name, $price, $stocks, $status, $category_id);

        $categoryModel = new CategoryModel();
        if ($categoryModel->checkCategoryID($category_id) === TRUE) {
            $errors[] = '正しくカテゴリーを選択してください';
        }

        if (count($errors) === 0) {
            $imageValidation = new ImageValidation();
            if ($imageValidation->checkImageFile($_FILES, $_FILES['new_img']) !== TRUE) :
                $errors[] = '画像が投稿できません';
            elseif ($imageValidation->checkImageSize($_FILES['new_img']['size']) !== TRUE) :
                $errors[] = '画像サイズを2MB以内にしてください。';
            elseif ($imageValidation->checkImageEmpty($_FILES['new_img']['tmp_name'], $_FILES['new_img']['name']) !== TRUE) :
                $errors[] = '画像を選択してください。';
            else :
                $tmp_name = $_FILES['new_img']['tmp_name'];
                $img_name = $_FILES['new_img']['name'];

                $new_name = $imageValidation->createRandFileName();
                if ($imageValidation->checkImageExt($tmp_name, $new_name) === FALSE) {
                    $errors[] = '正しい拡張子で画像を選んでください';
                } else {
                    $new_name = $imageValidation->checkImageExt($tmp_name, $new_name);
                }
                if (count($errors) === 0) {
                    $imageValidation->uploadImageFile($new_name, $tmp_name);
                }
            endif;
        }

        if (count($errors) === 0) {
            $model = new Model();
            // 更新系の処理を行う前にトランザクション開始(オートコミットをオフ）
            $model->dbAutocommitOff();
            // insertのSQL
            $itemModel = new ItemModel();
            if ($itemModel->insertItemTable($name, $price, $new_name, $status) === TRUE) {
                $insert_id = $itemModel->insertID();
                if ($itemModel->insertItemStockTable($stocks, $insert_id) !== TRUE) {
                    $errors[] = 'item_stock_table: insertエラー';
                }
                if ($itemModel->insertItemCategory($category_id, $insert_id) !== TRUE) {
                    $errors[] = 'item_category_table: insertエラー';
                }
            } else {
                $errors[] = 'item_table: insertエラー';
            }

            if (count($errors) === 0) {
                // 処理確定
                $model->dbCommit();
                header('Location: /admin_item');
                exit();
            } else {
                // 処理取消
                $model->dbRollback();
            }
        }

        include_once '../../include/view/ec_view_practice/admin_item.php';

    }

}

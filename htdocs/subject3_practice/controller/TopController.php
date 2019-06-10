<?php
require_once('../../include/model/UserModel.php');
require_once('../../include/model/ItemModel.php');
require_once('../../include/model/Model.php');
require_once('../../include/validation/RegisterValidation.php');

class TopController extends SessionController
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

  function index()
  {
    $errors    = array();
    $success   = array();
    $user_name = '';
    $password  = '';
    $search_keyword = '';

    $user_name = $this->user_name;

        // GETで現在のページ数を取得する（未入力の場合は1を挿入）
      if (isset($_GET['page'])) {
          $page = (int)$_GET['page'];
      } else {
          $page = 1;
      }
      if ($page > 1) {
          $start = ($page * 3) - 3;
      } else {
          $start = 0;
      }
      $back = $page-1;
      $start = $page+1;

      $itemModel = new ItemModel();
      $item_data = $itemModel->getItemTableListPublic($start);

      $item_count = $itemModel->getItemTableCountPublic();
      $page_back_url = '?page=' . $back;
      $page_forward_url = '?page=' . $start;

      $count = $item_count[0]['total'];
      $pagination = ceil($count / 3);

      $model = new Model();
        // 特殊文字を変換
      $item_lists = $model->entityAssocArray($item_data);

    include_once '../../include/view/ec_view_practice/top.php';
  }

}

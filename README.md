# 研修で制作したECサイトの一部機能のクラス化、routing

## 元となったECサイト
https://github.com/yamako88/ec_training

## 実装した機能
#### 一般ユーザーページ
- ユーザー新規登録機能
- ログイン機能
- 商品一覧表示機能
- ページング機能

#### 管理者ページ
- 商品登録機能
- 登録商品一覧表示機能
```$xslt
管理者アカウント
ユーザー名：admin
パスワード：admin
```


## ディレクトリ構造

- htdocks
  - subject3_practice
    - controller
      - AdminItemController.php  
        管理者用の商品一覧、商品登録ページのコントローラー
      - LoginController.php  
        ログイン処理のコントローラー
      - RegisterController.php  
        ユーザーの新規登録のコントローラー
      - SessionController.php  
        認証確認のコントローラー
      - TopController.php  
        一般ユーザー用の商品一覧のコントローラー
    - css
    - images
    - js
    - route
      - Dispatcher.php  
        index.phpに渡すurlを生成する
    - .htaccess  
      送られるurlをindex.phpに書き換える
    - index.php  
      送られてきたurlを元にコントローラに振り分ける。ルーティング。

- include
  - model
    - conf
      - Database.php  
        DBの接続データ、定数を置いているファイル
    - CategoryModel.php  
      カテゴリーテーブルに関するsql文をまとめているモデル
    - ItemModel.php  
      商品テーブルに関するsql文をまとめているモデル
    - Model.php  
      DBの接続処理、insert、DBからのデータ取得などの処理をまとめているモデル
    - UserModel.php
      ユーザーテーブルに関するsql文をまとめているモデル
  - validation
    - ImageValidation.php  
      insertする画像のバリデーション処理
    - ItemValidation.php  
      商品登録のバリデーション処理
    - RegisterValidation.php  
      ユーザー新規登録のバリデーション処理
    - Validation.php  
      バリデーションの共通処理
  - view
    - ec_view_practice
      - admin_item.php  
        管理者画面ビュー
      - login.php  
        ログイン画面ビュー
      - register.php  
        ユーザー新規登録画面ビュー
      - top.php  
        一般ユーザーのトップ画面ビュー
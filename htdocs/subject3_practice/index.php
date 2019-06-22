<?php
ini_set('display_errors', "On");
require_once('./route/Dispatcher.php');
require_once('./controller/RegisterController.php');
require_once('./controller/LoginController.php');
require_once('./controller/TopController.php');
require_once('./controller/AdminItemController.php');

$request = new Dispatcher();
$url = $request->getPathInfo();

switch ($url) {
    case '/register':
        $registerController = new RegisterController();
        $registerController->index();
        break;
    case '/registerpost':
        $registerController = new RegisterController();
        $registerController->post();
        break;
    case '/login':
        $loginController = new LoginController();
        $loginController->index();
        break;
    case '/logincheck':
        $loginController = new LoginController();
        $loginController->login();
        break;
    case '/top':
        $topController = new TopController();
        $topController->index();
        break;
    case '/logout':
        $loginController = new LoginController();
        $loginController->logout();
        break;
    case '/admin_item':
        $adminItemController = new AdminItemController();
        $adminItemController->index();
        break;
    case '/admin_item_post':
        $adminItemController = new AdminItemController();
        $adminItemController->post();
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        exit;
        break;
}

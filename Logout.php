<?php
session_start();

if (isset($_SESSION['USERID'])) {
    $errorMessage = 'ログアウトしました。';
} else {
    $errorMessage = 'セッションがタイムアウトしました。';
}

$_SESSION = array();

if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
}

@session_destroy();
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>在庫管理システム</title>
    </head>
    <body>
        <div><?php echo $errorMessage; ?></div>
        <ul>
        <li><a href="Login.php">ログイン画面に戻る</a></li>
        </ul>
    </body>
</html>
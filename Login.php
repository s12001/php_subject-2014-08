<?php
require_once 'controller.php';
require_once 'common.php';

connect();

session_start();

$errorMessage = '';
$viewUserId = htmlspecialchars($_POST['userid'], ENT_QUOTES);

if (isset($_POST['login'])) {
    if (checkUser()) {
        session_regenerate_id(TRUE);
        $_SESSION['USERID'] = $_POST['userid'];
        header($main);
        exit ;
    } else {
        $errorMessage = 'ユーザIDまたはパスワードに誤りがあります。';
    }
}

function checkUser() {
    $user_select_sql = "select * from user " . "where name = '{$_POST['userid']}' and password = '{$_POST['password']}';";

    if ($statement = $GLOBALS['mysqli'] -> query($user_select_sql)) {
        if ($statement -> num_rows === 1) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>在庫管理システム</title>
    </head>
    <body>
        <form id="loginForm" name="loginForm" action="" method="POST">
            <fieldset>
                <legend>ログイン</legend>
                <label for="userid">ユーザID:</label><input type="text" id="userid" name="userid" /><br/>
                <label for="password">パスワード:</label><input type="password" id="password" name="password" /><br/>
                <p style="color: red"><?php echo $errorMessage ?></p>
                <input type="submit" id="login" name="login" value="ログイン">
            </fieldset>
        </form>
    </body>
</html>
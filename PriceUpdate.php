<?php
require_once 'controller.php';
require_once 'common.php';

login_check();

$message = 'User : <span style="color: red">' . $_SESSION['USERID'] . '</span> さん';

connect();

if (isset($_POST['button'])) {
    $button = htmlspecialchars($_POST['button'], ENT_QUOTES, 'UTF-8');
    if ($button === '変更') {
        update();
    }
}

function update() {
    $stock_update_sql = "update inventory set price = ?, timestamp = ? where id = ?";
    if (checkPOST()) {
        if ($statement = $GLOBALS['mysqli'] -> prepare($stock_update_sql)) {
            $statement -> bind_param("isi", $_POST['price'], date("Y/m/d H:i:s", time()), $_POST['id']);
            $statement -> execute();
            header("Location: http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}");
        } else {
            error();
        }
    }
}

function checkPOST() {
    if (empty($_POST['id']) || empty($_POST[price])) {
        $GLOBALS['errorMessage'] = '必須項目を入力してください';
        return false;
    }

    if (!is_numeric($_POST['id']) || !is_numeric($_POST['price'])) {
        $GLOBALS['errorMessage'] = 'IDと価格は数値でお願いします';
        return false;
    }

    return true;
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>在庫管理システム</title>
    </head>
    <body>
        <p><?php echo $message ?></p>
        <form method="post" action="">
            <fieldset>
                <legend>価格変更</legend>
                ID:<input type="text" name="id" /><br />
                価格:<input type="text" name="price" /><br />
                <p style="color: red;"><?php echo $errorMessage ?></p>
                <input type="submit" name="button" value="変更" />
                <input type="submit" name="button" value="戻る" />
            </fieldset>
        </form>
        <hr />
        <?php select(); ?>
    </body>
</html>
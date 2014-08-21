<?php
require_once 'controller.php';
require_once 'common.php';

login_check();

$message = 'User : <span style="color: red">' . $_SESSION['USERID'] . '</span> さん';

connect();
if (isset($_POST['button'])) {
    $button = htmlspecialchars($_POST['button'], ENT_QUOTES, 'UTF-8');
    if ($button === '削除') {
        delInventory();
    }
}

function delInventory() {
    $inventory_delete_sql = 'delete from inventory where id = ?';

    if (!empty($_POST['id'])) {
        if ($statement = $GLOBALS['mysqli'] -> prepare($inventory_delete_sql)) {
            $statement -> bind_param("i", $_POST['id']);
            $statement -> execute();
            header("Location: http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}");
        } else {
            error();
        }
    } else {
        $GLOBALS['errorMessage'] = '必須項目を入力してください';
    }
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
                <legend>商品削除</legend>
                ID:<input type="text" name="id" /><br />
                <p style="color: red;"><?php echo $errorMessage ?></p>
                <input type="submit" name="button" value="削除" />
                <input type="submit" name="button" value="戻る" />
            </fieldset>
        </form>
        <hr />
        <?php select(); ?>
    </body>
</html>
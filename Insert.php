<?php
require_once 'controller.php';
require_once 'common.php';

login_check();

$message = 'User : <span style="color: red">' . $_SESSION['USERID'] . '</span> さん';

connect();

if (isset($_POST['button'])) {
    $button = htmlspecialchars($_POST['button'], ENT_QUOTES, 'UTF-8');
    if ($button === '追加') {
        addInventory();
    }
}

function addInventory() {
    $inventory_insert_sql = 'insert into inventory(name, category, price, stock, timestamp) values (?, ?, ?, ?, ?)';

    if (checkPOST()) {
        if (isInventory()) {
            $GLOBALS['errorMessage'] = '既に有ります';
            return;
        }
        if ($statement = $GLOBALS['mysqli'] -> prepare($inventory_insert_sql)) {
            $statement -> bind_param("ssiis", $_POST['name'], $_POST['category'], $_POST['price'], $_POST['stock'], date("Y/m/d H:i:s", time()));
            $statement -> execute();
            header("Location: http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}");
        }
    }
}

function isInventory() {
    $inventory_select_sql = "select * from inventory " . "where name = '{$_POST['name']}' and category = '{$_POST['category']}';";

    if ($statement = $GLOBALS['mysqli'] -> query($inventory_select_sql)) {
        if ($statement -> num_rows >= 1) {
            return true;
        } else {
            return false;
        }
    } else {
        error();
    }
}

function checkPOST() {
    if (empty($_POST['name']) || empty($_POST['category']) || empty($_POST['price']) || empty($_POST['stock'])) {
        $GLOBALS['errorMessage'] = '必須項目を入力してください';
        return false;
    }

    if (!is_numeric($_POST['price']) || !is_numeric($_POST['stock'])) {
        $GLOBALS['errorMessage'] = '価格と在庫は数値でお願いします';
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
	            <legend>商品追加</legend>
    	        商品名:<input type="text" name="name" /><br />
    	        カテゴリ:<input type="text" name="category" /><br />
    	        価格:<input type="text" name="price" /><br />
    	        在庫:<input type="text" name="stock" /><br />
    	        <p style="color: red;"><?php echo $errorMessage ?></p>
    	        <input type="submit" name="button" value="追加" />
    	        <input type="submit" name="button" value="戻る" />
	        </fieldset>
	    </form>
	    <hr />
	    <?php select() ?>
	</body>
</html>
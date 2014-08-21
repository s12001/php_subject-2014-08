<?php
require_once 'controller.php';
require_once 'common.php';

login_check();

$message = 'ようこそ <span style="color: red">' . $_SESSION['USERID'] . '</span> さん';

connect();

if (isset($_POST['button'])) {
    $button = htmlspecialchars($_POST['button'], ENT_QUOTES, "UTF-8");
    switch ($button) {
        case '商品追加' :
            header($insert);
            break;
        case '商品削除' :
            header($delete);
            break;
        case '価格変更' :
            header($price_update);
            break;
        case '在庫変更' :
            header($stock_update);
            break;
        case 'ログアウト' :
            close();
            header($logout);
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>在庫管理システム</title>
	</head>
	<body>
	    <p><?php echo $message ?></p>
		<form method="post" action="">
		    <fieldset>
		        <legend>メニュー</legend>
    			<input type="submit" name="button" value="商品追加" />
    			<input type="submit" name="button" value="商品削除" />
    			<input type="submit" name="button" value="価格変更" />
    			<input type="submit" name="button" value="在庫変更" />
    			<input type="submit" name="button" value="ログアウト" />
			</fieldset>
		</form>
		<hr/>
		<?php select(); ?>
	</body>
</html>
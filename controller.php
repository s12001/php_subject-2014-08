<?php
$insert = 'Location:Insert.php';
$delete = 'Location:Delete.php';
$price_update = 'Location:PriceUpdate.php';
$stock_update = 'Location:StockUpdate.php';
$logout = 'Location:Logout.php';
$main = 'Location:Main.php';

if (isset($_POST['button'])) {
    $button = htmlspecialchars($_POST['button'], ENT_QUOTES, "UTF-8");
    switch ($button) {
        case '戻る' :
            header($main);
            break;
    }
}
?>
<?php
require_once 'controller.php';

function login_check() {
    session_start();

    if (!isset($_SESSION['USERID'])) {
        header($GLOBALS['logout']);
        exit ;
    }
}

function connect() {
    $host = 'localhost';
    $user = 'php';
    $password = 'php';
    $database = 'php';

    $GLOBALS['mysqli'] = new mysqli($host, $user, $password, $database);
    if (!$GLOBALS['mysqli'] -> connect_error) {
        $GLOBALS['mysqli'] -> set_charset("utf8");
    } else {
        die('Error : (' . $GLOBALS['mysqli'] -> connect_errno . ')' . $GLOBALS['mysqli'] -> connect_error);
    }
}

function select() {
    $sql = 'select * from inventory order by id';

    if ($statement = $GLOBALS['mysqli'] -> query($sql)) {
        print '<table border=1 width=500><tbody>';
        print '<tr><th>ID</th><th>商品名</th><th>カテゴリ</th><th>価格</th><th>在庫</th><th>更新日時</th></tr>';
        while ($row = $statement -> fetch_assoc()) {
            print '<tr align=right>';
            print '<td>' . $row['id'] . '</td>';
            print '<td>' . $row['name'] . '</td>';
            print '<td>' . $row['category'] . '</td>';
            print '<td>' . $row['price'] . '</td>';
            print '<td>' . $row['stock'] . '</td>';
            print '<td>' . $row['timestamp'] . '</td>';
            print '</tr>';
        }
        print '</tbody></table>';
    } else {
        die('Error : (' . $GLOBALS['mysqli'] -> errno . ')' . $GLOBALS['mysqli'] -> error);
    }
}

function error() {
    die('<p style="color: red">Error : ' . $GLOBALS['mysqli'] -> error . '</p>');
}

function close() {
    $GLOBALS['mysqli'] -> close();
}
?>
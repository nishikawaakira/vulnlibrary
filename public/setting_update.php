<?php
session_start();

require_once('../config/app.php');

if (empty($_SESSION['user']) && empty($_POST)) {
    header('Location: /');
    exit;
}

if (mb_strlen($_POST['login_id']) < 4 || !ctype_alnum($_POST['login_id'])
    || $_POST['passwd'] !== $_POST['cfm_passwd']) {

    $_SESSION['post'] = $_POST;
    header('Location: /setting.php');
    exit;
}

$link = mysqli_connect(DB_ADDR, DB_USER, DB_PASS, DB_NAME);
if (!$link) {
    die('接続失敗です。'.mysqli_error($link));
}

$db_selected = mysqli_select_db($link, DB_NAME);
if (!$db_selected){
    die('データベース選択失敗です。'.mysqli_error($link));
}
mysqli_set_charset($link, 'utf8');

$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='".DB_NAME."' AND TABLE_NAME='users'";
$result = mysqli_query($link, $sql);
if (!$result) {
    die('クエリーが失敗しました。'.mysqli_error($error));
}

$columns = [];
while ($tmp = mysqli_fetch_assoc($result)) {
    if (!empty($tmp['COLUMN_NAME'])) {
        $columns[] = $tmp['COLUMN_NAME'];
    }
}

$targets = '';
foreach ($_POST as $key => $param) {
    if (in_array($key,$columns)) {
        $targets .= $key . "='{$param}' ,";
    }
}
$targets = trim($targets, ',');

$sql =  "UPDATE users SET {$targets} WHERE id=".$_SESSION['user']['id'];
$result = mysqli_query($link, $sql);
if (!$result) {
    die('クエリーが失敗しました。'.mysqli_error($link));
}

mysqli_close($link);

header('Location: setting.php?status=success');
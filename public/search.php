<?php
session_start();

require_once('../config/app.php');

$isLogged = false;
if (!empty($_SESSION['user'])) {
    $isLogged = true;
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

$selectWord = '';
$word = '';
if (!empty($_GET['word'])) {
    $word = $_GET['word'];
    $selectWord = "AND name LIKE '%{$word}%'";
}

$sql = "SELECT * FROM books WHERE del_flg IS NULL {$selectWord} ORDER BY id DESC";
$result = mysqli_query($link, $sql);
if (!$result) {
    die('クエリーが失敗しました。'.mysqli_error($link));
}

$datas = [];
while ($tmp = mysqli_fetch_assoc($result)) {
    if (!empty($tmp['name'])) {
        $datas[] = $tmp;
    }
}
mysqli_close($link);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>借りられる本一覧 - 脆弱図書館</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Static navbar -->
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">脆弱図書館</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/">トップ</a></li>
                    <li class="active"><a href="search.php">検索</a></li>
                    <?php if ($isLogged):?>
                    <li><a href="rent.php?user_id=<?php echo $_SESSION['user']['id'];?>">借りた本一覧</a></li>
                    <?php endif;?>
                    <li><a href="contact.php">お問い合わせ</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if ($isLogged):?>
                        <li><?php if ($_SESSION['user']['is_admin']==1) echo '<a href="#">【管理者です】</a>'; ?></li>
                        <li><a href="setting.php">アカウント更新</a></li>
                        <?php if ($_SESSION['user']['is_admin']==1):?><li><a href="contact_admin.php">お問い合わせ一覧</a></li><?php endif;?>
                        <li class="active"><a href="logout.php">ログアウト <span class="sr-only">(current)</span></a></li>
                        <?php else:?>
                        <li><a href="login.php">ログイン</a></li>
                    <?php endif;?>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container">

        <div class="row">
            <form name="searchForm" id="searchFrom" method="get" action="?" class="form-inner">
                <?php // ここでwordのサニタイズ（無害化）を行わないとXSS（クロスサイトスクリプティング）につながる ?>
                <input type="text" name="word" value="<?php echo $word;?>" class="" />
                <input type="submit" value="検索" class="btn btn-primary" />
            </form>
        </div>

        <table class="table table-striped table-bordered">
            <tr>
                <th>タイトル</th>
                <th>著者名</th>
                <th>出版社</th>
                <th>出版年</th>
            </tr>
            <?php foreach ($datas as $data) :?>
            <tr>
                <th><?php echo $data['name'];?></th>
                <th><?php echo $data['author'];?></th>
                <th><?php echo $data['publisher'];?></th>
                <th><?php echo $data['published'];?></th>
            </tr>
            <?php endforeach;?>
        </table>

    </div> <!-- /container -->

</body>
</html>

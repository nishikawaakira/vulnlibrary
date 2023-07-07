<?php
session_start();

require_once('../config/app.php');

if (!empty($_SESSION['user'])) {
    // ログイン済みの場合はログイン画面を表示させない
    header('location: /');
    exit;
}

$error = false;

// ログイン処理
if (!empty($_POST['user'])) {

    $link = mysqli_connect(DB_ADDR, DB_USER, DB_PASS, DB_NAME);
    if (!$link) {
        die('接続失敗です。'.mysqli_error($link));
    }

    $db_selected = mysqli_select_db($link, DB_NAME);
    if (!$db_selected){
        die('データベース選択失敗です。'.mysqli_error($link));
    }
    mysqli_set_charset($link, 'utf8');

    $loginId = $_POST['user']['login_id'];
    $passwd = $_POST['user']['passwd'];

    $sql = "SELECT * FROM users WHERE login_id='{$loginId}' AND passwd='{$passwd}'";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        die('クエリーが失敗しました。'.mysqli_error($link));
    }

    $row = mysqli_fetch_assoc($result);
    if ($row) {
        // ログインに成功
        $_SESSION['user'] = $row;
        header('location: /');
    }
    else {
        // ログインに失敗
        $error = true;
    }
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ログイン - 脆弱図書館</title>
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
                    <li><a href="search.php">検索</a></li>
                    <li><a href="contact.php">お問い合わせ</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="login.php">ログイン</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>


    <div class="container">

        <div class="jumbotron">
            <h1>ログイン</h1>
            <form name="login-form" id="login-form" action="" method="post">

                <?php if ($error):?>
                    <div class="alert alert-danger">
                        <?php // このようにログインIDが間違っているのかパスワードが間違っているのかわからないようにしましょう ?>
                        ログインIDかパスワードが間違っています。
                    </div>
                <?php endif;?>

                <table class="table table-striped table-bordered">
                    <tr>
                        <th>ログインID</th>
                        <td>
                            <input type="text" name="user[login_id]" value="" class="form-control" />
                        </td>
                    </tr>
                    <tr>
                        <th>パスワード</th>
                        <td>
                            <input type="password" name="user[passwd]" value="" class="form-control" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">
                            <input type="submit" value="ログイン" class="btn btn-primary" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div> <!-- /container -->

</body>
</html>
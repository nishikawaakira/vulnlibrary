<?php
session_start();

require_once('../config/app.php');

if (empty($_SESSION['user'])) {
    header('Location:/');
    exit;
}

$isLogged = true;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>アカウント更新 - 脆弱図書館</title>
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
                    <?php if ($isLogged):?>
                    <li><a href="rent.php?user_id=<?php echo $_SESSION['user']['id'];?>">借りた本一覧</a></li>
                    <?php endif;?>
                    <li><a href="contact.php">お問い合わせ</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if ($isLogged):?>
                        <li><?php if ($_SESSION['user']['is_admin']==1) echo '<a href="#">【管理者です】</a>'; ?></li>
                        <li class="active"><a href="setting.php">アカウント更新</a></li>
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

        <h1>アカウント更新</h1>

        <?php if (!empty($_GET['status']) && $_GET['status'] === 'success'):?>
        <div class="alert alert-success">
            更新しました
        </div>
        <?php endif?>


        <form method="post" action="setting_update.php">
        <table class="table table-striped table-bordered">
            <tr>
                <th>ログインID</th>
                <td>
                    <input type="text" name="login_id" value="<?php echo (empty($_SESSION['post']) ? htmlspecialchars($_SESSION['user']['login_id'], ENT_QUOTES) : $_SESSION['post']['login_id']);?>" class="form-control">
                </td>
            </tr>
            <tr>
                <th>パスワード</th>
                <th>
                    <input type="password" name="passwd" value="" class="form-control">
                </th>
            </tr>
            <tr>
                <th>パスワード（確認用）</th>
                <th>
                    <input type="password" name="cfm_passwd" value="" class="form-control">
                </th>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    <input type="submit" value="更新" class="btn btn-primary">
                </td>
            </tr>
        </table>

    </div> <!-- /container -->

</body>
</html>

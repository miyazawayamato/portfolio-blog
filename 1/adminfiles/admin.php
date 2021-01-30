<?php
session_start();


//ログイン判定
// if (empty($_SESSION['member'])) {
//     header('Location:./admin_login.php');
// }

require_once 'connect.php';
require_once 'functions.php';


$dbh = connect();
$sql = "SELECT * FROM posts";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll();


//変更機能

?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/admin/admin.css">
    <title>管理ページ</title>
</head>
<body>

<div class="admin">
    <?php if (($_GET['action'] === 'success')): ?>
        <p class="message">投稿に成功ました</p>
    <?php endif; ?>
    <header>
        <h2>管理ページ</h2>
        <nav>
            <ul class="navi">
                <li><a href="./post.php">投稿ページ</a></li>
                <li><a href="./logout.php">ログアウト</a></li>
                <li><a href="../user/top.php">トップ画面</a></li>
            </ul>
        </nav>
    </header>

    <div class="main">
        <div class="list">
        <?php foreach ($posts as $post): ?>
            <div class="box">
                <h3><?php echo h($post['title']); ?></h3>
                <div class="box-menu">
                    <span><?php echo h(date('Y年m月d日G時i分s秒',strtotime($post['time']))); ?></span>
                    
                    <span class="delete-btn">記事削除</span>
                    <a href="delete.php?post_id=<?php echo h($post['id']); ?>" style="display: none;" class="delete-exe">削除</a>
                    
                    <a href="edit.php?post_id=<?php echo h($post['id']); ?>">編集</a>
                    <a href="coments.php?post_id=<?php echo h($post['id']); ?>">コメント</a>
                </div>
                <div class="box-main">
                    <?php if (!is_null($post['filepass'])): ?>
                    <img src="<?php echo '../file/'.h($post['filepass']); ?>" class="image">
                    <?php else: ?>
                    <p class="image no-image">NoImage</p>
                    <?php endif; ?>
                    <p class="text"><?php echo h($post['body']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
</div>

<script src="../javascript/admin.js"></script>
</body>
</html>
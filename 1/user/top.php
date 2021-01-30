<?php

session_start();

$_SESSION['errors'] = array();

require_once '../adminfiles/connect.php';
require_once '../adminfiles/functions.php';


$dbh = connect();
$sql = "SELECT * FROM posts";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll();

//ログインのチェック

//タグ
//削除、変更機能
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/top/top.css">
    <title>サンプルブログ</title>
</head>
<body>
<header>
    <h1 class="main-title"><a href="top.php" class="title-font">サンプルブログ</a></h1>
    <p class="sub-title">ポートフォリオ用に制作したものです</p>
</header>
    <div class="main">
    <?php foreach ($posts as $post): ?>
    <div class="list-main">
        <div class="list-info">
            <a href="article.php?post_id=<?php echo h($post['id']); ?>"><h3 class="list-title"><?php echo h($post['title']); ?></h3></a>
            <span><?php echo h(date('Y年m月d日',strtotime($post['time']))); ?></span>
        </div>
        <div class="list-img">
            <?php if (!is_null($post['filepass'])): ?>
            <img src="<?php echo '../file/'.h($post['filepass']); ?>" class="image">
            <?php else: ?>
            <p class="image no-image">NoImage</p>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
    </div>
</body>
</html>
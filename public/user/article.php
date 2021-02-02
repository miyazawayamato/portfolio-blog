<?php

session_start();

require_once '../adminfiles/connect.php';
require_once '../adminfiles/functions.php';

$dbh = connect();

$post_id = $_GET['post_id'];

$sql = "SELECT * FROM posts WHERE id = ?";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(1,$post_id,PDO::PARAM_STR);
$stmt->execute();
$post = $stmt->fetchAll();

$sql = "SELECT * FROM coments  WHERE posts_id = ?";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(1,$post_id,PDO::PARAM_STR);
$stmt->execute();
$coments = $stmt->fetchAll();


$errors = $_SESSION['errors'];
$counter = 0;

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/common.css">
    <link rel="stylesheet" href="../assets/css/article/article.css">
    <title>Document</title>
</head>
<body>
<header>
    <h1 class="main-title"><a href="top.php" class="title-font">サンプルブログ</a></h1>
    <p class="sub-title">ポートフォリオ用に制作したものです</p>
</header>
<div class="main">

    <h2 class="title"><?php echo h($post[0]['title']); ?></h2>
    <p><?php echo h(date('Y年m月d日',strtotime($post[0]['time']))); ?></p>
    
    <?php if (!is_null($post[0]['filepass'])): ?>
    <img src="<?php echo '../assets/file/'.h($post[0]['filepass']); ?>" class="image">
    <?php else: ?>
    <p class="image no-image">NoImage</p>
    <?php endif; ?>
    
    <p class="text" ><?php echo h($post[0]['body']); ?></p>
    
    <div class="coment">
        <div class="coment-list">
            <h4 class="coment-title">コメント一覧</h4>
            <?php foreach($coments as $coment): ?>
            <div class="com-box">
            <p class="com-name"><?php echo h($coment['name']);?></p>
            <p class="com-body"><?php echo h($coment['coment']);?></p>
            </div>
            <?php $counter++; ?>
            <?php endforeach; ?>
            <span>コメント数:<?php echo $counter;?>件</span>
        </div>
    
        <div class="coment-form">
            <div class="error">
                <?php if ($errors): ?>
                <p class="announce">記入要件を満たしていないものがあります</p>
                <?php foreach ($errors as $error): ?>
                <p class="message"><?php echo $error; ?></p>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        
            <h4 class="coment-title">コメント投稿</h4>
            <form action="coment.php" method="post">
                <input type="hidden" value="<?php echo $post_id; ?>" name="post_id" >
                <p>投稿ネーム</p>
                <input type="text" name="name" class="block ">
                <p>本文</p>
                <textarea name="coment" class="block "></textarea>
                <button name="send">送信</button>
            </form>
        </div>
    </div>
    <a href="top.php">一覧へ</a>
</div>
</body>
</html>
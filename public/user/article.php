<?php

session_start();

require_once '../functions/connect.php';
require_once '../functions/escape.php';
require_once '../functions/fetch.php';

$post_id = $_GET['post_id'];
$post = oneFetch($post_id);
$comments = commentsFetch($post_id);


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
    </header>
    
    <div class="main">
        <h2 class="title"><?php echo h($post['title']); ?></h2>
        <p><?php echo h(date('Y年m月d日', strtotime($post['time']))); ?></p>

        <?php if (!is_null($post['filepass'])) : ?>
            <img src="<?php echo '../assets/file/' . h($post['filepass']); ?>" class="image">
        <?php else : ?>
            <p class="image no-image">NoImage</p>
        <?php endif; ?>

        <p class="text"><?php echo h($post['body']); ?></p>

        <div class="comment">
            <div class="comment-list">
                <h4 class="comment-title">コメント一覧</h4>
                <?php foreach ($comments as $comment) : ?>
                    <div class="com-box">
                        <p class="com-name"><?php echo h($comment['name']); ?></p>
                        <p class="com-body"><?php echo h($comment['comment']); ?></p>
                    </div>
                    <?php $counter++; ?>
                <?php endforeach; ?>
                <span>コメント数:<?php echo $counter; ?>件</span>
            </div>

            <div class="comment-form">
                <div class="error">
                    <?php if ($errors) : ?>
                        <p class="announce">記入要件を満たしていないものがあります</p>
                        <?php foreach ($errors as $error) : ?>
                            <p class="message"><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <h4 class="comment-title">コメント投稿</h4>
                <form action="../functions/comment.php" method="post">
                    <input type="hidden" value="<?php echo $post_id; ?>" name="post_id">
                    <p>投稿ネーム</p>
                    <input type="text" name="name" class="block ">
                    <p>本文</p>
                    <textarea name="comment" class="block"></textarea>
                    <button name="send">送信</button>
                </form>
            </div>
        </div>
        <a href="top.php">一覧へ</a>
    </div>
    <footer >
        <span class="copy">©2021/yamato-miyazawa</span>
    </footer>
</body>

</html>
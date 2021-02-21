<?php
session_start();

require_once '../functions/escape.php';
require_once '../functions/fetch.php';

$post_id = $_GET['post_id'];

$comments = commentsFetch($post_id);

$counter = 0;


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/comments/comments.css">
    <title>コメント削除</title>
</head>

<body>
    <header>
        <h2>コメント</h2>
    </header>
    <div class="main">
        <p>コメント削除</p>
        <?php foreach ($comments as $comment) : ?>
            <div class="com-box">
                <p class="com-name"><?php echo h($comment['name']); ?></p>
                <p class="com-body"><?php echo h($comment['comment']); ?></p>
                <span class="delete-btn" style="cursor: pointer;">削除</span>
                <a href="delete.php?com_id=<?php echo h($comment['id']); ?>" style="display: none;" class="delete-exe">削除する</a>
            </div>
            <?php $counter++; ?>
        <?php endforeach; ?>
        <span>コメント数</span>
        <span><?php echo $counter; ?></span>
        <a href="./admin.php">戻る</a>

    </div>
    <script src="../javascript/admin.js"></script>
</body>

</html>
<?php
session_start();

require_once '../functions/escape.php';
require_once '../functions/fetch.php';

$post_id = $_GET['post_id'];

$comments = commentsFetch($post_id);
$com_num = count($comments);


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/admin/common.css">
    <link rel="stylesheet" href="../assets/css/comments/comments.css">
    <title>コメント削除</title>
</head>

<body>
    <header>
        <h2>コメント</h2>
    </header>
    <div class="main">
        <span class="com_num">コメント数:<?php echo $com_num; ?></span>
        <?php foreach ($comments as $comment) : ?>
            <div class="com-box">
                <p class="com-name"><?php echo h($comment['name']); ?></p>
                <p class="com-body"><?php echo h($comment['comment']); ?></p>
                <span class="delete-btn" style="cursor: pointer;">削除</span>
                <a href="../functions/delete.php?com_id=<?php echo h($comment['id']); ?>" style="display: none;" class="delete-exe">削除する</a>
            </div>
        <?php endforeach; ?>
        <a href="./admin.php">戻る</a>

    </div>
    <script src="../functions/javascript/admin.js"></script>
</body>

</html>
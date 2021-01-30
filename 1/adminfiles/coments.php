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

$counter = 0;

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/coments/coments.css">
    <title>コメント削除</title>
</head>
<body>
<header>
    <h2>コメント</h2>
</header>
<div class="main">
    <p>コメント削除</p>
    <?php foreach($coments as $coment): ?>
        <div class="com-box">
        <p class="com-name"><?php echo h($coment['name']);?></p>
        <p class="com-body"><?php echo h($coment['coment']);?></p>
        <span class="delete-btn" style="cursor: pointer;">削除</span>
        <a href="delete.php?com_id=<?php echo h($coment['id']); ?>" style="display: none;" class="delete-exe" >削除する</a>
        </div>
    <?php $counter++; ?>
    <?php endforeach; ?>
    <span>コメント数</span>
    <span><?php echo $counter;?></span>
    <a href="./admin.php">戻る</a>

</div>
<script src="../javascript/admin.js"></script>
</body>
</html>
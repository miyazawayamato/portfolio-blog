<?php

session_start();
require_once '../functions/connect.php';


if (isset($_POST['send'])) {
    
    $categories = $_POST['categories'];
    
    $dbh = connect();
    $sql = 'UPDATE categories SET category = 
    case id WHEN 1 THEN ? WHEN 2 THEN ? WHEN 3 THEN ? WHEN 4 THEN ?
    END WHERE id IN (1, 2, 3, 4)';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $categories[0], PDO::PARAM_STR);
    $stmt->bindValue(2, $categories[1], PDO::PARAM_STR);
    $stmt->bindValue(3, $categories[2], PDO::PARAM_STR);
    $stmt->bindValue(4, $categories[3], PDO::PARAM_STR);
    $stmt->execute();
    $dbh = null;
    
}




?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/admin/common.css">
    <title>管理ページ</title>
</head>

<body>

    <div class="admin">
        <?php if (!empty($_GET['action']) && $_GET['action'] === 'success') : ?>
            <p class="message">投稿に成功ました</p>
        <?php endif; ?>
        <header>
            <h2>カテゴリー管理ページ</h2>
        </header>

        <div class="main">
            <form action="" method="post">
                <?php for ($i = 1; $i < 5; $i++): ?>
                <div>
                    <label for="">カテゴリー<?php echo $i; ?></label>
                    <input type="text" name="categories[]">
                </div>
                <?php endfor; ?>
                <button name="send">送信する</button>
            </form>
        </div>
        <a href="admin.php">管理画面へ</a>
    </div>
</body>

</html>
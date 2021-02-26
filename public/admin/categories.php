<?php

session_start();
require_once '../functions/connect.php';
require_once '../functions/fetch.php';

if (isset($_POST['send'])) {
    
    $categories = $_POST['categories'];
    
    $dbh = connect();
    $sql = 'UPDATE categories SET category = 
    case id WHEN 2 THEN ? WHEN 3 THEN ? WHEN 4 THEN ? WHEN 5 THEN ?
    END WHERE id IN (2, 3, 4, 5)';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $categories[0], PDO::PARAM_STR);
    $stmt->bindValue(2, $categories[1], PDO::PARAM_STR);
    $stmt->bindValue(3, $categories[2], PDO::PARAM_STR);
    $stmt->bindValue(4, $categories[3], PDO::PARAM_STR);
    $stmt->execute();
    $dbh = null;
    
}

$categories = categoriesFetch();
$count = 1;



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
                <?php foreach($categories as $category): ?>
                <div>
                    <label for="">カテゴリー<?php echo $count; ?></label>
                    <input type="text" name="categories[]" value="<?php echo $category['category']; ?>" require maxlength="7">
                </div>
                <?php $count++; ?>
                <?php endforeach; ?>
                <button name="send">送信する</button>
            </form>
        </div>
        <a href="admin.php">管理画面へ</a>
    </div>
</body>

</html>
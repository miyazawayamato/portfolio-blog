<?php

require_once '../functions/fetch.php';
session_start();

if (empty($_SESSION['title'])) {
    header('Location:http://localhost/product/1/post.php');
    exit();
} else {
    //csrfトークン
    $_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(48));
    $token = htmlspecialchars($_SESSION['token'], ENT_QUOTES);
    
    
    $category = categoryFetch($_SESSION['category']);
    
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/common.css">
    <link rel="stylesheet" href="../assets/css/article/article.css">
    <link rel="stylesheet" href="../assets/css/check/check.css">
    <title>Document</title>
</head>
<body>

<header>
    <h2 class="main-title">確認画面</h2>
</header>
<div class="main">
    
    <h2 class="title"><?php echo $_SESSION['title']; ?></h2>
    <?php if (!empty($_SESSION['image'])): ?>
        <img src="../assets/tmp/<?php echo $_SESSION['image']; ?>" class="image">
    <?php else : ?>
        <p class="image no-image">NoImage</p>
    <?php endif; ?>
    <p class="text"><?php echo $_SESSION['body']; ?></p>
    
    <span><?php echo $category['category']; ?></span>
    
    <form action="../functions/posting.php" method="post">
        <input type="hidden" name="token" value="<?php echo $token ?>">
        <button>投稿する</button>
        <p><a href="post.php?action=back">入力画面へ戻る</a></p>
    </form>
    
</div>
<footer style="height: 100px;">
</footer>
</body>
</html>
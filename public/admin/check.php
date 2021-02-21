<?php
session_start();

if (empty($_SESSION['title'])) {
    header('Location:http://localhost/product/1/post.php');
    exit();
} else {
    //csrfトークン
    $_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(48));
    $token = htmlspecialchars($_SESSION['token'], ENT_QUOTES);
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/check/check.css">
    <title>Document</title>
</head>
<body>

<header>
    <h2>確認画面</h2>
</header>
<div class="main">

    <div class="image-check">
        <?php if (!empty($_SESSION['image'])): ?>
        <img src="../assets/tmp/<?php echo $_SESSION['image']; ?>" >
        <?php else: ?>
        <p class="no-image">NoImage</p>
        <?php endif; ?>
    </div>
    
    <p class="title"><?php echo $_SESSION['title']; ?></p>
    <p class="body-check"><?php echo $_SESSION['body']; ?></p>
    
    
    <!-- <?php foreach ($_SESSION['tags'] as $taga => $tag ): ?>
    <span><?php echo $tag; ?></span>
    <?php endforeach; ?>
     -->
    
    <form action="../functions/posting.php" method="post">
        <input type="hidden" name="token" value="<?php echo $token ?>">
        <button>投稿する</button>
        <p><a href="post.php?action=back">入力画面へ戻る</a></p>
    </form>
    
</div>
</body>
</html>
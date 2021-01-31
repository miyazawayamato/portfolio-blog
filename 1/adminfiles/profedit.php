<?php

require_once 'prof.php';

$prof = getProf();



?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <!-- <link rel="stylesheet" href="../css/post/post.css"> -->
    <title>プロフィール編集</title>
</head>
<body>

<header>
    <h2>プロフィール編集画面</h2>
</header>

<div class="main">
    <form action="" method="post">
    
        <input type="text" name="blog_title">
        <input type="text" name="name">
        <textarea name="prof_text"></textarea>
        <img id="image-view">
        <input type="file" accept=".png, .jpg, .jpeg, gif" name="prof_image" id="image-select">
    
    </form>
</div>
    
    
    
<script src="../javascript/image.js"></script>
</body>
</html>
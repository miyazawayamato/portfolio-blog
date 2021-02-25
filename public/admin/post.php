<?php

require_once '../functions/escape.php';
require_once '../functions/validation.php';


session_start();
$errors = array();
$title ;
$body ;
$file ;
$_SESSION['image'] = NUll;

if (isset($_POST['send'])) {

    $title = $_POST['title'];
    $body = $_POST['body'];
    $file = $_FILES['file-image'];

    $errors = postValidate($title, $body, $file);

    $filename = basename($file['name']);
    $file_path = $file['tmp_name'];
    $tmp_dir = '../assets/tmp/';
    
    if (count($errors) === 0) {
        $_SESSION['title'] = $title;
        $_SESSION['body'] = $body;
        $_SESSION['tags'] = $tags;

        if (is_uploaded_file($file['tmp_name'])) {
            $save_filename = date('Ymdhis') . $filename;
            $_SESSION['image'] = $save_filename;
            move_uploaded_file($file_path, $tmp_dir . $save_filename);
        }

        header('Location:./check.php');
        exit();
    }
}

if (!empty($_GET['action']) && $_GET['action'] === 'back') {
    $title = $_SESSION['title'];
    $body = $_SESSION['body'];
    $image = $_SESSION['image'];
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/admin/common.css">
    <link rel="stylesheet" href="../assets/css/post/post.css">
    <title>投稿画面</title>
</head>

<body>
    <header>
    <h2><a href="./admin.php">投稿画面</a></h2>
    </header>
    <div class="main">

        <div class="error">
            <?php if ($errors) : ?>
                <p class="announce">記入要件を満たしていないものがあります</p>
                <?php foreach ($errors as $error) : ?>
                    <p class="message"><?php echo $error; ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <!-- 確認画面から戻ったあとの画像とタグの表示 -->
        <form action="" method="post" enctype="multipart/form-data">
            <span class="item">タイトル</span>
            <input type="text" name="title" value="<?php if (isset($title)) {echo $title;} ?>" class="title" maxlength="50">
            <span class="item">本文</span>
            <textarea name="body" class="form-body"><?php if (isset($body)) {echo $body;} ?></textarea>
            <span class="item">画像の選択</span>
            <img id="image-view">
            <input type="file" accept=".png, .jpg, .jpeg, gif" name="file-image" id="image-select">

            <button name="send">確認画面へ</button>
        </form>
        <a href="./admin.php">戻る</a>
    </div>
    <footer style="height: 100px;">
    </footer>
    <script src="../assets/javascript/image.js"></script>
</body>

</html>
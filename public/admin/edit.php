<?php
session_start();
require_once '../functions/connect.php';
require_once '../functions/escape.php';
require_once '../functions/validation.php';
require_once '../functions/editpost.php';
require_once '../functions/fetch.php';


//ログイン判定
// if (empty($_SESSION['member'])) {
//     header('Location:./admin_login.php');
// }

//getで表示
//postで編集して遷移

$file_dir = '../assets/file/';
$errors = array();

if (!empty($_GET['post_id']) && empty($_POST['post_id'])) {
    
    $post_id = $_GET['post_id'];
    
    $post = oneFetch($post_id);
    
    $curentFilepass = $post['filepass'];
    
} else if (!empty($_POST['post_id'])) {
    
    //現在の画像、なければ空文字を取得
    $curentFilepass = h($_POST['curentfilepass']);
    //更新するデータ取得
    $post_id = $_POST['post_id'];
    $title = $_POST['title'];
    $body = $_POST['body'];
    $category = $_POST['category'];
    //画像変更のパターンを取得
    $image = $_POST['image-change'];
    //画像があればそのデータを取得
    $file = $_FILES['file-image'];

    //バリデーションにかける
    $errors = postValidate($title, $body, $file);

    //エラーがないなら実行
    if (count($errors) === 0) {
        switch ($image) {
            case 0: //変更なし
                change($title,$body,$category,$post_id);
                break;
            case 1: //変更あり//ありからあり、なしからあり、ありからなし、なしからなし
                if (is_uploaded_file($file['tmp_name'])) {
                    //DB更新
                    $filename = basename($file['name']);
                    $file_path = $file['tmp_name'];
                    $save_filename = date('Ymdhis') . $filename;
                    updata($title,$body,$category,$save_filename,$post_id,$curentFilepass);
                    move_uploaded_file($file_path, $file_dir . $save_filename);
                } else {
                    if (!empty($curentFilepass)) { //ありからなし
                        $save_filename = NULL;
                        updata($title,$body,$category,$save_filename,$post_id,$curentFilepass);
                    } else { //なしからなし// case 0 と同じ
                        change($title,$body,$category,$post_id);
                    }
                }
                break;
            case 2: //削除//なしからなし、ありからなし
                if (!empty($curentFilepass)) { //ありからなし
                    $save_filename = NULL;
                    updata($title,$body,$category,$save_filename,$post_id,$curentFilepass);
                } else { //なしからなし
                    // case 0 と同じ
                    change($title,$body,$category,$post_id);
                }
                break;
        }

        $url = 'edit.php?post_id=' . $post_id;
        header('Location:' . $url);
        exit();
    }
}

$categories = categoriesFetch();


?>

<!-- カテゴリーごとの表示 -->
<!-- なび -->



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/admin/common.css">
    <link rel="stylesheet" href="../assets/css/post/post.css">
    <title>編集画面</title>
</head>

<body>
    <header>
        <h2>記事編集画面</h2>
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


        <p style="margin-bottom: 20px;">画像</p>

        <div class="btns">
            <span class="btn red" style="cursor: pointer;">そのまま</span>
            <span class="btn" style="cursor: pointer;">変更</span>
            <span class="btn" style="cursor: pointer;">削除</span>
        </div>

        <form action="" method="post" enctype="multipart/form-data">

            <div class="check-image">
            
                <div id="old-image" class="btn-image visible invisible">
                    <?php if (!empty($curentFilepass)) : ?>
                        <img src="<?php echo $file_dir . h($curentFilepass); ?>">
                        <input type="hidden" name="curentfilepass" value="<?php echo h($curentFilepass); ?>">
                    <?php else : ?>
                        <p class="no-image">NoImage</p>
                    <?php endif; ?>
                </div>



                <div id="new-image" class="invisible btn-image">
                    <img id="image-view">
                    <input type="file" accept=".png, .jpg, .jpeg, gif" name="file-image" id="image-select">
                </div>


                <div id="delete-image" class="invisible btn-image">
                    <p class="no-image">NoImage</p>
                </div>

            </div>
            
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <input type="hidden" value="0" id="case" name="image-change">
            
            <span>タイトル</span>
            <input type="text" name="title" value="<?php if (isset($title)) {echo $title;} else {echo h($post['title']);}; ?>" class="title" maxlength="50">
            <span>本文</span>
            <textarea name="body" class="form-body"><?php if (isset($body)) {echo $body;} else {echo h($post['body']);}; ?></textarea>
            
            
            <span style="display: none;" id="select-num"><?php if (isset($category)) {echo $category;} else {echo h($post['category_id']);}; ?></span>
            <select name="category" id="select">
                <?php foreach ($categories as $item) : ?>
                    <option value="<?php echo $item['id'];?>"><?php echo $item['category'];?></option>
                <?php endforeach; ?>
            </select>
            
            <button name="send">変更する</button>
        </form>
        <a href="admin.php">管理画面へ</a>
    </div>
    <script src="../assets/javascript/image.js"></script>
    <script src="../assets/javascript/category.js"></script>
</body>

</html>
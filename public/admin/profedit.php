<?php

require_once '../functions/prof.php';
require_once '../functions/connect.php';
require_once '../functions/escape.php';


$prof = getProf();
$errors = array();

if (isset($_POST['send'])) {

    $blog_title = $_POST['blog_title'];
    $name = $_POST['name'];
    $prof_text = $_POST['prof_text'];
    $prof_image = $_FILES['prof_image'];
    
    $errors = valiProf($blog_title, $name, $prof_text, $prof_image);
    
    //画像の処理がまだ
    if (count($errors) === 0) {
        $dbh = connect();
        $sql = "UPDATE prof set blog_title = ?, name = ?, prof_text = ?, imagepass = ? WHERE id =  1";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $blog_title, PDO::PARAM_STR);
        $stmt->bindValue(2, $name, PDO::PARAM_STR);
        $stmt->bindValue(3, $prof_text, PDO::PARAM_STR);
        
        if (is_uploaded_file($prof_image['tmp_name'])) {
            
            $save_filename = date('Ymdhis') . basename($prof_image['name']);
            move_uploaded_file($prof_image['tmp_name'], '../assets/prof/' . $save_filename);
            $stmt->bindValue(4, $save_filename, PDO::PARAM_STR);
            
            foreach ( glob('../assets/prof/*') as $file ) {
                unlink($file);
            }
            
        } else {
            $stmt->bindValue(4, NUll , PDO::PARAM_STR);
        }
        $stmt->execute();
    }
}




?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/admin/common.css">
    <link rel="stylesheet" href="../assets/css/prof/prof.css">
    <title>プロフィール編集</title>
</head>

<body>

    <header>
        <h2>プロフィール編集画面</h2>
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
        <div class="prof-form">
            <form action="" method="post" enctype="multipart/form-data">
                <div >
                    <label for="">タイトル</label>
                    <input type="text" name="blog_title" value="<?php echo ($prof['blog_title']); ?>">
                </div>
                <div>
                    <label for="">名前</label>
                    <input type="text" name="name" value="<?php echo h($prof['name']); ?>">
                </div>
                <div>
                    <label for="" class="prof-text">自己紹介文</label>
                    <textarea name="prof_text"><?php echo h($prof['prof_text']); ?></textarea>
                </div>
                <div>
                    <label for="">プロフィール写真</label>
                    <img id="image-view">
                    <input type="file" accept=".png, .jpg, .jpeg, gif" name="prof_image" id="image-select">
                </div>
                <button name="send">更新する</button>
            </form>
        
        </div>
        <a href="./admin.php">戻る</a>
    </div>



    <script src="../javascript/image.js"></script>
</body>

</html>
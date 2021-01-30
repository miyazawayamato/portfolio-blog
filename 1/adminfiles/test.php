<?php


require_once 'connect.php';
require_once 'functions.php';

// post_tags＿holds
$dbh = connect();

//$sql = "SELECT posts.id, posts.title, post_tags＿holds.id, group_concat(post_tags＿holds.tags_id)
$sql = "SELECT *
FROM posts
LEFT JOIN post_tags＿holds
ON posts.id = post_tags＿holds.posts_id;
LEFT JOIN tags
ON post_tags＿holds.tags_id = tags.id";



$stmt = $dbh->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll();

//配列にする
$holds = explode(',', $holds);

//tagがまとめと取得できないため記事に被りがでる
// ('../tmp/{*.jpg, *.jpeg, *.png, *.gif}')
// if (!empty($_POST['btn'])){
//     foreach ( glob('../tmp/*') as $file ) {
//         unlink($file);
//     }
    
//     echo '削除です';
// }

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php 
echo '<br>';
var_dump($posts);
echo '<br>';
?>


<form action="" method="post">
<button name="btn" value="test">削除</button>
</form>
</body>
</html>
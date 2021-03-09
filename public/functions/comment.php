<?php

session_start();

require_once '../functions/connect.php';
require_once '../functions/escape.php';
require_once '../functions/escape.php';

$errors = array();
$post_id = $_POST['post_id'];
$name = $_POST['name'];
$comment = $_POST['comment'];

if (isset($_POST['send'])) {


    if (empty($name)) {
        $errors[] = 'ネームを入力してください';
    } else if (20 < mb_strlen($name)) {
        $errors[] = 'ネームは20字以内で入力してください';
    }

    if (empty($comment)) {
        $errors[] = 'コメントを入力してください';
    } else if (200 < mb_strlen($comment)) {
        $errors[] = 'コメントは200字以内で入力してください';
    }
    
    $url = '../user/article.php?post_id=' . $post_id;
    
    //エラーがない
    if (!count($errors)) {
        
        $dbh = connect();
        $sql = 'INSERT INTO comments (post_id, name, comment) VALUE (?, ?, ?)';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $post_id, PDO::PARAM_STR);
        $stmt->bindValue(2, $name, PDO::PARAM_STR);
        $stmt->bindValue(3, $comment, PDO::PARAM_STR);
        $stmt->execute();
        $_SESSION['errors'] = array();
        
    } else {
        
        $_SESSION['errors'] = $errors;
        
    }
}
header('Location:' . $url);
exit();

<?php

session_start();

require_once '../adminfiles/connect.php';
require_once '../adminfiles/functions.php';

$errors = array();
$post_id = $_POST['post_id'];
$name = $_POST['name'];
$coment = $_POST['coment'];


if (isset($_POST['send'])) {
    
    
    if (empty($name)){
        $errors[] = '名前を入力してください';
    } else if (50 < mb_strlen($name)){
        $errors[] = '50字以内で入力してください';
    }
    
    if (empty($coment)){
        $errors[] = 'コメントを入力してください';
    } else if (200 < mb_strlen($coment)){
        $errors[] = '200字以内で入力してください';
    }
    
    $url = 'article.php?post_id='.$post_id;
    
    $dbh = connect();
    $sql = "SELECT * FROM posts WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $post_id, PDO::PARAM_STR);
    $stmt->execute();
    $id = $stmt->fetch();
    //エラーがないかつpostが存在している
    if (count($errors) === 0 && !is_null($id)) {
        $dbh = connect();
        $sql = 'INSERT INTO coments (posts_id, name, coment) VALUE (?, ?, ?)';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_STR);
        $stmt->bindValue(2, $name, PDO::PARAM_STR);
        $stmt->bindValue(3, $coment, PDO::PARAM_STR);
        $stmt->execute();
        $_SESSION['errors'] = array();
    } else {
        $_SESSION['errors'] = $errors;
    }
    
} 
header('Location:'.$url);
exit();




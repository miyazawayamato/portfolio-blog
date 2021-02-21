<?php
require_once 'connect.php';

if (!empty($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $dbh = connect();//コネクト一つでいいのか
    $stmt = $dbh->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->bindValue(1,$post_id,PDO::PARAM_STR);
    $stmt->execute();
    $file = $stmt->fetch();
    $filepass = $file['filepass'];
    
    var_dump($filepass);
    
    // if (!is_null($filepass)) {
    //     unlink('../file/'.$filepass);
    // }
    // $sql = "DELETE FROM posts WHERE id = ?";
    // $stmt = $dbh->prepare($sql);
    // $stmt->bindValue(1,$post_id,PDO::PARAM_STR);
    // $stmt->execute();
    // header('Location:./admin.php');
    // exit();
} else if (!empty($_GET['com_id'])) {
    $com_id = $_GET['com_id'];
    $dbh = connect();
    $stmt = $dbh->prepare("DELETE FROM comments WHERE id = ?");
    $stmt->bindValue(1,$com_id,PDO::PARAM_STR);
    $stmt->execute();
    header('Location:./admin.php');
    exit();
}
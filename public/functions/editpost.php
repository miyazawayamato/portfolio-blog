<?php

require_once 'connect.php';

function change($title,$body,$category,$post_id) {
    
    $dbh = connect();
    
    $sql = "UPDATE posts set title = ?, body = ?, category_id = ? WHERE id =  ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1,$title,PDO::PARAM_STR);
    $stmt->bindValue(2,$body,PDO::PARAM_STR);
    $stmt->bindValue(3,$category,PDO::PARAM_STR);
    $stmt->bindValue(4,$post_id,PDO::PARAM_STR);
    $stmt->execute();
    
    return true;
}

function updata($title,$body,$category,$save_filename,$post_id,$curentFilepass) {
    //DB更新
    $dbh = connect();
    $sql = "UPDATE posts set title = ?, body = ?, category_id = ?, filepass = ? WHERE id =  ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $title, PDO::PARAM_STR);
    $stmt->bindValue(2, $body, PDO::PARAM_STR);
    $stmt->bindValue(3, $category, PDO::PARAM_STR);
    $stmt->bindValue(4, $save_filename, PDO::PARAM_STR);
    $stmt->bindValue(5,$post_id,PDO::PARAM_STR);
    $stmt->execute();
    //ファイルの移動
    $file_dir = '../file/';
    if (!empty($curentFilepass)) {
        unlink($file_dir.$curentFilepass);
    }
    return true;
}
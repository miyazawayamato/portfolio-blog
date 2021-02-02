<?php

require_once 'connect.php';

function change($title,$body,$post_id) {
    
    $dbh = connect();
    
    $sql = "UPDATE posts set title = ?, body = ? WHERE id =  ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1,$title,PDO::PARAM_STR);
    $stmt->bindValue(2,$body,PDO::PARAM_STR);
    $stmt->bindValue(3,$post_id,PDO::PARAM_STR);
    $stmt->execute();
    
    return true;
}

function updata($title,$body,$post_id,$save_filename,$curentFilepass) {
    //DB更新
    $dbh = connect();
    $sql = "UPDATE posts set title = ?, body = ?, filepass = ? WHERE id =  ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $title, PDO::PARAM_STR);
    $stmt->bindValue(2, $body, PDO::PARAM_STR);
    $stmt->bindValue(3, $save_filename, PDO::PARAM_STR);
    $stmt->bindValue(4,$post_id,PDO::PARAM_STR);
    $stmt->execute();
    //ファイルの移動
    $file_dir = '../file/';
    if (!empty($curentFilepass)) {
        unlink($file_dir.$curentFilepass);
    }
    return true;
}
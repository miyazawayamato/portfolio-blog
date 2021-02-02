<?php


//新規登録時に入力させる

require_once 'connect.php';

function getProf() {
    $dbh = connect();
    $sql = "SELECT * FROM prof  WHERE id = 1";
    $stmt = $dbh->prepare($sql);
    // $stmt->bindValue(1,1,PDO::PARAM_STR);
    $stmt->execute();
    $prof = $stmt->fetch();
    
    return $prof;
}

function valiProf($blog_title,$name,$prof_text,$file) {
    
    if (empty($blog_title)){
        $errors[] = 'タイトルを入力してください';
    } else if (20 < mb_strlen($blog_title)){
        $errors[] = '20字以内で入力してください';
    }
    
    if (empty($name)){
        $errors[] = '名前を入力してください';
    } else if (10 < mb_strlen($name)){
        $errors[] = '10字以内で入力してください';
    }
    
    if (empty($prof_text)){
        $errors[] = '本文を入力してください';
    } else if (1000 < mb_strlen($prof_text)){
        $errors[] = '1000字以内で入力してください';
    }
    
    if (is_uploaded_file($file['tmp_name'])) {
        //basename
        $filename = basename($file['name']);
        $file_err = $file['error'];
        $filesize = $file['size'];
        // //許容する拡張子
        $array_ext = array('jpg', 'jpeg', 'png', 'gif');
        // //送信したファイルの拡張子を取得
        $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
        
        if (!in_array(strtolower($file_ext), $array_ext)) {
            $errors[] = '適切な拡張子でお願いします';
        } else if ($filesize > 1048576 || $file_err == 2) {
            $errors[] = 'サイズが大きすぎます';
        }
    }
    
    return $errors;
}

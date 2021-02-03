<?php

function postValidate($title, $body, $file) {
    
    $errors = array();
    
    if (empty($title)){
        $errors[] = 'タイトルを入力してください';
    } else if (50 < mb_strlen($title)){
        $errors[] = '50字以内で入力してください';
    }
    
    if (empty($body)){
        $errors[] = '本文を入力してください';
    } else if (1000 < mb_strlen($body)){
        $errors[] = '1000字以内で入力してください';
    }
    
    //タグ
    // if (!empty($_POST['tags'])){
    //     $tags = h($_POST['tags']);
    // } else {
    //     $tags[] = '1';
    // }
    
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
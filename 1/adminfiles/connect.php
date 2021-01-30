<?php

function connect() {
    $dsn = 'mysql:dbname=blog;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';
    try{
        $dbh = new PDO($dsn,$user,$password, array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,//例外を投げる
            PDO::ATTR_EMULATE_PREPARES => false,//静的にする
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC//fetch取得方法をあらかじめ設定
        ));
        return $dbh;
    } catch (PDOException $e) {
        print "エラー: ".$e->getMessage() ."<br>";
        die();
    }
}

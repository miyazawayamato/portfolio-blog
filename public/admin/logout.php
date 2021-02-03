<?php

//ボタンのチェック
session_start();
$_SESSION = array();//セッションの中身をすべて削除
session_destroy();//セッションを破壊

header('Location:./admin_login.php');
exit();







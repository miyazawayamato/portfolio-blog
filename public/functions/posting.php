<?php

session_start();
require_once 'connect.php';
//session破棄したほうがよさそう

if (isset($_SESSION['token'], $_POST['token']) && ($_POST['token'] === $_SESSION['token'])) {
    unset($_SESSION['token']);
    $dbh = connect();
    $sql = 'INSERT INTO posts (title, body, category_id ,filepass) VALUE (?, ?, ?, ?)';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $_SESSION['title'], PDO::PARAM_STR);
    $stmt->bindValue(2, $_SESSION['body'], PDO::PARAM_STR);
    $stmt->bindValue(3, $_SESSION['category'], PDO::PARAM_STR);
    if ($_SESSION['image']) {
        $stmt->bindValue(4, $_SESSION['image'], PDO::PARAM_STR);
        $tmp_path = '../assets/tmp/'.$_SESSION['image'];
        $file_dir = '../assets/file/'.$_SESSION['image'];
        if (rename($tmp_path, $file_dir)) {
            //tmpにあるものを削除
            foreach ( glob('../assets/tmp/*') as $file ) {
                unlink($file);
            }
        }
    } else {
        $stmt->bindValue(4, NUll , PDO::PARAM_STR);
    }
    $stmt->execute();
$dbh = null;

//member(ログイン保持)のためのsessionを破棄
$save = $_SESSION['member'];
$_SESSION = array();
$_SESSION['member'] = $save;

}

//成否判定した方がよさそう

header('Location:../admin/admin.php?action=success');
exit();
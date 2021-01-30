<?php
require_once 'connect.php';

session_start();
$errors = array();


if (!$_POST['login']) {
    $admin_id = $_POST['admin_id'];
    $pass = $_POST['pass'];
    
    if (!empty($admin_id) && !empty($pass)) {
        $dbh = connect();
        $sql = "SELECT * FROM administrators WHERE admin_id = ?";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $admin_id, PDO::PARAM_INT);
        $stmt->execute();
        $member = $stmt->fetch();
        
        if (!$member) {
            $errors[] = '一致しません';
        }
        if (!password_verify($pass, $member['pass'])) {
            $errors[] = '一致しません';
        }
    } else {
        $errors[] = '空欄があります';
    }
    
    if (count($errors) === 0) {
        //セッションハイジャック対策
        session_regenerate_id((true));
        //値を作り挿入する
        $_SESSION['member'] = $admin_id;
        header('Location:./admin.php');
        exit();
    }
    
    
}



?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php if ($errors): ?>
    <?php foreach ($errors as $error): ?>
    <p><?php echo $error; ?></p>
    <?php endforeach; ?>
<?php endif; ?>
    <form action="" method="post">
        <p>管理者を追加する</p>
        <span>ID</span>
        <input type="text" name="admin_id">
        <span>パスワード</span>
        <input type="password" name="pass">
        <button name="login">ログイン</button>
    </form>
    <a href="./admin_register.php">管理者登録</a>
</body>
</html>
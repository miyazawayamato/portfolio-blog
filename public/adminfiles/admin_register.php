<?php

require_once 'connect.php';

session_start();
$errors = array();

if (!empty($_POST['submit'])) {
    $admin_id = $_POST['admin_id'];
    $pass = $_POST['pass'];
    $pass_conf = $_POST['pass_conf'];
    
    if (empty($admin_id)){
        $errors[] = 'IDを入力してください';
    } else if (!preg_match("/[!-~]{6,10}/",$admin_id)){
        $errors[] = 'しっかり入力してください';
    }
    
    if (empty($pass)){
        $errors[] = 'パスワードを入力してください';
    } else if (!preg_match("/\A[a-z\d]{8,100}+\z/i", $pass)){
        $errors[] = 'しっかりしてください';
    } else if ($pass !== $pass_conf) {
        $errors[] = 'パスワードが一致しません';
    } else {
        $pass = password_hash($pass, PASSWORD_DEFAULT);
    }
    
    
    if (count($errors) === 0) {
        $dbh = connect();
        $sql = "SELECT * FROM administrators WHERE admin_id = ?";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $admin_id, PDO::PARAM_INT);
        $stmt->execute();
        $member = $stmt->fetch();
        if ($member['admin_id'] === $admin_id) {
            $errors[] = 'idが重複してます';
        } else {
            $sql = "INSERT INTO administrators(admin_id, pass) VALUE(?, ?)";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(1, $admin_id, PDO::PARAM_INT);
            $stmt->bindValue(2, $pass, PDO::PARAM_INT);
            $stmt->execute();
            
            header('Location:./admin_login.php');
            exit();
        }
    }
    //csrfトークンがあるか、トークンが一致しているか
    
    
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
    <p>記入要件を満たしていないものがあります</p>
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
    <span>パスワード（確認用）</span>
    <input name="pass_conf" type="password">
    <button name="submit" value="登録">登録する</button>
    </form>
    <a href="./admin_login.php">ログイン画面</a>
</body>
</html>
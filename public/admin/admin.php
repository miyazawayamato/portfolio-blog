<?php
session_start();

//ログイン判定
// if (empty($_SESSION['member'])) {
//     header('Location:./admin_login.php');
// }


require_once '../functions/escape.php';
require_once '../functions/fetch.php';

$posts = allFetch();

define('MAX', '5'); //1ページにいくつ表示するか
$posts_num = count($posts); //記事数確認
$max_page = ceil($posts_num / MAX); //割って最大ページ数取得
// $_GET['page_id'] はURLに渡された現在のページ数
if (!isset($_GET['page_id'])) {
    $now = 1; // 設定されてない場合は1ページ目にする
} else {
    $now = $_GET['page_id'];
}
$start_no = ($now - 1) * MAX; // すべての記時の何番目から取得すればよいか
// 配列の何番目($start_no)から何番目(MAX)まで切り取る
$disp_data = array_slice($posts, $start_no, MAX, true);


?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/admin/common.css">
    <link rel="stylesheet" href="../assets/css/admin/admin.css">
    <title>管理ページ</title>
</head>

<body>

    <div class="admin">
        <?php if (!empty($_GET['action']) && $_GET['action'] === 'success') : ?>
            <p class="message">投稿に成功ました</p>
        <?php endif; ?>
        <header>
            <h2><a href="./admin.php">管理ページ</a></h2>
            <nav>
                <ul class="navi">
                    <li><a href="./post.php">投稿ページ</a></li>
                    <li><a href="./profedit.php">プロフィール</a></li>
                    <!-- <li><a href="">ログアウト</a></li> -->
                    <li><a href="./category.php">カテゴリー編集</a></li>
                    <li><a href="../user/top.php">トップ画面</a></li>
                </ul>
            </nav>
        </header>

        <div class="main">
            <span>全記事数:<?php echo $posts_num; ?>件</span>
            <div class="list">
                <?php foreach ($disp_data as $post) : ?>
                    <div class="box">
                        <h3><?php echo h($post['title']); ?></h3>
                        <div class="box-menu">
                            <span class="admin-time"><?php echo h(date('Y年m月d日G時i分s秒', strtotime($post['time']))); ?></span>

                            <span class="delete-btn">記事削除</span>
                            <a href="delete.php?post_id=<?php echo h($post['id']); ?>" style="display: none;" class="delete-exe">削除</a>

                            <a href="edit.php?post_id=<?php echo h($post['id']); ?>">編集</a>
                            <a href="comments.php?post_id=<?php echo h($post['id']); ?>">コメント</a>
                        </div>
                        <div class="box-main">
                            <?php if (!is_null($post['filepass'])) : ?>
                                <img src="<?php echo '../assets/file/' . h($post['filepass']); ?>" class="image">
                            <?php else : ?>
                                <p class="image no-image">NoImage</p>
                            <?php endif; ?>
                            <p class="text"><?php echo h($post['body']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php for ($i = 1; $i <= $max_page; $i++) { // 最大ページ数分リンクを作成
        if ($i == $now) { // 現在表示中のページ数の場合はリンクを貼らない
            echo '<spam>' . $now . '</span>　';
        } else {
            echo '<a href=./admin.php?page_id=' . $i . '>' . $i . '</a>' . '　';
        }
    }; ?>

    <script src="../javascript/admin.js"></script>
</body>

</html>
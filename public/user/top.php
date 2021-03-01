<?php

session_start();

require_once '../functions/fetch.php';
require_once '../functions/escape.php';
require_once '../functions/prof.php';

$_SESSION['errors'] = array();


$prof = getProf();

$posts = allFetch();

//ページネーション
define('MAX', '6'); //1ページにいくつ表示するか
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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/common.css">
    <link rel="stylesheet" href="../assets/css/top/top.css">
    <title>サンプルブログ</title>
</head>

<body>
    <header>
        <h1 class="main-title"><a href="top.php" class="title-font"><?php echo h($prof['blog_title']); ?></a></h1>
    </header>
    <div class="main">
        <div class="left">
            <div class="lists">
                <?php foreach ($disp_data as $post) : ?>
                    <div class="list-main">
                        <a href="article.php?post_id=<?php echo h($post['id']); ?>">
                            <div class="list-img">
                                <?php if (!is_null($post['filepass'])) : ?>
                                    <img src="<?php echo '../assets/file/' . h($post['filepass']); ?>" class="image">
                                <?php else : ?>
                                    <p class="image no-image">NoImage</p>
                                <?php endif; ?>
                            </div>
                            <div class="list-info">
                                <h3 class="list-title"><?php echo h($post['title']); ?></h3>
                                <div class="text-right">
                                    <span class="list-time"><?php echo h(date('Y年m月d日', strtotime($post['time']))); ?></span>
                                    <a href="category.php?category_id=<?php echo h($post['category_id']); ?>" class=" cate"><?php echo h($post['category']); ?></a>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            
            </div>
            <div class="page">
                <?php for ($i = 1; $i <= $max_page; $i++) { // 最大ページ数分リンクを作成
                    if ($i == $now) { // 現在表示中のページ数の場合はリンクを貼らない
                        echo '<spam>' . $now . '</span>　';
                    } else {
                        echo '<a href=./top.php?page_id=' . $i . '>' . $i . '</a>' . '　';
                    }
                };
                ?>
            </div>
        </div>
        
        <div class="right">
            <div class="prof">
                <h4>プロフィール</h4>
                <img src="" alt="" style="display: block;">
                <span>name:</span><span><?php echo h($prof['name']); ?></span>
                <p class="prof-text"><?php echo h($prof['prof_text']); ?></p>
            </div>
            <div class="time-navi">
            </div>
        </div>
    </div>
    
    <footer >
        <span class="copy">©2021/yamato-miyazawa</span>
    </footer>
</body>

</html>
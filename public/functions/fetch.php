<?php

require_once '../functions/connect.php';

function oneFetch($post_id) {
    
    $dbh = connect();
    $sql = "SELECT posts.id , title, body, filepass, time, category, category_id FROM posts JOIN categories ON posts.category_id = categories.id WHERE posts.id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $post_id, PDO::PARAM_STR);
    $stmt->execute();
    $post = $stmt->fetch();
    
    return $post;
}

function allFetch() {
    
    $dbh = connect();
    $sql = "SELECT posts.id AS id, title, body, filepass, time, category, category_id FROM posts JOIN categories ON posts.category_id = categories.id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $posts = $stmt->fetchAll();
    
    return $posts;
}

function commentsFetch($post_id) {
    
    $dbh = connect();
    $sql = "SELECT * FROM comments  WHERE post_id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $post_id, PDO::PARAM_STR);
    $stmt->execute();
    $comments = $stmt->fetchAll();
    
    return $comments;
}

function categoriesFetch() {
    
    $dbh = connect();
    $sql = "SELECT * FROM categories";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll();
    
    return $categories;
}

function categoryFetch($id) {
    
    $dbh = connect();
    $sql = "SELECT * FROM categories WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_STR);
    $stmt->execute();
    $category = $stmt->fetch();
    
    return $category;
}

function postCategoryFetch($category_id) {
    
    
    $dbh = connect();
    $sql = "SELECT * FROM posts WHERE category_id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $category_id, PDO::PARAM_STR);
    $stmt->execute();
    $posts = $stmt->fetchAll();
    
    return $posts;
}
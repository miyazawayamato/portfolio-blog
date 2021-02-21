<?php

require_once '../functions/connect.php';

function oneFetch($post_id) {
    
    $dbh = connect();
    $sql = "SELECT * FROM posts WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $post_id, PDO::PARAM_STR);
    $stmt->execute();
    $post = $stmt->fetch();
    
    return $post;
}

function allFetch() {
    
    $dbh = connect();
    $sql = "SELECT * FROM posts";
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
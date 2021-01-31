<?php

require_once 'connect.php';

function getProf() {
    $dbh = connect();
    $sql = "SELECT * FROM prof";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $prof = $stmt->fetch();
    
    return $prof;
}

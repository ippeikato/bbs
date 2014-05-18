<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST' ) {
    http_response_code(405);  
    exit;
} 
try {
    require_once ('config.php');
    $dbh = new PDO(DSN, DB_USER, DB_PASSWORD);
    $stmt = $dbh -> prepare("delete from posts where `id` = ?");
    $stmt -> execute(array($_POST['id']));
} catch (PDOException $e) {
    echo $e->getMessage();
    http_response_code(500);  
    exit;
}
http_response_code(200);  

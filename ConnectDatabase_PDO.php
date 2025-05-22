<?php
    $host = "localhost";
    $db_name = "ql_xehoi";
    $username = "root";
    $pass = "";

    try{
        $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $pass);
    }
    catch(PDOException $e){
        echo "Lỗi kết nối: " . $e->getMessage();
        die();
    }


?>
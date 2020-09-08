<?php
    $mysqli = new mysqli("localhost:3308", "root", "", "simple_shop");
    if($mysqli->connect_errno) {
        echo "Faild to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }
?>
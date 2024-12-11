<?php
    $server = 'localhost';
    $user = 'root';
    $pass = '22042004';
    $database = 'K72_Nhom21';
    $connect = new mysqli($server, $user,$pass, $database);
    if($connect){
        mysqli_query($connect, "SET NAMES 'utf8' ");
    } else {
        echo "connect database unsuccessful";
    }
?>
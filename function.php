<?php
    // query
    $server = 'localhost';
    $user = 'root';
    $pass = 'Vinh123204@';
    $database = 'xettuyen';
    $connect = new mysqli($server, $user,$pass, $database);
    if($connect){
        mysqli_query($connect, "SET NAMES 'utf8' ");
    } else {
        echo "connect database unsuccessful";
    }

    function sql_query_fetchAll($sql) {
        global $connect;
        $query = mysqli_query($connect, $sql);
        $arr = mysqli_fetch_all($query);
        return $arr;
    }
?>
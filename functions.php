<?php 
    include './database/connect.php';

    
?>

<?php
    function queryNoReturn($sql){
        global $connect;
        mysqli_query($connect, $sql);
    }

    function queryReturn($sql){
        global $connect;
        $result = mysqli_query($connect, $sql);
        return $result;
    }
?>
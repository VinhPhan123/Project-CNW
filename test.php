<?php
    include './functions.php';

    $sql = "SELECT * FROM gen_code";
    $result = queryReturn($sql);

    $array_code = array();
    while($r = mysqli_fetch_array($result)){
        array_push($array_code, $r['code']);
    }

    print_r($array_code);
?>
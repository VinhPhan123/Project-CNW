<?php
    include './functions.php';


    // $condition = [
    //     'id_teacher' => 4,
    //     'username' => 'teacher2'
    // ];

    // $value = ['email', 'phone_number'];
    // $query = select('teachers', $value, $condition);
    
    // $arr = array();
    // while($r = mysqli_fetch_array($query)){
    //     array_push($arr, $r['email']);
    // }

    // print_r($arr);
    
    // $data = [
    //     'code' => 'avsadf',
    //     'id_admin' => '1',
    //     'gen_time' => time(),
    //     'expiry_time' => time() + 3600
    // ];

    // $result = insert('gen_code', $data);
    // if($result){
    //     echo 'true';
    // } else{
    //     echo 'false';
    // }

    // $condition = [
    //     'id_teacher' => 4,
    //     'username' => 'teacher2'
    // ];

    // $value = [
    //     'email' => 'man@gmail.com',
    //     'phone_number' => '012394932'
    // ];
    // $result = update('teachers', $value, $condition);
    // echo $result;

    $condition = [
        'id_admin' => 1,
        'code' => 'avsadf'
    ];

    $result = delete('gen_code', $condition);
    echo $result;
    

?>
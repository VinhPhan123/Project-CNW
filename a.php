<?php 
		include './layouts/header.php';
?>

<?php
    $sql2 = "SELECT * FROM students WHERE id_student = 1;";
    $query2 = mysqli_query($connect, $sql2);
    $row = mysqli_fetch_array($query2);

    // Lấy thông tin cá nhân
    $fullname = $row['fullname'];
    $ngaysinh = $row['ngaysinh'];
    $phone_number = $row['phone_number'];
    $gender = $row['gender'];
    $address = $row['address'];
    $email = $row['email'];

    // echo $fullname . ' - ' . $ngaysinh . ' - ' . $phone_number . ' - ' . $gender . ' - ' .  $address . ' - ' . $email;
    $truong_chuyen = $row['truong_chuyen'];
    $giai_hs_gioi = $row['giai_hs_gioi'];
    $chung_chi_ielts = $row['chung_chi_ielts'];
    $giai_thuong_khac = $row['giai_thuong_khac'];
    $doi_tuong_uu_tien = $row['doi_tuong_uu_tien'];
    $khu_vuc_uu_tien = $row['khu_vuc_uu_tien'];

    // echo $truong_chuyen . ' - ' . $giai_hs_gioi . ' - ' . $chung_chi_ielts . ' - ' . $giai_thuong_khac . ' - ' .  $doi_tuong_uu_tien . ' - ' . $    $khu_vuc_uu_tien = $row['khu_vuc_uu_tien'];
    // Tên trường - Lớp - Minh chứng
    $array_truong_chuyen = explode(" | ", $truong_chuyen);
    foreach($array_truong_chuyen as $value){
        // echo $value . '<br>';
    }
    // Môn - Giải - Minh chứng
    $array_giai_hs_gioi = explode(" | ", $giai_hs_gioi);
    foreach($array_giai_hs_gioi as $value){
        // echo $value . '<br>';
    }

    // Mã chứng nhân - Điểm - Minh chứng
    $array_chung_chi_ielts = explode(" | ", $chung_chi_ielts);
    foreach($array_chung_chi_ielts as $value){
        // echo $value . '<br>';
    }

    // Mô tả - Minh chứng
    $array_giai_thuong_khac = explode(" | ", $giai_thuong_khac);
    foreach($array_giai_thuong_khac as $value){
        // echo $value . '<br>';
    }

    // Đối tượng - Minh chứng
    $array_doi_tuong_uu_tien = explode(" | ", $doi_tuong_uu_tien);
    foreach($array_doi_tuong_uu_tien as $value){
        echo $value . '<br>';
    }

    // Khu vực
    $array_khu_vuc_uu_tien = explode(" | ", $khu_vuc_uu_tien);
    foreach($array_khu_vuc_uu_tien as $value){
        // echo $value . '<br>';
    }


?>
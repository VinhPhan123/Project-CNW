<?php 
		include './layouts/header.php';
?>


<?php
    $sql = "SELECT * FROM academic_records WHERE id_student=1";
    $query = mysqli_query($connect, $sql);

    // $array = mysqli_fetch_array($query);
    $assoc = mysqli_fetch_assoc($query);
    print_r($assoc);
    echo '<br>';

    $array_mon = array();
    $sql1 =  "SELECT * FROM subject_combination WHERE id_SB='A01';";
    $query1 = mysqli_query($connect, $sql1);
    $row = mysqli_fetch_array($query1); // Lưu kết quả vào biến

    if ($row) { // Kiểm tra xem có dữ liệu không
        array_push($array_mon, $row['sub_1']);
        array_push($array_mon, $row['sub_2']);
        array_push($array_mon, $row['sub_3']);
    }

    print_r($array_mon);
    echo '<br>';

    $mark = 0;
    foreach($assoc as $index => $value){
        if($index == 'Toan') {
            $mon_hoc = 'Toán';
        } else if($index == 'NguVan') {
            $mon_hoc = 'Ngữ Văn';
        } else if($index == 'TiengAnh') {
            $mon_hoc = 'Tiếng Anh';
        } else if($index == 'VatLy') {
            $mon_hoc = 'Vật Lý';
        } else if($index == 'HoaHoc') {
            $mon_hoc = 'Hóa Học';
        } else if($index == 'SinhHoc') {
            $mon_hoc = 'Sinh Học';
        } else if($index == 'LichSu') {
            $mon_hoc = 'Lịch Sử';
        } else if($index == 'DiaLy') {
            $mon_hoc = 'Địa Lý';
        } else if($index == 'TinHoc') {
            $mon_hoc = 'Tin Học';
        } else if($index == 'CongNghe') {
            $mon_hoc = 'Công Nghệ';
        } else if($index == 'GiaoDucCongDan') {
            $mon_hoc = 'Giáo Dục Công Dân';
        } else if($index == 'GiaoDucTheChat') {
            $mon_hoc = 'Giáo Dục Thể Chất';
        } else {
            continue;
        }
        foreach($array_mon as $mon){
            // echo $mon . '-';
            if($mon_hoc === $mon) {
                $mark += $value;
            }
        }
    }

    echo $mark;


?>

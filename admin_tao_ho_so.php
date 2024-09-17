<?php 
		include './layouts/header.php';
?>

<div style="display: flex; justify-content: center;">

<?php 
    if(isset($_SESSION['role'])) {
		include './layouts/menu.php';
	}
?>

<?php
    $m=0;
    $n=0;
    $token = md5(uniqid());

    $date_now = date('Y-m-d');        #Thời gian hiện tại
?>

<?php
    $sql_select_chuyennganh = "SELECT * FROM chuyennganh";
    $query_select_chuyennganh = mysqli_query($connect, $sql_select_chuyennganh);
    $result_select_chuyennganh = mysqli_num_rows($query_select_chuyennganh);
    $arr_select_chuyennganh = mysqli_fetch_all($query_select_chuyennganh);
    
    $sql_select_subject_combination = "SELECT * FROM subject_combination";
    $query_select_subject_combination = mysqli_query($connect, $sql_select_subject_combination);
    $result_select_subject_combination = mysqli_num_rows($query_select_subject_combination);
    $arr_select_subject_combination = mysqli_fetch_all($query_select_subject_combination);

    // echo "<pre>";
    // echo print_r($arr_select_chuyennganh);
    // echo "</pre>";
?>

<?php
    $sql_select_majors = "SELECT * FROM majors";
    $query_select_majors = mysqli_query($connect, $sql_select_majors);
    $result_select_majors = mysqli_num_rows($query_select_majors);

    if($result_select_majors == 0) {
        echo "Chưa có ngành nào";
    } else {
        $arr_select_majors = mysqli_fetch_all($query_select_majors);
        // echo "<pre>";
        // echo print_r($arr_select_majors);
        // echo "</pre>";
?>
<link rel="stylesheet" href="./assets/css/admin_tao_ho_so.css">
<div style="display: block; width: 100%;">
	<div class="container mt-4" style="width: max-content; margin-left: auto; margin-right: auto;">
        <h4 style="color: #0c6efd;">Danh sách hồ sơ</h4>
        <!-- <p style="color: #;"></p> -->
        <?php
                echo "
                <table>
                    <tr>
                        <th id='stt'>STT</th>
                        <th id='major_name'>Tên ngành</th>
                        <th id='sub'>Tổ hợp môn</th>
                        <th class='diem_san'>Điểm sàn</th>
                        <th>Thời gian bắt đầu</th>
                        <th>Thời gian Kết thúc</th>
                        <th>Trạng thái</th>
                        <th>Action</th>
                    </tr>";
                for($i=0; $i<$result_select_majors; $i++) {    
                    echo "<tr>";
                    $tmp = $i+1;
                    echo "<td id='stt'>" . $tmp . "</td>";
                    echo "<td id='major_name'>" . $arr_select_majors[$i][1] . "</td>";
                    echo "<td id='sub'>";
                        $sql_select_chuyennganh = "SELECT * FROM chuyennganh WHERE id_major = " . $arr_select_majors[$i][0] . " ORDER BY id_SB;";
                        $query_select_chuyennganh = mysqli_query($connect, $sql_select_chuyennganh);
                        $result_select_chuyennganh = mysqli_num_rows($query_select_chuyennganh);
                        $string_sub_list = '';
                        if($result_select_chuyennganh == 0) {
                            echo "Chưa có tổ hợp môn";
                        } else {
                            $arr_select_chuyennganh = mysqli_fetch_all($query_select_chuyennganh);
                            $tmp_arr_select_chuyennganh = array();
                            for($j=0; $j<$result_select_chuyennganh; $j++) {
                                array_push($tmp_arr_select_chuyennganh, $arr_select_chuyennganh[$j][1]);
                            }
                            
                            for($j=0; $j<$result_select_chuyennganh; $j++) {
                                echo "<p style='margin: 0px; text-align: left; margin-left: 10px'>";
                                echo $tmp_arr_select_chuyennganh[$j] . " - " . $arr_select_subject_combination[$j][1] . " - " . $arr_select_subject_combination[$j][2] . " - " . $arr_select_subject_combination[$j][3];
                                if($j < $result_select_chuyennganh-1) echo '<br>';
                                echo "</p>";
                            }
                            for($j=0; $j<count($tmp_arr_select_chuyennganh); $j++) {
                                $string_sub_list .= $tmp_arr_select_chuyennganh[$j];
                                if($j < count($tmp_arr_select_chuyennganh)-1) {
                                    $string_sub_list .= '|';
                                }
                            }
                        }
                    echo "</td>";
                    $tmp = $i+1;
                    echo "<td>" . $arr_select_majors[$i][4]  . "</td>";
                    $time_start = '';
                    if(isset($arr_select_majors[$i][2])) {
                        $date=date_create($arr_select_majors[$i][2]);
                        $time_start = date_format($date,"d/m/Y");
                    }
                    echo "<td>" . $time_start . "</td>";
                    $time_end = '';
                    if(isset($arr_select_majors[$i][3])) {
                        $date=date_create($arr_select_majors[$i][3]);
                        $time_end = date_format($date,"d/m/Y");
                    }
                    echo "<td>" . $time_end . "</td>";
                    if(isset($arr_select_majors[$i][2])) {
                        if(strtotime($date_now) < strtotime($arr_select_majors[$i][2])) {
                            echo "<td>" . $arr_select_majors[$i][5] . "<p style='color:#1f96f6; font-style: italic;'>(Chưa mở)</p></td>";
                        } else {
                            if(isset($arr_select_majors[$i][3])) {
                                if(strtotime($date_now) < strtotime($arr_select_majors[$i][3])) {
                                    echo "<td>" . $arr_select_majors[$i][5] . "<p style='color:#79d28d; font-style: italic;'>(Còn hạn)</p></td>";
                                } else {
                                    echo "<td>" . $arr_select_majors[$i][5] . "<p style='color:#e13647; font-style: italic;'>(Hết hạn)</p></td>";
                                }
                            }
                        }
                    } else {
                        echo "<td>". $arr_select_majors[$i][5] . "</td>";
                    }
                    echo "<td>";
                    echo "<form action='admin_sua_ho_so.php' method='post'>
                        <input type='hidden' name='id_major' value='" . $arr_select_majors[$i][0] . "'>";
                        echo "<input type='hidden' name='major_name' value='" . $arr_select_majors[$i][1] . "'>";
                        echo "<input type='hidden' name='time_start' value='" . $arr_select_majors[$i][2]  . "'>";
                        echo "<input type='hidden' name='time_end' value='" . $arr_select_majors[$i][3]  . "'>";
                        echo "<input type='hidden' name='diem_san' value='" . $arr_select_majors[$i][4]  . "'>";
                        echo "<input type='hidden' name='status' value='" . $arr_select_majors[$i][5]  . "'>";
                        echo "<input type='hidden' name='sub_list' value='" . $string_sub_list  . "'>";
                        echo "<button type='submit' class='btn btn-primary'>Sửa</button></form>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        ?>
	<!-- End Page content -->
	</div>
    <?php
        
    ?>

	<?php 
        $_SESSION['token'] = $token;
		include './layouts/footer.php';
	?>
</div>
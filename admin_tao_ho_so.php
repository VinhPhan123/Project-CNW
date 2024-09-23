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
                    $sql_select_chuyennganh = "SELECT * FROM chuyennganh WHERE id_major = " . $arr_select_majors[$i][0] . " ORDER BY id_SB;";
                    $query_select_chuyennganh = mysqli_query($connect, $sql_select_chuyennganh);
                    $result_select_chuyennganh = mysqli_num_rows($query_select_chuyennganh);
                    echo "<td rowspan='$result_select_chuyennganh'>" . $tmp . "</td>";
                    echo "<td rowspan='$result_select_chuyennganh'>" . $arr_select_majors[$i][1] . "</td>";
                    echo "<td>";
                    $string_sub_list = '';
                    $tmp_arr_to_hop_mon = array();
                    if($result_select_chuyennganh == 0) {
                        echo "Chưa có tổ hợp môn";
                        $string_sub_list = "";
                    } else {
                        $arr_select_chuyennganh = mysqli_fetch_all($query_select_chuyennganh);
                        for($j=0; $j<$result_select_chuyennganh; $j++) {
                            array_push($tmp_arr_to_hop_mon, $arr_select_chuyennganh[$j][1]);
                        }
                    }
                    echo "<p style='margin: 0px; text-align: left; margin-left: 10px'>";
                    echo $tmp_arr_to_hop_mon[0] . " - " . $arr_select_subject_combination[0][1] . " - " . $arr_select_subject_combination[0][2] . " - " . $arr_select_subject_combination[0][3];
                    echo "</p>";
                    echo "</td>";
                    $tmp = $i+1;
                    echo "<td>";
                    if(isset($arr_select_chuyennganh[0][4])) {
                        echo $arr_select_chuyennganh[0][4]  . "";
                    }
                    echo "</td>";
                    $time_start = '';
                    if(isset($arr_select_chuyennganh[0][2])) {
                        $date=date_create($arr_select_chuyennganh[0][2]);
                        $time_start = date_format($date,"d/m/Y");
                    }
                    echo "<td>" . $time_start . "</td>";
                    $time_end = '';
                    if(isset($arr_select_chuyennganh[0][3])) {
                        $date=date_create($arr_select_chuyennganh[0][3]);
                        $time_end = date_format($date,"d/m/Y");
                    }
                    echo "<td>" . $time_end . "</td>";
                    if(isset($arr_select_chuyennganh[0][2])) {
                        if(strtotime($date_now) < strtotime($arr_select_chuyennganh[0][2])) {
                            echo "<td>" . $arr_select_chuyennganh[0][5] . "<p style='color:#1f96f6; font-style: italic;'>(Chưa mở)</p></td>";
                        } else {
                            if(isset($arr_select_chuyennganh[$i][3])) {
                                if(strtotime($date_now) < strtotime($arr_select_chuyennganh[0][3])) {
                                    echo "<td>" . $arr_select_chuyennganh[0][5] . "<p style='color:#79d28d; font-style: italic;'>(Còn hạn)</p></td>";
                                } else {
                                    echo "<td>" . $arr_select_chuyennganh[0][5] . "<p style='color:#e13647; font-style: italic;'>(Hết hạn)</p></td>";
                                }
                            }
                        }
                    } else {
                        echo "<td>". $arr_select_chuyennganh[0][5] . "</td>";
                    }
                    echo "<td>";
                    echo "<form action='admin_sua_ho_so.php' method='post'>
                        <input type='hidden' name='id_major' value='" . $arr_select_chuyennganh[0][0] . "'>
                        <input type='hidden' name='id_SB' value='" . $arr_select_chuyennganh[0][1] . "'>";
                        echo "<input type='hidden' name='major_name' value='" . $arr_select_majors[$i][1] . "'>";
                        echo "<input type='hidden' name='time_start' value='" . $arr_select_chuyennganh[0][2]  . "'>";
                        echo "<input type='hidden' name='time_end' value='" . $arr_select_chuyennganh[0][3]  . "'>";
                        echo "<input type='hidden' name='diem_san' value='" . $arr_select_chuyennganh[0][4]  . "'>";
                        echo "<input type='hidden' name='status' value='" . $arr_select_chuyennganh[0][5]  . "'>";
                        echo '<input type="hidden" name="_token" value="'. $token .'"/>';
                        echo "<button name='setting_major' type='submit' class='btn btn-primary'>Sửa</button></form>";
                    echo "</td>";
                    echo "</tr>";

                    if($result_select_chuyennganh > 0) {
                        for($j=1; $j<$result_select_chuyennganh; $j++) {
                            echo "<tr>";
                            echo "<td>";
                            echo "<p style='margin: 0px; text-align: left; margin-left: 10px'>";
                            echo $tmp_arr_to_hop_mon[$j] . " - " . $arr_select_subject_combination[$j][1] . " - " . $arr_select_subject_combination[$j][2] . " - " . $arr_select_subject_combination[$j][3];
                            echo "</p>";
                            echo "</td>";
                            $tmp = $i+1;
                            echo "<td>" . $arr_select_chuyennganh[$j][4]  . "</td>";
                            $time_start = '';
                            if(isset($arr_select_chuyennganh[$j][2])) {
                                $date=date_create($arr_select_chuyennganh[$j][2]);
                                $time_start = date_format($date,"d/m/Y");
                            }
                            echo "<td>" . $time_start . "</td>";
                            $time_end = '';
                            if(isset($arr_select_chuyennganh[$j][3])) {
                                $date=date_create($arr_select_chuyennganh[$j][3]);
                                $time_end = date_format($date,"d/m/Y");
                            }
                            echo "<td>" . $time_end . "</td>";
                            if(isset($arr_select_chuyennganh[$j][2])) {
                                if(strtotime($date_now) < strtotime($arr_select_chuyennganh[$j][2])) {
                                    echo "<td>" . $arr_select_chuyennganh[$j][5] . "<p style='color:#1f96f6; font-style: italic;'>(Chưa mở)</p></td>";
                                } else {
                                    if(isset($arr_select_chuyennganh[$j][3])) {
                                        if(strtotime($date_now) < strtotime($arr_select_chuyennganh[$j][3])) {
                                            echo "<td>" . $arr_select_chuyennganh[$j][5] . "<p style='color:#79d28d; font-style: italic;'>(Còn hạn)</p></td>";
                                        } else {
                                            echo "<td>" . $arr_select_chuyennganh[$j][5] . "<p style='color:#e13647; font-style: italic;'>(Hết hạn)</p></td>";
                                        }
                                    }
                                }
                            } else {
                                echo "<td>". $arr_select_chuyennganh[$j][5] . "</td>";
                            }
                            echo "<td>";
                            echo "<form action='admin_sua_ho_so.php' method='post'>
                                <input type='hidden' name='id_major' value='" . $arr_select_chuyennganh[$j][0] . "'>
                                <input type='hidden' name='id_SB' value='" . $arr_select_chuyennganh[$j][1] . "'>";
                                echo "<input type='hidden' name='major_name' value='" . $arr_select_majors[$i][1] . "'>";
                                echo "<input type='hidden' name='time_start' value='" . $arr_select_chuyennganh[$j][2]  . "'>";
                                echo "<input type='hidden' name='time_end' value='" . $arr_select_chuyennganh[$j][3]  . "'>";
                                echo "<input type='hidden' name='diem_san' value='" . $arr_select_chuyennganh[$j][4]  . "'>";
                                echo "<input type='hidden' name='status' value='" . $arr_select_chuyennganh[$j][5]  . "'>";
                                echo '<input type="hidden" name="_token" value="'. $token .'"/>';
                                echo "<button name='setting_major' type='submit' class='btn btn-primary'>Sửa</button></form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    }
                }
                echo "</table>";
            }
        ?>
	<!-- End Page content -->
	</div>
    <?php
        if(isset($_POST['setting_major']) && isset($_SESSION['token']) && $_SESSION['token'] == $_POST['_token']) {
            $tmp_sub_list = $_POST['sub_list'];
            $tmp_arr = explode('|', $tmp_sub_list);
            $_SESSION['sub_list'] = $tmp_arr;
            echo "<script>alert('OK!');</script>";
        }
    ?>

	<?php 
        $_SESSION['token'] = $token;
		include './layouts/footer.php';
	?>
</div>
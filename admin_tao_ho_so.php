<?php 
    include './layouts/header.php';
    include './XuLyPhien/admin.php';
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
            echo "<table>
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
                for($i = 0; $i < $result_select_majors; $i++) {
                    $tmp = $i + 1;
                    $sql_select_chuyennganh_of_major = "SELECT * FROM chuyennganh as CN
                                                        JOIN subject_combination AS SC ON CN.id_SB = SC.id_SB
                                                        WHERE CN.id_major = " . $arr_select_majors[$i][0] . ";";
                    $query_select_chuyennganh_of_major = mysqli_query($connect, $sql_select_chuyennganh_of_major);
                    $result_select_chuyennganh_of_major = mysqli_num_rows($query_select_chuyennganh_of_major);
                    $arr_select_chuyennganh_of_major = mysqli_fetch_all($query_select_chuyennganh_of_major);
                    // echo "<pre>";
                    // echo print_r($arr_select_chuyennganh_of_major);
                    // echo "</pre>";
                    if($result_select_chuyennganh_of_major == 0) {
                        echo "<tr>";
                        echo "<td rowspan='" . $result_select_chuyennganh_of_major . "'>" . $tmp . "</td>";
                        echo "<td style='text-align: left;' rowspan='" . $result_select_chuyennganh_of_major . "'>" . $arr_select_majors[$i][1] . "</td>";
                        echo "<td colspan='6'>Chưa có tổ hợp môn của ngành này!</td>";
                        echo "</tr>";
                    } else {
                        for($j = 0; $j < $result_select_chuyennganh_of_major; $j++) {
                            echo "<tr>";
                            if($j == 0) {
                                echo "<td rowspan='" . $result_select_chuyennganh_of_major . "'>" . $tmp . "</td>";
                                echo "<td style='text-align: left;' rowspan='" . $result_select_chuyennganh_of_major . "'>" . $arr_select_majors[$i][1] . "</td>";
                            }
                            echo "<td style='text-align: left;'>".$arr_select_chuyennganh_of_major[$j][6]." - ".$arr_select_chuyennganh_of_major[$j][7].", ".$arr_select_chuyennganh_of_major[$j][8].", ".$arr_select_chuyennganh_of_major[$j][9]."</td>";
                            if($arr_select_chuyennganh_of_major[$j][2] != "") {
                                echo "<td>".$arr_select_chuyennganh_of_major[$j][4]."</td>";
                                
                                $date_start=date_create($arr_select_chuyennganh_of_major[$j][2]);
                                $time_start = date_format($date_start,"d/m/Y");
                                echo "<td>".$time_start."</td>";

                                $date_end=date_create($arr_select_chuyennganh_of_major[$j][3]);
                                $time_end = date_format($date_end,"d/m/Y");
                                echo "<td>".$time_end."</td>";
                                echo "<td>";
                                echo $arr_select_chuyennganh_of_major[$j][5];
                                if(strtotime($date_now) < strtotime($arr_select_chuyennganh_of_major[$j][2])) {
                                    echo "<p style='color:#1f96f6; font-style: italic;'>(Chưa mở)</p>";
                                } else {
                                    if(strtotime($date_now) > strtotime($arr_select_chuyennganh_of_major[$j][3])) {
                                        echo "<p style='color:#e13647; font-style: italic;'>(Hết hạn)</p>";
                                    } else {
                                        echo "<p style='color:#79d28d; font-style: italic;'>(Còn hạn)</p>";
                                    }
                                }
                                echo "</td>";

                            } else {
                                echo "<td colspan='4'>Hồ sơ chưa được tạo!</td>";
                            }
                            echo "<td>";
                            echo "<form action='admin_sua_ho_so.php' method='post'>
                                <input type='hidden' name='id_major' value='" . $arr_select_chuyennganh_of_major[$j][0] . "'>
                                <input type='hidden' name='id_SB' value='" . $arr_select_chuyennganh_of_major[$j][1] . "'>";
                                echo "<input type='hidden' name='major_name' value='" . $arr_select_majors[$i][1] . "'>";
                                echo "<input type='hidden' name='time_start' value='" . $arr_select_chuyennganh_of_major[$j][2]  . "'>";
                                echo "<input type='hidden' name='time_end' value='" . $arr_select_chuyennganh_of_major[$j][3]  . "'>";
                                echo "<input type='hidden' name='diem_san' value='" . $arr_select_chuyennganh_of_major[$j][4]  . "'>";
                                echo "<input type='hidden' name='status' value='" . $arr_select_chuyennganh_of_major[$j][5]  . "'>";
                                echo '<input type="hidden" name="_token" value="'. $token .'"/>';
                                echo "<button name='setting_major' type='submit' class='btn btn-primary'>Sửa</button>
                            </form>";
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
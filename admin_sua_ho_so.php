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
?>

<?php
    // $sql_select_chuyennganh = "SELECT * FROM chuyennganh";
    // $query_select_chuyennganh = mysqli_query($connect, $sql_select_chuyennganh);
    // $result_select_chuyennganh = mysqli_num_rows($query_select_chuyennganh);
    // $arr_select_chuyennganh = mysqli_fetch_all($query_select_chuyennganh);

    // $arr_sb_list = array();
    // if(isset($_POST['id_major'])) {
    //     for($i= 0;$i<count($arr_select_chuyennganh); $i++) {
    //         if($arr_select_chuyennganh[$i][0] == $_POST['id_major']) {
    //             $arr_sb_list[] = $arr_select_chuyennganh[$i][1];
    //         }
    //     }
    // }
    // echo "<pre>";
    // echo print_r($arr_sb_list);
    // echo "</pre>";
    
    $sql_select_subject_combination = "SELECT * FROM subject_combination";
    $query_select_subject_combination = mysqli_query($connect, $sql_select_subject_combination);
    $result_select_subject_combination = mysqli_num_rows($query_select_subject_combination);
    $arr_select_subject_combination = mysqli_fetch_all($query_select_subject_combination);

    echo "<pre>";
    echo print_r($arr_select_subject_combination);
    echo "</pre>";
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
<link rel="stylesheet" href="./assets/css/admin_sua_ho_so.css">
<div style="display: block; width: 100%;">
	<div class="container mt-4" style="width: max-content; margin-left: auto; margin-right: auto;">
	<!-- Page content -->
        
        <?php
            // print_r($_POST['sub_list']);
            $string_sub_list = $_POST['sub_list'];
            $sub_list = explode('|', $string_sub_list);
            print_r($sub_list);
        ?>
        <h4 style="color: #0c6efd;">Sửa hồ sơ</h4>
        <div class="setting_ledger">
            <form action="" method="post">
                <input type="hidden" name="id_major" value="<?php if(isset($_POST['id_major'])) echo $_POST['id_major'] ?>">
                <label class="setting_label" for="major_name">Tên ngành</label>
                <input class="setting_input" type="text" name="major_name" value="<?php if(isset($_POST['major_name'])) echo $_POST['major_name'] ?>"><br>
                <label class="setting_label" style="vertical-align: top;" for="">Tổ hợp môn</label>
                <div style="display: inline-block; width: 300px; border: 1px solid black; min-height: 50px;">
                    <?php
                    $sql_select_chuyennganh = "SELECT * FROM chuyennganh WHERE id_major = " . $_POST['id_major'] . " ORDER BY id_SB;";
                    $query_select_chuyennganh = mysqli_query($connect, $sql_select_chuyennganh);
                        $result_select_chuyennganh = mysqli_num_rows($query_select_chuyennganh);
                        if($result_select_chuyennganh == 0) {
                            echo "Chưa có tổ hợp môn";
                        } else {
                            $arr_select_chuyennganh = mysqli_fetch_all($query_select_chuyennganh);
                            $tmp_arr_select_chuyennganh = array();
                            for($j=0; $j<$result_select_chuyennganh; $j++) {
                                array_push($tmp_arr_select_chuyennganh, $arr_select_chuyennganh[$j][1]);
                            }

                            for($j=0; $j<$result_select_chuyennganh; $j++) {
                                echo "<p style='margin: 0px; text-align: left;'>";
                                echo $tmp_arr_select_chuyennganh[$j] . " - " . $arr_select_subject_combination[$j][1] . " - " . $arr_select_subject_combination[$j][2] . " - " . $arr_select_subject_combination[$j][3];
                                if($j < $result_select_chuyennganh-1) echo '<br>';
                                echo "</p>";
                            }
                        }
                    ?>
                </div><br>
                <label class="setting_label" for="diem_san">Điểm sàn</label>
                <input class="setting_input" type="text" name="diem_san" value="<?php if(isset($_POST['diem_san'])) echo $_POST['diem_san'] ?>"><br>
                <label class="setting_label" for="time_start">Thời gian bắt đầu</label>
                <input class="setting_input" type="date" name="time_start" value="<?php if(isset($_POST['time_start'])) echo $_POST['time_start'] ?>"><br>
                <label class="setting_label" for="time_start">Thời gian kết thúc</label>
                <input class="setting_input" type="date" name="time_end" value="<?php if(isset($_POST['time_end'])) echo $_POST['time_end'] ?>"><br>
                <label class="setting_label" for="status">Trạng thái</label>
                <select class="setting_input" name="status" id="">
                    <option></option>
                    <option <?php if(isset($_POST['status']) && $_POST['status'] == 'Ẩn') echo 'selected'; ?> value="Ẩn">Ẩn</option>
                    <option <?php if(isset($_POST['status']) && $_POST['status'] == 'Hiện') echo 'selected'; ?> value="Hiện">Hiện</option>
                </select><br>
                <?php echo '<input type="hidden" name="_token" value="'. $token .'"/>';?>
                <div class="setting_button">
                    <button type="submit" name="Change" class="btn btn-success">Sửa</button>
                    <button type="submit" name="delete" class="btn btn-danger">Xóa</button>
                    <button type="submit" name="cancel" class="btn btn-primary">Hủy</button>
                </div>
            </form>
            
            <div>
                <form action="admin_sua_ho_so.php" method="post">
                    <input type="hidden" name="id_major" value="<?php if(isset($_POST['id_major'])) echo $_POST['id_major'] ?>">
                    <input type="hidden" name="major_name" value="<?php if(isset($_POST['major_name'])) echo $_POST['major_name'] ?>"><br>
                    <input type="hidden" name="diem_san" value="<?php if(isset($_POST['diem_san'])) echo $_POST['diem_san'] ?>"><br>
                    <input type="hidden" name="time_start" value="<?php if(isset($_POST['time_start'])) echo $_POST['time_start'] ?>"><br>
                    <input type="hidden" name="time_end" value="<?php if(isset($_POST['time_end'])) echo $_POST['time_end'] ?>"><br>
                    <input type='hidden' name='sub_list' value='<?php echo $string_sub_list; ?>'>
                    <label for="insert_sub">Thêm tổ hợp môn</label>
                    <select name="insert_sub">
                        <option></option>
                        <?php
                            for($i= 0; $i<$result_select_subject_combination; $i++) {
                                if(!in_array($arr_select_subject_combination[$i][0], $sub_list)) {
                                    echo '<option value="' . $arr_select_subject_combination[$i][0]  . '">' . $arr_select_subject_combination[$i][0]  . '</option>';
                                }
                            }
                        ?>
                    </select>
                    <?php echo '<input type="hidden" name="_token" value="'. $token .'"/>'; ?>
                    <button type="submit" class="btn btn-success" name="button_insert_sub">Thêm</button>
                </form>
                
                <form action="admin_sua_ho_so.php" method="post">
                    <input type="hidden" name="id_major" value="<?php if(isset($_POST['id_major'])) echo $_POST['id_major'] ?>">
                    <input type="hidden" name="major_name" value="<?php if(isset($_POST['major_name'])) echo $_POST['major_name'] ?>"><br>
                    <input type="hidden" name="diem_san" value="<?php if(isset($_POST['diem_san'])) echo $_POST['diem_san'] ?>"><br>
                    <input type="hidden" name="time_start" value="<?php if(isset($_POST['time_start'])) echo $_POST['time_start'] ?>"><br>
                    <input type="hidden" name="time_end" value="<?php if(isset($_POST['time_end'])) echo $_POST['time_end'] ?>"><br>
                    <input type='hidden' name='sub_list' value='<?php echo $string_sub_list; ?>'>
                    <label for="delete_sub">Xóa tổ hợp môn</label>
                    <select name="delete_sub">
                        <option></option>
                        <?php
                            for($i=0; $i<count($sub_list); $i++) {
                                echo '<option value="' . $sub_list[$i]  . '">' . $sub_list[$i]  . '</option>';
                            }
                        ?>
                    </select>
                    <?php echo '<input type="hidden" name="_token" value="'. $token .'"/>'; ?>
                    <button type="submit" class="btn btn-warning" name="button_delete_sub">Xóa</button>
                </form>
            </div><br>
        </div>
        <?php
            }
        ?>
	<!-- End Page content -->
	</div>
    <?php
        if(isset($_POST['button_insert_sub']) && isset($_SESSION['token']) && $_SESSION['token'] == $_POST['_token']) {

        }

        if(isset($_POST['button_delete_sub']) && isset($_SESSION['token']) && $_SESSION['token'] == $_POST['_token']) {

        }

        if(isset($_POST['Change']) && isset($_SESSION['token']) && $_SESSION['token'] == $_POST['_token']) {

            if($_POST['major_name'] == '' || $_POST['diem_san'] == '' || $_POST['time_start'] == '' || $_POST['time_end'] == '' || $_POST['status'] == '') {
                echo "<script>alert('Bạn chưa nhập đầy đủ thông tin!');</script>";
            } else {
                $id_major = $_POST['id_major'];
                $major_name = $_POST['major_name'];
                $diem_san = (float)$_POST['diem_san'];
                $time_start = $_POST['time_start'];
                $time_end = $_POST['time_end'];
                $status = $_POST['status'];

                if($diem_san > 30 || $diem_san < 0) {
                    echo "<script>alert('Điểm sàn phải từ 0 đến 30 điểm!');</script>";
                } else {
                    if($time_start > $time_end) {
                        echo "<script>alert('Thời gian kết thúc không được có trước thời gian bắt đầu!');</script>";
                    } else {
                        // echo $id_major .'<br>'. $major_name . '<br>'. $diem_san .'<br>'. $time_start . '<br>'. $time_end .'<br>'. $status;
        
                        $sql_update_majors = "UPDATE majors SET
                                                    time_start = '$time_start',
                                                    time_end = ' $time_end',
                                                    diem_san = $diem_san,
                                                    Status = '$status'
                                                WHERE id_major = $id_major;";
                        mysqli_query($connect, $sql_update_majors);
                        echo "<script>alert('Đã sửa hồ sơ thành công!');</script>";
                        echo '<script>window.location="admin_tao_ho_so.php";</script>';
                    }
                } 
            }
        }

        if(isset($_POST['delete']) && isset($_SESSION['token']) && $_SESSION['token'] == $_POST['_token']) {
            $id_major = $_POST['id_major'];

            $sql_delete_chuyennganh = "DELETE FROM chuyennganh WHERE id_major=$id_major;";
            $sql_delete_major = "DELETE FROM majors WHERE id_major=$id_major;";

            mysqli_query($connect, $sql_delete_chuyennganh);
            mysqli_query($connect, $sql_delete_major);
            echo '<script>window.location="admin_tao_ho_so.php";</script>';
        }

        if(isset($_POST['cancel']) && isset($_SESSION['token']) && $_SESSION['token'] == $_POST['_token']) {
            echo '<script>window.location="admin_tao_ho_so.php";</script>';
        }
    ?>

	<?php 
        $_SESSION['token'] = $token;
		include './layouts/footer.php';
	?>
</div>
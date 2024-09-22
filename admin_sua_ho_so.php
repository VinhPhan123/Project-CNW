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

    // echo "<pre>";
    // echo print_r($arr_select_subject_combination);
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
<link rel="stylesheet" href="./assets/css/admin_sua_ho_so.css">
<div style="display: block; width: 100%;">
	<div class="container mt-4" style="width: max-content; margin-left: auto; margin-right: auto;">
	<!-- Page content -->
        
        <?php
            if(isset($_POST['id_major'])) {
                $_SESSION['id_major'] = $_POST['id_major'];
            }
            if(isset($_POST['major_name'])) {
                $_SESSION['major_name'] = $_POST['major_name'];
            }
            if(isset($_POST['diem_san'])) {
                $_SESSION['diem_san'] = $_POST['diem_san'];
            }
            if(isset($_POST['time_start'])) {
                $_SESSION['time_start'] = $_POST['time_start'];
            }
            if(isset($_POST['time_end'])) {
                $_SESSION['time_end'] = $_POST['time_end'];
            }
            if(isset($_POST['status'])) {
                $_SESSION['status'] = $_POST['status'];
            }

            // print_r($_POST['sub_list']);
            if(isset($_SESSION['sub_list'])) {
                $sub_list = $_SESSION['sub_list'];
            } else {
                $string_sub_list = $_POST['sub_list'];
                if($string_sub_list != '') {
                    $sub_list = explode('|', $string_sub_list);
                } else {
                    $sub_list = array();
                }
            }
            // echo '<pre>';
            // print_r($sub_list);
            // echo '</pre>';
        ?>
        <h4 style="color: #0c6efd;">Sửa hồ sơ</h4>
        <div class="setting_ledger">
            <form action="" method="post">
                <input type="hidden" name="id_major" value="<?php if($_SESSION['id_major'] != '') {echo $_SESSION['id_major'];} ?>">
                <label class="setting_label" for="major_name">Tên ngành</label>
                <input class="setting_input" type="text" name="major_name" value="<?php if($_SESSION['major_name'] != '') echo $_SESSION['major_name'] ?>"><br>
                <label class="setting_label" style="vertical-align: top;" for="">Tổ hợp môn</label>
                <div style="display: inline-block; width: 320px; border: 1px solid black; min-height: 50px;">
                    <?php
                        if(count($sub_list) == 0) {
                            echo "<p style='margin: 0px; text-align: left;'>";
                            echo "Chưa có tổ hợp môn";
                            echo "</p>";
                        } else {
                            $arr_sb_list = array();
                            for($j=0; $j<count($arr_select_subject_combination); $j++) {
                                if(in_array($arr_select_subject_combination[$j][0], $sub_list)) {
                                    $arr_sb_list[] = $arr_select_subject_combination[$j];
                                }
                            }
                            for($j=0; $j<count($arr_sb_list); $j++) {
                                echo "<p style='margin: 0px; text-align: left;'>";
                                echo $arr_sb_list[$j][0] . " - " . $arr_sb_list[$j][1] . " - " . $arr_sb_list[$j][2] . " - " . $arr_sb_list[$j][3];
                                if($j < count($sub_list)-1) echo '<br>';
                                echo "</p>";
                            }
                        }
                    ?>
                </div>
                <div class="tmp_class"></div>
                <br>
                <label class="setting_label" for="diem_san">Điểm sàn</label>
                <input class="setting_input" type="text" name="diem_san" value="<?php if($_SESSION['diem_san'] != '') echo $_SESSION['diem_san'] ?>"><br>
                <label class="setting_label" for="time_start">Thời gian bắt đầu</label>
                <input class="setting_input" type="date" name="time_start" value="<?php if($_SESSION['time_start'] != '') echo $_SESSION['time_start'] ?>"><br>
                <label class="setting_label" for="time_start">Thời gian kết thúc</label>
                <input class="setting_input" type="date" name="time_end" value="<?php if($_SESSION['time_end'] != '') echo $_SESSION['time_end'] ?>"><br>
                <label class="setting_label" for="status">Trạng thái</label>
                <select class="setting_input" name="status" id="">
                    <option></option>
                    <option <?php if($_SESSION['status'] != '' && $_SESSION['status'] == 'Ẩn') echo 'selected' ?> value="Ẩn">Ẩn</option>
                    <option <?php if($_SESSION['status'] != '' && $_SESSION['status'] == 'Hiện')echo 'selected'?> value="Hiện">Hiện</option>
                </select><br>
                <?php echo '<input type="hidden" name="_token" value="'. $token .'"/>';?>
                <div class="setting_button">
                    <button type="submit" name="Change" class="btn btn-success">Sửa</button>
                    <button type="submit" name="delete" class="btn btn-danger">Xóa</button>
                    <button type="submit" name="cancel" class="btn btn-primary">Hủy</button>
                </div>
            </form>
            
            <div class="setting_sub">
                <form class="form_setting_sub" action="" method="post">
                    <div class="form_setting_sub_content">
                        <label for="insert_sub">Thêm tổ hợp môn: </label>
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
                    </div>
                    <input type="hidden" name="id_major" value="<?php if($_SESSION['id_major'] != '') echo $_SESSION['id_major'] ?>">
                    <input type="hidden" name="major_name" value="<?php if($_SESSION['major_name'] != '') echo $_SESSION['major_name'] ?>"><br>
                    <input type="hidden" name="diem_san" value="<?php if($_SESSION['diem_san'] != '') echo $_SESSION['diem_san'] ?>"><br>
                    <input type="hidden" name="time_start" value="<?php if($_SESSION['time_start'] != '') echo $_SESSION['time_start'] ?>"><br>
                    <input type="hidden" name="time_end" value="<?php if($_SESSION['time_end'] != '') echo $_SESSION['time_end'] ?>"><br>
                    <input type='hidden' name='sub_list' value='<?php echo $string_sub_list; ?>'>
                </form>
                
                <form class="form_setting_sub" action="" method="post">
                    <div class="form_setting_sub_content">
                        <label for="delete_sub">Xóa tổ hợp môn: </label>
                        <?php
                            if(count($sub_list) == 0) {
                                echo "Chưa có tổ hợp môn";
                            } else {
                                echo '<select name="delete_sub">
                                    <option></option>';
                                for($i=0; $i<count($sub_list); $i++) {
                                    echo '<option value="' . $sub_list[$i]  . '">' . $sub_list[$i]  . '</option>';
                                }
                                echo '</select>';
                                echo '<button type="submit" class="btn btn-warning" name="button_delete_sub">Xóa</button>';
                            }
                        ?>
                        <?php echo '<input type="hidden" name="_token" value="'. $token .'"/>'; ?>
                    </div>
                    <input type="hidden" name="id_major" value="<?php if($_SESSION['id_major'] != '') echo $_SESSION['id_major'] ?>">
                    <input type="hidden" name="major_name" value="<?php if($_SESSION['major_name'] != '') echo $_SESSION['major_name'] ?>"><br>
                    <input type="hidden" name="diem_san" value="<?php if($_SESSION['diem_san'] != '') echo $_SESSION['diem_san'] ?>"><br>
                    <input type="hidden" name="time_start" value="<?php if($_SESSION['time_start'] != '') echo $_SESSION['time_start'] ?>"><br>
                    <input type="hidden" name="time_end" value="<?php if($_SESSION['time_end'] != '') echo $_SESSION['time_end'] ?>"><br>
                    <input type='hidden' name='sub_list' value='<?php echo $string_sub_list; ?>'>
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
            if($_POST['insert_sub'] != '') {
                if(isset($_SESSION['sub_list'])) {
                    array_push($_SESSION['sub_list'], $_POST['insert_sub']);
                    sort($_SESSION['sub_list']);
                } else {
                    $_SESSION['sub_list'] = $sub_list;
                    array_push($_SESSION['sub_list'], $_POST['insert_sub']);
                    sort($_SESSION['sub_list']);
                }
            } else {
                echo "<script>alert('Bạn chưa chọn tổ hợp môn cần thêm!');</script>";
            }
            echo '<script>window.location="admin_sua_ho_so.php";</script>';
        }

        if(isset($_POST['button_delete_sub']) && isset($_SESSION['token']) && $_SESSION['token'] == $_POST['_token']) {
            if($_POST['delete_sub'] != '') {
                if(isset($_SESSION['sub_list'])) {
                    $tmp_arr = array();
                    foreach($_SESSION['sub_list'] as $sub) {
                        if($sub != $_POST['delete_sub']) {
                            array_push($tmp_arr, $sub);
                        }
                    }
                    $_SESSION['sub_list'] = $tmp_arr;
                    sort($_SESSION['sub_list']);
                } else {
                    $tmp_arr = array();
                    foreach($sub_list as $sub) {
                        if($sub != $_POST['delete_sub']) {
                            array_push($tmp_arr, $sub);
                        }
                    }
                    $_SESSION['sub_list'] = $tmp_arr;
                    sort($_SESSION['sub_list']);
                }
            } else {
                echo "<script>alert('Bạn chưa chọn tổ hợp môn cần thêm!');</script>";
            }
            echo '<script>window.location="admin_sua_ho_so.php";</script>';
        }

        if(isset($_POST['Change']) && isset($_SESSION['token']) && $_SESSION['token'] == $_POST['_token']) {

            if($_SESSION['major_name'] == '' || $_SESSION['diem_san'] == '' || $_SESSION['time_start'] == '' || $_SESSION['time_end'] == '' || $_SESSION['status'] == '') {
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

                        $sql_delete_chuyennganh = "DELETE FROM chuyennganh WHERE id_major=$id_major;";
                        mysqli_query($connect, $sql_delete_chuyennganh);

                        foreach($sub_list as $value) {
                            $sql_insert_chuyennganh = "INSERT INTO chuyennganh VALUES($id_major, '$value')";
                            mysqli_query($connect, $sql_insert_chuyennganh);
                        }
                        unset($_SESSION['id_major']);
                        unset($_SESSION['major_name']);
                        unset($_SESSION['diem_san']);
                        unset($_SESSION['time_start']);
                        unset($_SESSION['time_end']);
                        unset($_SESSION['status']);
                        unset($_SESSION['sub_list']);
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

            unset($_SESSION['id_major']);
            unset($_SESSION['major_name']);
            unset($_SESSION['diem_san']);
            unset($_SESSION['time_start']);
            unset($_SESSION['time_end']);
            unset($_SESSION['status']);
            unset($_SESSION['sub_list']);

            echo '<script>window.location="admin_tao_ho_so.php";</script>';
        }

        if(isset($_POST['cancel']) && isset($_SESSION['token']) && $_SESSION['token'] == $_POST['_token']) {
            unset($_SESSION['id_major']);
            unset($_SESSION['major_name']);
            unset($_SESSION['diem_san']);
            unset($_SESSION['time_start']);
            unset($_SESSION['time_end']);
            unset($_SESSION['status']);
            unset($_SESSION['sub_list']);

            echo '<script>window.location="admin_tao_ho_so.php";</script>';
        }
    ?>

	<?php 
        $_SESSION['token'] = $token;
		include './layouts/footer.php';
	?>
</div>
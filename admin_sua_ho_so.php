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
?>

<?php
    $query_select_subject_combination = select('subject_combination', '*', '');
    $result_select_subject_combination = mysqli_num_rows($query_select_subject_combination);
    $arr_select_subject_combination = mysqli_fetch_all($query_select_subject_combination);

    $sb1 = $sb2 = $sb3 = "";
    foreach ($arr_select_subject_combination as $arr) {
        if(in_array($_POST['id_SB'], $arr)) {
            $sb1 = $arr[1];
            $sb2 = $arr[2];
            $sb3 = $arr[3];
        }
    }
?>

<link rel="stylesheet" href="./assets/css/admin_sua_ho_so.css">
<div style="display: block; width: 100%;">
	<div class="container mt-4" style="width: max-content; margin-left: auto; margin-right: auto;">
	<!-- Page content -->
        <h4 style="color: #0c6efd;">Sửa hồ sơ</h4>
        <div class="setting_ledger">
            <form action="" method="post">
                <input type="hidden" name="id_major" value="<?php if($_POST['id_major'] != '') {echo $_POST['id_major'];} ?>">
                <input type="hidden" name="id_SB" value="<?php if($_POST['id_SB'] != '') {echo $_POST['id_SB'];} ?>">
                <input type="hidden" name="major_name" value="<?php if($_POST['major_name'] != '') echo $_POST['major_name'] ?>"><br>
                <label class="setting_label" for="major_name">Tên ngành</label>
                <input disabled style="width: 300px;" class="setting_input" type="text" name="major_name" value="<?php if($_POST['major_name'] != '') echo $_POST['major_name'] ?>"><br>
                <label class="setting_label" style="vertical-align: top;" for="">Tổ hợp môn</label>
                <input disabled style="width: 300px;" class="setting_input" type="text" value="<?php if($_POST['id_SB'] != '') echo $_POST['id_SB'] . " - " . $sb1 . ", " . $sb2 . ", " . $sb3 ?>"><br>
                <label class="setting_label" for="diem_san">Điểm sàn</label>
                <input class="setting_input" type="text" name="diem_san" value="<?php if($_POST['diem_san'] != '') echo $_POST['diem_san'] ?>"><br>
                <label class="setting_label" for="time_start">Thời gian bắt đầu</label>
                <input class="setting_input" type="date" name="time_start" value="<?php if($_POST['time_start'] != '') echo $_POST['time_start'] ?>"><br>
                <label class="setting_label" for="time_start">Thời gian kết thúc</label>
                <input class="setting_input" type="date" name="time_end" value="<?php if($_POST['time_end'] != '') echo $_POST['time_end'] ?>"><br>
                <label class="setting_label" for="status">Trạng thái</label>
                <select class="setting_input" name="status" id="">
                    <option></option>
                    <option <?php if($_POST['status'] != '' && $_POST['status'] == 'Hiện') echo 'selected'?> value="Hiện">Hiện</option>
                    <option <?php if($_POST['status'] != '' && $_POST['status'] == 'Ẩn') echo 'selected' ?> value="Ẩn">Ẩn</option>
                </select><br>
                <?php echo '<input type="hidden" name="_token" value="'. $token .'"/>';?>
                <div class="setting_button">
                    <button type="submit" name="Change" class="btn btn-success">Sửa</button>
                    <button type="submit" name="delete" class="btn btn-danger">Xóa</button>
                    <button type="submit" name="cancel" class="btn btn-primary">Hủy</button>
                </div>
            </form>
        </div>
	<!-- End Page content -->
	</div>
    <?php
        if(isset($_POST['Change']) && isset($_SESSION['token']) && $_SESSION['token'] == $_POST['_token']) {
            if($_POST['major_name'] == '' || $_POST['diem_san'] == '' || $_POST['time_start'] == '' || $_POST['time_end'] == '' || $_POST['status'] == '') {
                echo "<script>alert('Bạn chưa nhập đầy đủ thông tin!');</script>";
            } else {
                $id_major = $_POST['id_major'];
                $id_SB = $_POST['id_SB'];
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
                        update('chuyennganh', ['time_start' => $time_start, 'time_end' => $time_end, 'diem_san' => $diem_san, 'status' => $status],
                            ['id_major' => $id_major, 'id_SB' => $id_SB]);

                        echo "<script>alert('Đã sửa hồ sơ thành công!');</script>";
                        echo '<script>window.location="admin_tao_ho_so.php";</script>';
                    }
                } 
            }
        }

        if(isset($_POST['delete']) && isset($_SESSION['token']) && $_SESSION['token'] == $_POST['_token']) {
            $id_major = $_POST['id_major'];
            $id_SB = $_POST['id_SB'];

            $check_delete_chuyennganh = delete('chuyennganh', ['id_major' => $id_major, 'id_SB' => $id_SB]);
            var_dump($check_delete_chuyennganh);

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
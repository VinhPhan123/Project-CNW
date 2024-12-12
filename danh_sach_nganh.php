<?php 
    include './layouts/header.php';
    include './XuLyPhien/all.php';
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
    $query_select_subject_combination = select('subject_combination', '*', '');
    $result_select_subject_combination = mysqli_num_rows($query_select_subject_combination);
    $arr_select_subject_combination = mysqli_fetch_all($query_select_subject_combination);
    
?>

<link rel="stylesheet" href="./assets/css/danh_sach_nganh.css">
<div style="display: block; width: 100%;">
	
	<div class="container mt-4" style="width: max-content; margin-left: auto; margin-right: auto;">
	<!-- Page content -->
        <?php
            if($_SESSION['role'] == "admin") {
                echo "<h4 style='display: block; width: fit-content; color: #0c6efd;'>Thêm chuyên ngành</h4>
                    <form action='' method='post' style='position: relative;'>
                        <label for='major_name'>Tên chuyên ngành</label><br>
                        <input type='text' name='major_name' id=''>
                        <input type='hidden' name='_token' value=" . $token . ">
                        <button type='submit' name='submit_major_name' class='btn btn-primary'>Thêm</button>
                    </form>";
            }
        ?>
        <?php
            if(isset($_POST['submit_major_name']) && $_SESSION['token'] == $_POST['_token']) {
                $major_name = $_POST['major_name'];

                $query_select_major_name = select('majors', '*', ['major_name' => $major_name]);
                $result_select_major_name = mysqli_num_rows($query_select_major_name);

                if($result_select_major_name > 0) {
                    echo "<script>alert('Ngành này đã tồn tại');</script>";
                } else {
                    $query_insert_major_name = insert('majors', ['major_name' => $major_name]);

                    if($query_insert_major_name) {
                        echo "<script>alert('Đã thêm ngành thành công!');</script>";
                    } else {
                        echo "<script>alert('Thêm ngành thất bại!');</script>";
                    }
                }

            }
        ?>
        <h4 style="color: #0c6efd;">Danh sách ngành</h4>
        <?php

            $query_major = select('majors', '*', '');
            $result_major = mysqli_num_rows($query_major);
            if($result_major == 0) {
                echo "Chưa có ngành nào";
            } else {
                $arr_major = mysqli_fetch_all($query_major);

                echo "
                <table>
                    <tr>
                        <th id='stt'>STT</th>
                        <th id='major_name'>Tên ngành</th>
                        <th id='sub'>Tổ hợp môn</th>";
                if($_SESSION['role'] == "admin") {
                    echo "<th id='insert_button'>Thêm tổ hợp</th>
                        <th id='delete_button'>Xóa tổ hợp</th>
                        <th id='delete_button'>Xóa ngành</th>";
                }
                echo "</tr>";
                for($i=0; $i<$result_major; $i++) {    
                    $tmp = $i+1;
                    echo "<tr>";
                    echo "<td id='stt'>" . $tmp . "</td>";
                    echo "<td id='major_name'>" . $arr_major[$i][1] . "</td>";
                    echo "<td id='sub' style='text-align: left;'>";
                        $sql_select_chuyennganh = "SELECT * FROM chuyennganh WHERE id_major = " . $arr_major[$i][0] . " ORDER BY id_SB;";
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
                            $check = false;
                            for($j=0; $j<$result_select_chuyennganh; $j++) {
                                if($arr_select_chuyennganh[$j][5] == "Hiện") {
                                    $check = true;
                                    break;
                                }
                            }
                            for($j=0; $j<$result_select_chuyennganh; $j++) {
                                if($arr_select_chuyennganh[$j][5] == "Hiện") {
                                    echo $arr_select_chuyennganh[$j][1] . " - " . $arr_select_subject_combination[$j][1] . " - " . $arr_select_subject_combination[$j][2] . " - " . $arr_select_subject_combination[$j][3] . " | ";
                                    if(strtotime($date_now) < strtotime($arr_select_chuyennganh[$j][2])) {
                                        echo "<p style='color:#1f96f6; font-style: italic; display: inline;'>(Chưa mở)</p>";
                                    } else {
                                        if(isset($arr_select_chuyennganh[$j][3])) {
                                            if(strtotime($date_now) < strtotime($arr_select_chuyennganh[$j][3])) {
                                                echo "<p style='color:#79d28d; font-style: italic; display: inline;'>(Còn hạn)</p>";
                                            } else {
                                                echo "<p style='color:#e13647; font-style: italic; display: inline;'>(Hết hạn)</p>";
                                            }
                                        }
                                        if($j < $result_select_chuyennganh-1) echo '<br>';
                                    }
                                } else {
                                    if($_SESSION['role'] == "admin") {
                                        echo $arr_select_chuyennganh[$j][1] . " - " . $arr_select_subject_combination[$j][1] . " - " . $arr_select_subject_combination[$j][2] . " - " . $arr_select_subject_combination[$j][3] . " | ";
                                        echo "<p style='color:#e13647; font-style: italic; display: inline;'>(Ẩn)</p>";
                                        if($j < $result_select_chuyennganh-1) echo '<br>';
                                    }
                                }
                            }
                            if($_SESSION['role'] != "admin") {
                                if(!$check) {
                                    echo "Chưa có tổ hợp môn";
                                }
                            }
                        }
                    echo "</td>";
                    if($_SESSION['role'] == "admin") {
                        $tmp = $i+1;
                        if(empty($tmp_arr_select_chuyennganh)) {
                            echo '<td id="insert_button" sytle="display: flex;">
                                <form action="" method="post">
                                <input type="hidden" name="row_id" value="' . $arr_major[$i][0] . '">
                                <select id="insert-tohop" name="insert_tohop">
                                    <option></option>';                                
                                        for($j=0; $j<$result_select_subject_combination; $j++) {
                                            echo '<option value="' . $arr_select_subject_combination[$j][0] .'">' . $arr_select_subject_combination[$j][0] . '</option>';
                                        }
                            echo '</select>';
                            echo '<button id="insert-button" type="submit" class="btn btn-success" name="insert">Thêm</button>';
                            echo ' <input type="hidden" name="_token" value="'. $token .'"/></form>';                        
                        } else {
                            if($result_select_subject_combination != count($tmp_arr_select_chuyennganh)) {
                                echo '<td id="insert_button" sytle="display: flex;">
                                    <form action="" method="post">
                                    <input type="hidden" name="row_id" value="' . $arr_major[$i][0] . '">
                                    <select id="insert-tohop" name="insert_tohop">
                                        <option></option>';                                
                                            for($j=0; $j<$result_select_subject_combination; $j++) {
                                                if(!in_array($arr_select_subject_combination[$j][0], $tmp_arr_select_chuyennganh)) {
                                                    echo '<option value="' . $arr_select_subject_combination[$j][0] .'">' . $arr_select_subject_combination[$j][0] . '</option>';
                                                }
                                            }
                                    echo '</select>';
                                    echo '<button id="insert-button" type="submit" class="btn btn-success" name="insert">Thêm</button>';
                                    echo ' <input type="hidden" name="_token" value="'. $token .'"/></form>';
                            } else {
                                echo "<td>Đã hết tổ hợp môn có thể thêm vào ngành này!</td>";
                            }
                        }
                        echo "</td>";
                        if($result_select_chuyennganh > 0) {
                            echo '<td id="delete_button" sytle="display: flex;">
                            <form action="" method="post">
                            <input type="hidden" name="row_id" value="' . $arr_major[$i][0] . '">
                            <select id="delete-tohop" name="delete_tohop">
                                <option></option>';
                                    for($j=0; $j<$result_select_chuyennganh; $j++) {
                                        echo '<option value="' . $tmp_arr_select_chuyennganh[$j] .'">' . $tmp_arr_select_chuyennganh[$j] . '</option>';
                                    }
                            echo '</select>';
                            echo '<button id="delete-button" type="submit" class="btn btn-warning" name="delete">Xóa</button>';
                            echo '<input type="hidden" name="_token" value="'. $token .'"/></form>';
                            echo "</td>";
                        } else {
                            echo "<td>Chưa có tổ hợp môn</td>";
                        }
                        echo "<td>";
                        
                        echo '<form action="" method="post">
                                <input type="hidden" name="row_id" value="' . $arr_major[$i][0] . '">';
                        echo '<button type="submit" class="btn btn-danger" name="delete_major_alert">Xóa ngành</button>';
                        echo ' <input type="hidden" name="_token" value="'. $token .'"/></form>';
                        echo "</td>";
                        $tmp_arr_select_chuyennganh = [];
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
        ?>
        <?php
            if(isset($_POST['delete_major_alert']) && isset($_SESSION['token']) && $_SESSION['token'] == $_POST['_token']) {
                echo '
                    <div style="position: fixed; z-index: 10; left: 0px; top: 0px; height: 100%; width: 100%;">
                        <div style="position: absolute; left: 0px; top: 0px; opacity: 20%; height: 100%; width: 100%; background-color: black;"></div>
                        <div style="position: absolute; left: 35%; width: 30%; margin-left: auto; margin-right: auto; margin-top: 10%; background-color: white; padding: 10px; border-radius: 10px; box-shadow: 0px 0px 10px px rgb(164, 164, 164);">
                            <h5>Thông Báo</h5>
                            <hr>
                            <div style="width: 100%; text-align: center;">Bạn muốn xóa ngành?</div>
                            <div style="text-align: center; margin-top: 30px;">';
                    echo '<form style="margin-left: auto; margin-right: auto; width: 100px; display: inline-block; margin-left: auto; margin-right: auto;" action="" method="post">
                        <input type="hidden" name="row_id" value="' . $_POST['row_id'] . '">';
                    echo '<button style="margin-left: auto; margin-right: auto; width: 100px; display: inline-block; margin-left: auto; margin-right: auto;" type="submit" class="btn btn-danger" name="delete_major">Xóa</button>';
                    echo '<input type="hidden" name="_token" value="'. $token .'"/>';
                    echo'<button type="submit" style="color: #0b5ed7; background-color: white; width: 100px; display: inline-block ;margin-left: 20px; margin-right: auto; " class="btn btn-primary">Hủy</button></form>
                            </div>
                        </div>
                    </div>';
            }

            if(isset($_POST['delete_major']) && isset($_SESSION['token']) && $_SESSION['token'] == $_POST['_token']) {
                $id_major = $_POST['row_id'];
                $check_delete_chuyennganh = delete('chuyennganh', ['id_major' => $id_major]);
                $check_delete_majors = delete('majors', ['id_major' => $id_major]);
                if($check_delete_chuyennganh && $check_delete_majors) {
                    echo '<script>window.location="danh_sach_nganh.php";</script>';
                } else {
                    ?>
                        <script>
                            alert("Đã có học sinh nộp hồ sơ, không thể xóa chuyên ngành!");
                        </script>
                    <?php
                    echo '<script>window.location="danh_sach_nganh.php";</script>';
                }
            }

            if(isset($_POST['insert']) && isset($_SESSION['token']) && $_SESSION['token'] == $_POST['_token']) {
                $id_major = $_POST['row_id'];
                $id_SB = $_POST['insert_tohop'];

                if($id_SB == '') {
                    echo "<script>alert('Bạn chưa chọn tổ hợp môn!');</script>";
                } else {
                    $query_select_chuyennganh = select('chuyennganh', ['id_SB'], ['id_major' => $id_major]);
                    $arr_select_chuyennganh = mysqli_fetch_all($query_select_chuyennganh);

                    $tmp_arr = array();
                    for($i= 0; $i<count($arr_select_chuyennganh); $i++) {
                        array_push($tmp_arr, $arr_select_chuyennganh[$i][0]);
                    }
                    if(in_array($id_SB, $tmp_arr)) {
                        echo "<script>alert('Tổ hợp môn này đã tồn tại trong mã ngành!');</script>";
                    } else {
                        insert('chuyennganh', ['id_major' => $id_major, 'id_SB' => $id_SB, 'status' => 'Ẩn']);
                        echo "<script>alert('Đã thêm tổ hợp môn thành công!');</script>";
                        echo '<script>window.location="danh_sach_nganh.php";</script>';
                    }
                }
            }
            
            if(isset($_POST['delete']) && isset($_SESSION['token']) && $_SESSION['token'] == $_POST['_token']) {
                $id_major = $_POST['row_id'];
                $id_SB = $_POST['delete_tohop'];

                if($id_SB == '') {
                    echo "<script>alert('Bạn chưa chọn tổ hợp môn!');</script>";
                } else {
                    delete('chuyennganh', ['id_major'=>$id_major, 'id_SB'=>$id_SB]);
                    echo "<script>alert('Đã xóa tổ hợp môn thành công!');</script>";
                    echo '<script>window.location="danh_sach_nganh.php";</script>';
                }
            }
        ?>
	<!-- End Page content -->
	</div>
    
	<?php 
        $_SESSION['token'] = $token;
		include './layouts/footer.php';
	?>
</div>
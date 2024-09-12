<?php 
    include './layouts/header.php';
?>
<?php
    $m=0;
    $n=0;
    $token = md5(uniqid());
?>

<?php 
    // nếu chưa đăng nhập thì out
    $sql = "SELECT * FROM admins;";
    $res = mysqli_query($connect, $sql);
    $query_username = mysqli_fetch_array($res);
    $username_admin = $query_username['username'];
    if($_SESSION['taiKhoan'] != $username_admin){
        header("location: logout.php");
    }
?>


<?php 
    $s1 = "SELECT * FROM subject_combination;";
    $query_combine = mysqli_query($connect, $s1);

    $combines = array();

    while($row=mysqli_fetch_array($query_combine)){
        array_push($combines, $row['id_SB']);
        // echo $row['id_SB'] . '-' . $row['sub_1'] . '-' . $row['sub_2'] . '-' . $row['sub_3'] . '<br>';
    }
?>

<?php 
    $s2 = "SELECT * FROM chuyennganh;";
    $query_major = mysqli_query($connect, $s2);

    $majors = array();

    while($row=mysqli_fetch_array($query_major)){
        array_push($majors, $row['ten_chuyen_nganh']);
        // echo $row['id_SB'] . '-' . $row['sub_1'] . '-' . $row['sub_2'] . '-' . $row['sub_3'] . '<br>';
    }
?>

<?php
    // nếu chuyên ngành đã xóa hết tổ hợp thì xóa chuyên ngành đó khỏi chuyennganh_array
    $chuyennganh_array = isset($_SESSION['chuyennganh_array']) ? $_SESSION['chuyennganh_array'] : array();
    $status_chuyennganh = isset($_SESSION['status_chuyennganh']) ? $_SESSION['status_chuyennganh'] : array();


    // tạo một mảng để lưu các khóa cần xóa
    $keysToRemove = array();

    // Lặp qua mảng và lưu các khóa của phần tử có tổ hợp rỗng
    foreach ($chuyennganh_array as $chuyennganh => $toHop) {
        if (empty($toHop)) {
            $keysToRemove[] = $chuyennganh;
        }
    }

    // Xóa các phần tử có tổ hợp rỗng sau khi hoàn thành lặp
    foreach ($keysToRemove as $key) {
        unset($chuyennganh_array[$key]);
        unset($status_chuyennganh[$key]);
    }

    // Cập nhật mảng trong session
    $_SESSION['chuyennganh_array'] = $chuyennganh_array;
    $_SESSION['status_chuyennganh'] = $status_chuyennganh;


    // in ra mảng sau khi xóa
    // echo "Mảng sau khi xóa các tập rỗng:<br>";
    // print_r($chuyennganh_array);
?>

<?php
    $j = 0;
    $chuyennganh_array = isset($_SESSION['chuyennganh_array']) ? $_SESSION['chuyennganh_array'] : array();
    // $tohop_array = isset($_SESSION['tohop_array']) ? $_SESSION['tohop_array'] : array();
    // tạo thêm 1 array để lưu status của chuyennganh
    $status_chuyennganh = isset($_SESSION['status_chuyennganh']) ? $_SESSION['status_chuyennganh'] : array();

    // Xử lí phần thêm dữ liệu vào bảng khi bấm submit
    if (isset($_POST['them']) && $_SESSION['token'] == $_POST['_token']) {
        $chuyenNganh = $_POST['chuyennganh'];
        $toHop = $_POST['tohop'];
        if($chuyenNganh =='' || $toHop == ''){
           // 
        } else {
            // Nếu chuyenNganh đã tồn tại trong mảng thì lấy giá trị hiện tại ra, nếu không thì tạo mới
            if (!isset($chuyennganh_array[$chuyenNganh])) {
                $chuyennganh_array[$chuyenNganh] = array();
            }
    
            // Thêm toHop vào mảng của chuyenNganh nếu toHop đó chưa có trong chuyenNganh
            if(!in_array($toHop, $chuyennganh_array[$chuyenNganh])){
                array_push($chuyennganh_array[$chuyenNganh], $toHop);
            }
    
            // set status chuyenNganh 0-hủy, 1-chưa duyệt, 2-đã duyệt
            $status_chuyennganh[$chuyenNganh] = 1;
            
            // Cập nhật session
            $_SESSION['chuyennganh_array'] = $chuyennganh_array;
            $_SESSION['status_chuyennganh'] = $status_chuyennganh;
        }
        header('Location: admin_tao_ho_so.php'); 
        exit(); 
    }

    // print_r($_SESSION['chuyennganh_array']);
    // echo '<br>';
    // print_r($_SESSION['status_chuyennganh']);

    
?>


<?php
    // xử lí phần access, delete
    if(isset($_POST['access']) && $_SESSION['token'] == $_POST['_token']){
        $chuyennganh_array = $_SESSION['chuyennganh_array'];
        $chuyennganh_at_row = $_POST['row_id'];

        $string_tohop = implode(" - ", $chuyennganh_array[$chuyennganh_at_row]);
        // echo $string_tohop;

        $s0 = "SELECT * FROM majors WHERE major = '$chuyennganh_at_row';";
        $result0 = mysqli_query($connect, $s0);
        $c = mysqli_num_rows($result0); 
        // kiểm tra major đã tồn tại trong bảng majors chưa, nếu chưa thì insert - rồi thì update
        if($c == 0){
            $s1 = "INSERT INTO majors(major, subject_combination_id_list) VALUES ('$chuyennganh_at_row', '$string_tohop');";
            mysqli_query($connect, $s1);
        } else {
            $s2 = "UPDATE majors
                    SET subject_combination_id_list = '$string_tohop'
                    WHERE major = '$chuyennganh_at_row';";
            mysqli_query($connect, $s2);
        }

        $_SESSION['status_chuyennganh'][$chuyennganh_at_row] = 2;

        // reload lại trang
        header('Location: admin_tao_ho_so.php'); 
        exit();
    }

    if(isset($_POST['delete'])){
        $chuyennganh_array = $_SESSION['chuyennganh_array'];
        $chuyennganh_at_row = $_POST['row_id'];

        $_SESSION['status_chuyennganh'][$chuyennganh_at_row] = 0;

        // reload lại trang
        header('Location: admin_tao_ho_so.php'); 
        exit();
    }
?>

<?php
    // kiểm tra xem có chuyên ngành nào chưa duyệt không
    $count_status = 0;
    if(isset($_SESSION['status_chuyennganh'])){
        $status_chuyennganh = $_SESSION['status_chuyennganh'];
        foreach($status_chuyennganh as $chuyenNganh => $status){
            if($status == 1){
                $count_status += 1;
            }
        }
        // echo $count_status;
    };
?>


<?php
    // Xử lý phần modify, xóa tổ hợp được chọn trong chuyên ngành tương ứng
    if (isset($_POST['modify']) && isset($_SESSION['token']) && $_SESSION['token'] == $_POST['_token']) {
        $chuyennganh_array = isset($_SESSION['chuyennganh_array']) ? $_SESSION['chuyennganh_array'] : array();
        
        $chuyennganh_at_row_id = $_POST['row_id'];
        $tohop_at_row_id = isset($chuyennganh_array[$chuyennganh_at_row_id]) ? $chuyennganh_array[$chuyennganh_at_row_id] : array();
        
        // In ra mảng tohop_at_row_id
        print_r($tohop_at_row_id);

        // index tổ hợp muốn xóa trong mảng tohop_at_row_id
        $delete_tohop = $_POST['sua_tohop'];
        $index = array_search($delete_tohop, $tohop_at_row_id);
        
        // Kiểm tra xem phần tử có tồn tại không trước khi xóa
        if ($index !== false) {
            // xóa phần tử tại index (phần tử delete_tohop)
            unset($tohop_at_row_id[$index]);
            
            // đặt lại các chỉ số của mảng tohop_at_row_id
            $tohop_at_row_id = array_values($tohop_at_row_id);
            
            // cập nhật lại mảng chuyennganh_array
            $chuyennganh_array[$chuyennganh_at_row_id] = $tohop_at_row_id;
            
            // lưu vào session
            $_SESSION['chuyennganh_array'] = $chuyennganh_array;
        }

        header('Location: admin_tao_ho_so.php'); 
        exit();
    }
    
    // echo "<br>";
    // echo "Chuyên ngành : " . '<br>';
    // foreach($chuyennganh_array as $chuyenNganh => $toHop){
    //     echo $chuyenNganh . '<br>';
    //     print_r($toHop);
    //     echo "<br>";
    // }
?>

<div style="display: flex; justify-content: center;">

<?php 
    if(isset($_SESSION['role'])) {
		include './layouts/menu.php';
	}
?>

<?php
    // số lượng phần tử trong chuyennganh_array
    $chuyennganh_array = isset($_SESSION['chuyennganh_array']) ? $_SESSION['chuyennganh_array'] : array();
    $count_elements = count($chuyennganh_array);
    // echo $count_elements;   
?>


<div class="container" style="display: block; width: 100%;">
	
	<!-- Page content -->
    <form action="" method="post">
        <div class="container_head">
            <div id="majors">
                <div class="title-header" style="font-weight: bold; font-size: 20px;">Chuyên ngành xét tuyển</div>
                <i class="menu-icon ti-menu-alt"></i>
                <select name="chuyennganh" id="major_list" required>
                    <option></option>
                    <?php foreach($majors as $major) { ?>
                        <?php # echo '<input type="hidden" name="row_id" value="' . $m . '">' ?>
                        <?php echo '<option  value="' . $major .'">' . $major . '</option>'?>
                        <?php } ?>
                </select><br>
                <div class="error"><?php echo isset($error_major) ? $error_major : ""?></div>
            </div>
    
            <div id="combines">
                <div class="title-header" style="font-weight: bold; font-size: 20px;">Tổ hợp xét tuyển</div>
                <i class="menu-icon ti-menu-alt"></i>
                <select name="tohop" id="major_list" required>
                    <option></option>
                    <?php foreach($combines as $combine) { ?>
                        <?php # echo '<input type="hidden" name="row_id" value="' . $n . '">' ?>
                        <?php echo '<option value="' . $combine .'">' . $combine . '</option>'?>
                        <?php } ?>
                </select>
                <div class="error"><?php echo isset($error_combine) ? $error_combine : ""?></div>
            </div>

            <div id="btn_submit">
                <input type="hidden" name="_token" value="<?php echo $token ?>">
                <?php $_SESSION['token'] = $token ?>
                <input type="submit" class="btn btn-primary" value="Thêm" name="them" id="btnAdd"/>
            </div>
        </div>
    </form>

<?php 
    // if(isset($_SESSION['status_chuyennganh']) && isset($_SESSION['chuyennganh_array'])){
    //     echo "<br>";
    //     echo "Chuyên ngành : " . '<br>';
    //     $chuyennganh_array = $_SESSION['chuyennganh_array'];
    //     foreach($chuyennganh_array as $chuyenNganh => $toHop){
    //         echo $chuyenNganh . '<br>';
    //         print_r($toHop);
    //         echo "<br>";
    //     }
    
    //     echo "<br>";
    //     $status_chuyennganh = $_SESSION['status_chuyennganh'];
    //     foreach($status_chuyennganh as $chuyennganh => $status){
    //         echo $chuyennganh . ' - ' . $status . '<br>';
    //     }
    // }
?>

<?php 
    // echo $count_status . '-' . $count_elements;
    if($count_status >= 1 && $count_elements >= 1){
        echo '<div class="container_body">
                <form action="" method="post">
                    <table>
                        <th>STT</th>
                        <th>Chuyên ngành xét tuyển</th>
                        <th>Tổ hợp xét tuyển</th>
                        <th>Access</th>
                        <th>Delete</th>
                        <th>Modify</th>'
                        ?>
                        <?php $chuyennganh_array = $_SESSION['chuyennganh_array']; ?>
                        <?php
                            foreach($chuyennganh_array as $chuyenNganh => $toHop){
                                if($status_chuyennganh[$chuyenNganh] == 1){
                                    echo  '<tr id="id_' . $j . '">';
                                        echo '<td>' . $j . '</td>';
                                        echo '<td>' . $chuyenNganh . '</td>';
                                        ?>

                                        <?php 
                                        $k = implode(" - ", $toHop);
                                        echo '<td>' . $k . '</td>';

                                        echo '<td>
                                                <form action="" method="post">
                                                    <input type="hidden" name="row_id" value="' . $chuyenNganh . '">
                                                    <button type="submit" class="btn btn-primary" name="access">Click</button>
                                                    <input type="hidden" name="_token" value="'?><?php echo $token .'"/>' ?>
                                                    <?php $_SESSION['token'] = $token; ?>
                                                <?php echo '</form>
                                            </td>';
                                            echo '<td>
                                                    <form action="" method="post">
                                                        <input type="hidden" name="row_id" value="' . $chuyenNganh . '">
                                                        <button type="submit" class="btn btn-danger" name="delete">Click</button>
                                                    </form>
                                                </td>';

                                        echo '<td>
                                            <form class="form_modify"  action="" method="post">
                                                <input type="hidden" name="row_id" value="' . $chuyenNganh . '">
                                                <select class="select_modify" name="sua_tohop">
                                                    <option></option>'?>
                                                    <?php
                                                        $tohop_at_chuyennganh = $chuyennganh_array[$chuyenNganh];
                                                    ?>
                                                    <?php foreach($tohop_at_chuyennganh as $c) { ?>
                                                        <?php echo '<option value="' . $c .'">' . $c . '</option>'?>
                                                    <?php } ?>
                                                <?php
                                                echo '</select>';
                                                echo '<button type="submit" class="btn_modify btn btn-warning" name="modify">Delete</button>';
                                                echo ' <input type="hidden" name="_token" value="'?><?php echo $token .'"/>' ?>
                                                <?php $_SESSION['token'] = $token; 
                                            echo '</form>';
                                        $j+=1;
                                    echo '</tr>';
                                }
                            }
                    ?>
                    </table>
                </form>
            </div>
<?php 
    } else {
        ?>
        <h2 style="text-align: center; margin-top: 30px;">Chưa có yêu cầu duyệt chuyên ngành !</h2>
        <?php
    }
?>

	<?php 
		// include './layouts/footer.php';
	?>
</div>
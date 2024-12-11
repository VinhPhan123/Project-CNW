<?php 
   include './layouts/header.php';
?>

<script>
    // sau 120s (thời hạn mã code là 120s) reload lại trang để kiểm tra email bị admin deny hay không
    setTimeout(function() {
        window.location.href="xacthuc.php";
    }, 120000);
</script>

<?php
    if(!isset($_SESSION['taiKhoan'])){
        ?>
        <script>
            alert("Bạn không được phép điều hướng tới trang này khi chưa đăng ký!");
            window.location.href="index.php";
        </script>
        <?php
    }

    $email = $_SESSION['email'];

    $check_email_exist = checkEmailExist($email);

    if($check_email_exist){
       ?>
        <script>
            alert("Email đã được đăng ký, hãy chọn email khác");
            window.location.href="dangky.php";
        </script>
       <?php
    } else {
        $hoVaTen = $_SESSION['hoVaTen'];
        $taiKhoan = $_SESSION['taiKhoan'];
        $matKhau = $_SESSION['matKhau'];
        $gioiTinh = $_SESSION['gioiTinh'];
        $ngaySinh = $_SESSION['ngaySinh'];
        $diaChi = $_SESSION['diaChi'];
        $soDienThoai = $_SESSION['soDienThoai'];
        $email = $_SESSION['email'];
    
    
        // 0-huy, 1-chua duyet, 2-duyet
        $s1 = "INSERT INTO guest(teacher_email, status) VALUES ('$email', 1);";
        try {
            $result = mysqli_query($connect, $s1);
        } catch(Exception $e) {
            echo $e;
        }
    
    
        // lấy ra các code còn hạn trong bảng gen_code
        $array_codes = array();
        $s2 = "SELECT code FROM gen_code WHERE NOW() <= expiry_time;";
        $query_code = mysqli_query($connect, $s2);
        while($row = mysqli_fetch_array($query_code)) {
            echo $row['code'] . '<br>';
            array_push($array_codes, $row['code']);
        }
    }

    

    if(isset($_POST['submit'])){
        $verify_code = $_POST['verifyCode'];
        if(in_array($verify_code, $array_codes)){

            $data = [
                'username' => $taiKhoan,
                'password' => $matKhau,
                'fullname' => $hoVaTen,
                'ngaysinh' => $ngaySinh,
                'phone_number' => $soDienThoai,
                'gender' => $gioiTinh,
                'address' => $diaChi,
                'email' => $email,
            ];
            $check_insert = insert('teachers', $data);

            $value = [
                'status' => 0
            ];
            $condition = [
                'teacher_email' => $email
            ];
            $check_update = update('guest', $value, $condition);

            $_SESSION['role'] = "teacher";
            ?>
            <script>
                alert("Xác minh thành công");
                window.location.href="index.php";
            </script>
            <?php
        } else {
            ?>
            <script>
                alert("Passcode không chính xác hoặc đã quá thời hạn, mời bạn quay lại trang đăng ký !");
                window.location.href="dangky.php";
            </script>
            <?php
            echo "error";
        }
    }

?>


<?php
    // kiểm tra nếu email không được chấp nhận 
    $condition = [
        'teacher_email' => $email
    ];
    $query_mail = select('guest', '*', $condition);

    $kq = mysqli_fetch_array($query_mail);
    $status_mail = $kq['status'];

    if($status_mail == 0){
        // xóa email đã gửi yêu cầu đăng ký giáo viên trong bảng guest vì có thể đăng ký lại với email đó và được admin phê duyệt
        $condition = [
            'teacher_email' => $email
        ];
        $check_delete = delete('guest', $condition);
        ?>
        <script>
            alert("Yêu cầu đăng ký tài khoản giáo viên của bạn không được chấp nhận !");
            window.location.href="index.php";
        </script>
        <?php
    }
?>




<h1 style="text-align: center;"> Tài khoản của bạn đang chờ được duyệt </h1>

<div class="container">
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
        <div>Nhập mã xác thực đã gửi tới Gmail</div>
        <input type="text" name="verifyCode">
        <input type="submit" value="Xác thực" name="submit">
    </form>
</div>


<?php 
   include './layouts/footer.php';
?>
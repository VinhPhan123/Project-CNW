<?php 
   include './laytouts/header.php';
   use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/PHPMailer/src/Exception.php';
    require 'vendor/PHPMailer/src/PHPMailer.php';
    require 'vendor/PHPMailer/src/SMTP.php';
?>


<?php 

    $sql = "SELECT email FROM admins;";
	$query = mysqli_query($connect, $sql);
	$result = mysqli_fetch_assoc($query);

	$emailAdmin = $result['email'];

    $hoVaTen = $_SESSION['hoVaTen'];
    $taiKhoan = $_SESSION['taiKhoan'];
    $matKhau = $_SESSION['matKhau'];
    $gioiTinh = $_SESSION['gioiTinh'];
    $ngaySinh = $_SESSION['ngaySinh'];
    $diaChi = $_SESSION['diaChi'];
    $soDienThoai = $_SESSION['soDienThoai'];
    $email = $_SESSION['email'];

    $s = "SELECT * FROM gen_code WHERE (expiry_time-gen_time)>0;";

    $query = mysqli_query($connect, $s);

    $codes = [];
    
    while($row =  mysqli_fetch_array($query)){
        array_push($codes, $row['code']);
    }

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $emailAdmin;
        $mail->Password   = 'smab floy tdrw zizh';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        //Recipients
        $mail->setFrom($email, 'Admin');
        $mail->addAddress($email, 'Admin'); 

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'This is your passcode';

        // lấy code bất kì còn hạn trong database
        $randomIndex = array_rand($codes);
        $randomCode = $codes[$randomIndex];
        $mail->Body    = '<b>' . $randomCode . '</b>';

        $mail->send();
        // echo 'Message has been sent';
    } catch (Exception $e) {
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }


    // echo $verifyCode;
    if(isset($_GET['submit'])){
        $verifyCode = $_GET['verifyCode'];
        if(in_array($verifyCode, $codes)){

            $s = "SELECT username FROM teachers WHERE username='$taiKhoan'";
            $query = mysqli_query($connect, $s);
            if(mysqli_num_rows($query) > 0){
                $error_taiKhoan = 'Tài khoản đã tồn tại';
            } else {
                $sql = "INSERT INTO teachers(username, password, fullname, ngaysinh, phone_number, gender, address, email, id_code) VALUES 
                ('$taiKhoan', '$matKhau', '$hoVaTen', '$ngaySinh', '$soDienThoai', '$gioiTinh','$diaChi', '$email', 1);";

                $result = mysqli_query($connect, $sql);
                
                echo $sql;
                if($result){
                    $affected_row = mysqli_affected_rows($connect);
                    if($affected_row > 0){
                        echo "Đã thêm giáo viên";
                        ?>
                        <script>
                            alert("Xin chào <?php $hoVaTen?>");
                            window.location.href="index.php";
                        </script>
                    <?php 
                    } else {
                        echo "1";
                    }
                } else {
                    echo "2";
                }
            }
            // header("location: index.php");
        } else {
            ?>
            <script>alert("Passcode sai, hãy kiểm tra lại email")</script>
            <?php
        }

    }
?>

<div class="container">
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="get">
        <div>Nhập mã xác thực đã gửi tới Gmail</div>
        <input type="text" name="verifyCode">
        <input type="submit" value="Xác thực" name="submit">
    </form>
</div>


<?php 
   include './laytouts/footer.php';
?>
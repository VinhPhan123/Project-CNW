<?php 
    include './laytouts/header.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	
	require 'vendor/PHPMailer/src/Exception.php';
	require 'vendor/PHPMailer/src/PHPMailer.php';
	require 'vendor/PHPMailer/src/SMTP.php';
?>

<?php 
	$error_taiKhoan = "";
	$token = md5(uniqid());
	
	// echo $_POST['_token'] . '<br>'; // biến $_POST['_token'] không thay đổi vì nó không thực hiện submit
	// echo $_SESSION['token'];

    if(isset($_REQUEST['submit']) && $_SESSION['token'] == $_POST['_token']) {

        $hoVaTen = $_POST['hoVaTen'];
        $taiKhoan = $_POST['taiKhoan'];
        $matKhau = $_POST['matKhau'];
		$matKhau_hashed = md5($matKhau);
        $gioiTinh = $_POST['gioiTinh'];
        $ngaySinh = $_POST['ngaySinh'];
        $diaChi = $_POST['diaChi'];
        $soDienThoai = $_POST['soDienThoai'];
        $email = $_POST['email'];

		echo "1231231322";

		
		// $s = "SELECT taiKhoan FROM user WHERE taiKhoan='$taiKhoan'";
		// $query = mysqli_query($connect, $s);
		// if(mysqli_num_rows($query) > 0){
		// 	$error_taiKhoan = 'Tài khoản đã tồn tại';
		// } else {
		// 	$sql = "INSERT INTO user(hoVaTen, taiKhoan, matKhau, gioiTinh, ngaySinh, diaChi, soDienThoai, email) VALUES 
		// 	('$hoVaTen', '$taiKhoan', '$matKhau_hashed', '$gioiTinh', '$ngaySinh', '$diaChi', '$soDienThoai', '$email');";
	
		//    $result = mysqli_query($connect, $sql);
	
		// 	if($result){
		// 		$affected_row = mysqli_affected_rows($connect);
		// 		if($affected_row > 0){
		// 			$_SESSION['taiKhoan'] = $taiKhoan;
		// 			?>
		// 			<script>
		// 				alert("Xin chào <?php $hoVaTen?>");
		// 				window.location.href="index.php";
		// 			</script>
		// 		<?php 
		// 		}
		// 	}
		// }
    }
?>

	<div class="container" style="width: 70%; padding-top: 20px;">
		<h3 style="text-align: center; color: highlight; font-size: 40px;">Đăng ký tài khoản</h3><br>
		<div class="red" id="baoLoi">
			<?php $error_taiKhoan ?>
		</div>
		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form">
			<div class="row">
				<div class="col-md-6">
					<h3>Tài khoản</h3>
				  	<div class="mb-3">
					    <label for="taiKhoan" class="form-label">Tên đăng nhập</label><span class="red">*</span>
					    <input type="text" class="form-control" id="taiKhoan" name="taiKhoan" required="required" value="">
				  	</div>
				  	<div class="mb-3">
					    <label for="matKhau" class="form-label">Mật khẩu</label><span class="red">*</span>
					    <input type="password" class="form-control" id="matKhau" name="matKhau" required="required" onkeyup="kiemTraMatKhau()">
				  	</div>
				  	<div class="mb-3">
					    <label for="matKhauNhapLai" class="form-label">Nhập lại mật khẩu</label><span class="red">*</span>
					    <input type="password" class="form-control" id="matKhauNhapLai" name="matKhauNhapLai" required="required" onkeyup="kiemTraMatKhau()">
					    <span class="red" id="msg"></span>
				  	</div>
				
					<h3>Thông tin khách hàng</h3>
				  	<div class="mb-3">
					    <label for="hoVaTen" class="form-label">Họ và tên</label>
					    <input type="text" class="form-control" id="hoVaTen" name="hoVaTen" value="">
				  	</div>
				  	<div class="mb-3">
					    <label for="gioiTinh" class="form-label">Giới tính</label>
					    <select class="form-control" id="gioiTinh" name="gioiTinh">
					    	<option></option>	
					    	<option value="Nam">Nam</option>
					    	<option value="Nữ">Nữ</option>
					    	<option value="Khác">Khác</option>
					    </select>
				  	</div>
				  	<div class="mb-3">
					    <label for="ngaySinh" class="form-label">Ngày sinh</label>
					    <input type="date" class="form-control" id="ngaySinh" name="ngaySinh" value="">
				  	</div>
			  	</div>
			  	
			  	<div class="col-md-6">
				  	<h3>Địa chỉ</h3>
				  	<div class="mb-3">
					    <label for="diaChi" class="form-label">Địa chỉ</label>
					    <input type="text" class="form-control" id="diaChi" name="diaChi" value="">
				  	</div>
				  	<div class="mb-3">
					    <label for="soDienThoai" class="form-label">Điện thoại</label>
					    <input type="text" class="form-control" id="soDienThoai" name="soDienThoai" value="">
				  	</div>
				  	<div class="mb-3">
					    <label for="email" class="form-label">Email</label>
					    <input type="email" class="form-control" id="email" name="email" value="">
				  	</div>
				  	
				  	<div class="mb-3">
					    <label for="dongYDieuKhoan" class="form-label">Đồng ý điều với khoản<span class="red">*</span></label>
					    <input type="checkbox" class="form-check-input" id="dongYDieuKhoan" name="dongYDieuKhoan" required="required" onchange="xuLyChonDongY()">
				  	</div>
				  	
				  	<div class="mb-3">
					    <label for="dongYNhanMail" class="form-label">Đồng ý nhận email</label>
					    <input type="checkbox" class="form-check-input" id="dongYNhanMail" name="dongYNhanMail">
				  	</div>

					<!-- Teacher form -->
					<div class="mb-3">
						<label for="dangKyGiaoVien" class="form-label">Đăng ký với tư cách giáo viên</label>
						<input type="checkbox" class="form-check-input" id="dangKyGiaoVien" name="dangKyGiaoVien" required="required" onchange="xuLyDangKyGiaoVien()">
					</div>

					<div class="mb-3" style="visibility: hidden;" id="dangKy">
						<label for="">Nhận mã gửi tới gmail</label>
						<div class="btn btn-primary" style="margin-left: 20px;" name="btn_send" id="btn_send" onclick="nhanMa()">Send</div>
						<div style="height: 20px;"></div>
						<label for="">Nhập passcode được cung cấp với tư cách giáo viên</label>
						<input type="text" class="form-control" id="passcode" >
					</div>


			  	</div>
			  	<input type="submit" class="btn btn-primary" value="Đăng ký" name="submit" id="submit" style="visibility: hidden;"/>

				<input type="hidden" name="_token" value="<?php echo $token ?>">
				<?php $_SESSION['token'] = $token; ?>
		  	</div>
		</form>
	</div>
</body>

<script type="text/javascript">
	function kiemTraMatKhau(){
		matKhau = document.getElementById("matKhau").value;
		matKhauNhapLai = document.getElementById("matKhauNhapLai").value;
		if(matKhau != matKhauNhapLai){
			document.getElementById("msg").innerHTML = "Mật khẩu không khớp!";
			return false;
		} else{
			document.getElementById("msg").innerHTML = "";
			return true;
		}
	}

	function xuLyChonDongY(){
		dongYDieuKhoan = document.getElementById("dongYDieuKhoan");
		if(dongYDieuKhoan.checked==true){
			document.getElementById("submit").style.visibility="visible";
		} else {
			document.getElementById("submit").style.visibility = "hidden";
		}
	}

	function xuLyDangKyGiaoVien(){
		dangKyGiaoVien = document.getElementById("dangKyGiaoVien");
		if(dangKyGiaoVien.checked==true){
			document.getElementById("dangKy").style.visibility="visible";
		} else {
			document.getElementById("dangKy").style.visibility = "hidden";
		}
	}

	function nhanMa(){
		// <?php 
			
		// 	//Create an instance; passing `true` enables exceptions
		// 	// $mail = new PHPMailer(true);
			
		// 	$s = "SELECT email FROM admins;";
		// 	$email_admin = mysqli_query($connect, $s);

		// 	echo $email_admin;


		// 	// try {
		// 	// 	//Server settings
		// 	// 	$mail->isSMTP();                                            //Send using SMTP
		// 	// 	$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		// 	// 	$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		// 	// 	$mail->Username   = 'anhtai22042004@gmail.com';                     //SMTP username
		// 	// 	$mail->Password   = 'smab floy tdrw zizh';                               //SMTP password
		// 	// 	$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
		// 	// 	$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
			
		// 	// 	//Recipients
		// 	// 	$mail->setFrom($email, 'Mailer');
		// 	// 	$mail->addAddress($email, 'Anh Tai');     //Add a recipient
			
		// 	// 	//Content
		// 	// 	$mail->isHTML(true);                                  //Set email format to HTML
		// 	// 	$mail->Subject = 'Test main';
		// 	// 	$mail->Body    = '<b>New content</b>';
			
		// 	// 	$mail->send();
		// 	// 	echo 'Message has been sent';
		// 	// } catch (Exception $e) {
		// 	// 	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		// 	// }			
		// ?>
	}
</script>


<?php 
    include './laytouts/footer.php'
?>
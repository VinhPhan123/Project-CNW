<?php 
    include './laytouts/header.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	
	require 'vendor/PHPMailer/src/Exception.php';
	require 'vendor/PHPMailer/src/PHPMailer.php';
	require 'vendor/PHPMailer/src/SMTP.php';
?>

<?php 
	
?>


<?php ?>

<?php 
	$error_taiKhoan = "";
	$token = md5(uniqid());
	
	// echo $_POST['_token'] . '<br>'; // biến $_POST['_token'] không thay đổi vì nó không thực hiện submit
	// echo $_SESSION['token'];

    if(isset($_POST['submit1']) && $_SESSION['token'] == $_POST['_token']) {

		// validate thẻ....

        $hoVaTen = $_POST['hoVaTen'];
        $taiKhoan = $_POST['taiKhoan'];
        $matKhau_a = $_POST['matKhau'];
		$matKhau = md5($matKhau_a);
        $gioiTinh = $_POST['gioiTinh'];
        $ngaySinh = $_POST['ngaySinh'];
        $diaChi = $_POST['diaChi'];
        $soDienThoai = $_POST['soDienThoai'];
        $email = $_POST['email'];


		$_SESSION['hoVaTen'] = $hoVaTen;
		$_SESSION['taiKhoan'] = $taiKhoan;
		$_SESSION['matKhau'] = $matKhau;
		$_SESSION['gioiTinh'] = $gioiTinh;
		$_SESSION['ngaySinh'] = $ngaySinh;
		$_SESSION['diaChi'] = $diaChi;
		$_SESSION['soDienThoai'] = $soDienThoai;
		$_SESSION['email'] = $email;

		// echo $hoVaTen . '-' . $taiKhoan . '-' . $matKhau . '-' . $gioiTinh . '-' . $ngaySinh . '-' . $diaChi . '-' . $soDienThoai . '-' . $email;

		
		$s = "SELECT taiKhoan FROM students WHERE username='$taiKhoan'";
		$query = mysqli_query($connect, $s);
		if(mysqli_num_rows($query) > 0){
			$error_taiKhoan = 'Tài khoản đã tồn tại';
		} else {
			$sql = "INSERT INTO students(username, password, fullname, ngaysinh, phone_number, gender, address, email) VALUES 
			('$taiKhoan', '$matKhau', '$hoVaTen', '$ngaySinh', '$soDienThoai', '$gioiTinh','$diaChi', '$eanail');";
	
		   $result = mysqli_query($connect, $sql);
	
			if($result){
				$affected_row = mysqli_affected_rows($connect);
				if($affected_row > 0){
					$_SESSION['taiKhoan'] = $taiKhoan;
					?>
					<script>
						alert("Xin chào <?php $hoVaTen?>");
						window.location.href="index.php";
					</script>
				<?php 
				}
			}
		}
    }

	if(isset($_POST['submit2']) && $_SESSION['token'] == $_POST['_token']) {

		// validate thẻ....

        $hoVaTen = $_POST['hoVaTen'];
        $taiKhoan = $_POST['taiKhoan'];
        $matKhau_a = $_POST['matKhau'];
		$matKhau = md5($matKhau_a);
        $gioiTinh = $_POST['gioiTinh'];
        $ngaySinh = $_POST['ngaySinh'];
        $diaChi = $_POST['diaChi'];
        $soDienThoai = $_POST['soDienThoai'];
        $email = $_POST['email'];


		$_SESSION['hoVaTen'] = $hoVaTen;
		$_SESSION['taiKhoan'] = $taiKhoan;
		$_SESSION['matKhau'] = $matKhau;
		$_SESSION['gioiTinh'] = $gioiTinh;
		$_SESSION['ngaySinh'] = $ngaySinh;
		$_SESSION['diaChi'] = $diaChi;
		$_SESSION['soDienThoai'] = $soDienThoai;
		$_SESSION['email'] = $email;

		echo $hoVaTen . '-' . $taiKhoan . '-' . $matKhau . '-' . $gioiTinh . '-' . $ngaySinh . '-' . $diaChi . '-' . $soDienThoai . '-' . $email;

        header("location: xacthuc.php");
		
    }
?>

	<div class="container" style="width: 70%; padding-top: 20px;">
		<h3 style="text-align: center; color: highlight; font-size: 40px;">Đăng ký tài khoản</h3><br>
		<div class="red" id="baoLoi">
			<?php $error_taiKhoan ?>
		</div>
		<form action="<?php echo $_SERVER['PHP_SELF']?>" id="form1" method="post">
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
				  	
				  	<div class="mb-3" id="mail">
					    <label for="dongYNhanMail" class="form-label">Đồng ý nhận email</label>
					    <input type="checkbox" class="form-check-input" id="dongYNhanMail" name="dongYNhanMail">
				  	</div>

					<div class="mb-3">
						<label for="dangKyGiaoVien" class="form-label">Đăng ký với tư cách giáo viên</label>
						<input type="checkbox" class="form-check-input" id="dangKyGiaoVien" name="dangKyGiaoVien" onchange="xuLyChonDongY()">
					</div>

			  	</div>

				<input type="submit" class="inputSubmit btn btn-primary" value="Đăng ký" name="submit1" id="submitDangKy" style="visibility: hidden;"/>

				<input type="submit" class="inputSubmit btn btn-primary" value="Xác thực" name="submit2" id="submitXacThuc" style="visibility: hidden;"/>

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
		dangKyGiaoVien = document.getElementById("dangKyGiaoVien");
		var isDongY = dongYDieuKhoan.checked;
		var isDangKy = dangKyGiaoVien.checked;
		if( isDongY==true && isDangKy==true){
			document.getElementById("submitXacThuc").style.visibility = "visible";
			document.getElementById("submitDangKy").style.visibility = "hidden";
		} else if(isDongY==true && isDangKy==false){
			document.getElementById("submitDangKy").style.visibility = "visible";
			document.getElementById("submitXacThuc").style.visibility = "hidden";
		} else if(isDongY==false && isDangKy==true){
			document.getElementById("submitXacThuc").style.visibility = "visible";
			document.getElementById("submitDangKy").style.visibility = "hidden";
		} else {
			document.getElementById("submitXacThuc").style.visibility = "hidden";
			document.getElementById("submitDangKy").style.visibility = "hidden";
		}
	}

</script>



<?php 
    include './laytouts/footer.php'
?>


<script>
	var checkButtonDangKyGiaoVien = document.getElementById('dangKyGiaoVien');
	console.log(checkButtonDangKyGiaoVien.checked);
</script>
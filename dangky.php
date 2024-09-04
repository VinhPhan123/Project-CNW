<?php 
    include './laytouts/header.php';
?>

	<div class="container" style="width: 70%; padding-top: 20px;">
		<h3 style="text-align: center; color: highlight; font-size: 40px;">Đăng ký tài khoản</h3><br>
		<div class="red" id="baoLoi">
			<?php $errors = "" ?>
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
			  	</div>
			  	<input type="submit" class="btn btn-primary" value="Đăng ký" name="submit" id="submit" style="visibility: hidden;"/>
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
	
</script>


<?php 
    if(isset($_POST['submit'])) {
        $hoVaTen = $_POST['hoVaTen'];
        $taiKhoan = $_POST['taiKhoan'];
        $matKhau = $_POST['matKhau'];
        $gioiTinh = $_POST['gioiTinh'];
        $ngaySinh = $_POST['ngaySinh'];
        $diaChi = $_POST['diaChi'];
        $soDienThoai = $_POST['soDienThoai'];
        $email = $_POST['email'];

        // echo $hoVaTen . '-' . $taiKhoan . '-' . $matKhau . '-' . $gioiTinh . '-' . $ngaySinh . '-' . $diaChi . '-' . $soDienThoai . '-' . $email; 

        $sql = "INSERT INTO user(hoVaTen, taiKhoan, matKhau, gioiTinh, ngaySinh, diaChi, soDienThoai, email) VALUES 
        ('$hoVaTen', '$taiKhoan', '$matKhau', '$gioiTinh', '$ngaySinh', '$diaChi', '$soDienThoai', '$email');";

        mysqli_query($connect, $sql);
    }
?>

<?php 
    include './laytouts/footer.php'
?>
<?php 
		include './layouts/header.php';
?>

<div style="display: flex; justify-content: center;">

<?php 
    if(isset($_SESSION['role'])) {
		include './layouts/menu.php';
	}
?>

<link rel="stylesheet" href="./assets/css/student_knowled_record.css">
	<div style="display: block; width: 100%;">

		<!-- Page content -->
		<?php
			$username = $_SESSION["taiKhoan"];
			$sql = "SELECT
					s.fullname,
					s.ngaysinh,
					s.gender,
					s.phone_number,
					s.address,
					s.email,
					ar.school,
					ar.address,
					ar.Toan,
					ar.NguVan,
					ar.TiengAnh,
					ar.VatLy,
					ar.HoaHoc,
					ar.SinhHoc,
					ar.LichSu,
					ar.DiaLy,
					ar.TinHoc,
					ar.CongNghe,
					ar.GiaoDucCongDan,
					ar.GiaoDucTheChat
				FROM students AS s
				JOIN academic_records AS ar ON s.id_student = ar.id_student
				WHERE s.username = '$username'";
			$query = mysqli_query($connect, $sql);
			$result = mysqli_num_rows($query);
			$arr = mysqli_fetch_array($query);
		?>

	<div class="container" style="padding-left: 100px;;">
		<div style="position: relative;">
			<h5 class="content-label">Thông tin cá nhân</h5>
			<button type="button" id="btn-open-infor" style="position: absolute; right: 50px; top: 0px;" class="btn btn-primary">Sửa</button>
		</div>
		<div class="content">
			<div class="infor" style="margin-right: 100px;">
				<label>Họ và tên:</label>
				<input disabled type="text" value="<?php echo $arr[0]; ?>"><br>
				<label>Ngày sinh:</label>
				<input disabled type="date" value="<?php echo $arr[1]; ?>"><br>
				<label>Giới tính:</label>
				<input disabled type="text" value="<?php echo $arr[2]; ?>">
			</div>
			<div class="infor">
				<label>Số điện thoại:</label>
				<input disabled type="tel" value="<?php echo $arr[3]; ?>"><br>
				<label>Địa chỉ thường trú:</label>
				<input disabled type="text" value="<?php echo $arr[4]; ?>"><br>
				<label>Địa chỉ email:</label>
				<input style="width: 300px;" disabled type="email" value="<?php echo $arr[5]; ?>">
			</div>
		</div>
		<div style="position: relative;">
			<h5 class="content-label">Thông tin đào tạo</h5>
			<button type="button" id="btn-open-record" style="position: absolute; right: 50px; top: 0px;" class="btn btn-primary">Sửa</button>
		</div>
		<div class="content">
			<div class="infor">
				<label>Trường:</label>
				<input style="width: 400px;" disabled type="text" value="<?php echo $arr[6]; ?>"><br>
				<label>Địa chỉ trường:</label>
				<input style="width: 400px;" disabled type="text" value="<?php echo $arr[7]; ?>"><br>
			</div>
			<div>
				<div class="infor">
					<label>Toán</label>
					<input class="score" disabled type="number" value="<?php echo $arr[8]; ?>"><br>
					<label>Ngữ văn</label>
					<input class="score" disabled type="number" value="<?php echo $arr[9]; ?>"><br>
					<label>Tiếng Anh</label>
					<input class="score" disabled type="number" value="<?php echo $arr[10]; ?>"><br>
				</div>
				<div class="infor">
					<label>Vật lý</label>
					<input class="score" disabled type="number" value="<?php echo $arr[11]; ?>"><br>
					<label>Hóa học</label>
					<input class="score" disabled type="number" value="<?php echo $arr[12]; ?>"><br>
					<label>Sinh học</label>
					<input class="score" disabled type="number" value="<?php echo $arr[13]; ?>"><br>
				</div>
				<div class="infor">
					<label>Lịch sử</label>
					<input class="score" disabled type="number" value="<?php echo $arr[14]; ?>"><br>
					<label>Địa lý</label>
					<input class="score" disabled type="number" value="<?php echo $arr[15]; ?>"><br>
					<label>Tin học</label>
					<input class="score" disabled type="number" value="<?php echo $arr[16]; ?>"><br>
				</div>
				<div class="infor">
					<label>Công nghệ</label>
					<input class="score" disabled type="number" value="<?php echo $arr[17]; ?>"><br>
					<label>Giáo dục công dân</label>
					<input class="score" disabled type="number" value="<?php echo $arr[18]; ?>"><br>
					<label>Giáo dục thể chất</label>
					<input class="score" disabled type="number" value="<?php echo $arr[19]; ?>"><br>
				</div>
			</div>
		</div>
		<div id="alert-infor" class="alert">
			<div class="alert-container"></div>
			<div class="alert-content">
				<h5>Thông Báo</h5>
				<hr>
				<div style="width: 100%; text-align: center;">Bạn có muốn sửa thông tin cá nhân?</div>
				<div style="text-align: center; margin-top: 30px;">
					<dev style="margin-left: auto; margin-right: auto; width: 100px; display: inline-block; margin-left: auto; margin-right: auto; " class="btn btn-primary">
						<a style="color: white; text-decoration: none;" href="student_knowled_record_edit_infor.php">Sửa</a>
					</dev>
					<button type="button" id="btn-close-infor" style="color: #0b5ed7; background-color: white; width: 100px; display: inline-block ;margin-left: auto; margin-right: auto; " class="btn btn-primary">Hủy</button>
				</div>
			</div>
		</div>
		<div id="alert-record" class="alert">
			<div class="alert-container"></div>
			<div class="alert-content">
				<h5>Thông Báo</h5>
				<hr>
				<div style="width: 100%; text-align: center;">Bạn có muốn sửa thông tin học bạ?</div>
				<div style="text-align: center; margin-top: 30px;">
					<dev style="margin-left: auto; margin-right: auto; width: 100px; display: inline-block; margin-left: auto; margin-right: auto; " class="btn btn-primary">
						<a style="color: white; text-decoration: none;" href="student_knowled_record_edit_record.php">Sửa</a>
					</dev>
					<button type="button" id="btn-close-record" style="color: #0b5ed7; background-color: white; width: 100px; display: inline-block ;margin-left: auto; margin-right: auto; " class="btn btn-primary">Hủy</button>
				</div>
			</div>
		</div>
		<script>
			document.getElementById('btn-open-infor').onclick = function () {
				document.getElementById('alert-infor').style.visibility = 'visible';
			}
			document.getElementById('btn-close-infor').onclick = function () {
				document.getElementById('alert-infor').style.visibility = 'hidden';
			}
			document.getElementById('btn-open-record').onclick = function () {
				document.getElementById('alert-record').style.visibility = 'visible';
			}
			document.getElementById('btn-close-record').onclick = function () {
				document.getElementById('alert-record').style.visibility = 'hidden';
			}
		</script>
	</div>

	<?php 
		include './layouts/footer.php';
	?>
</div>
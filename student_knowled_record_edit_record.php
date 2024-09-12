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
					s.id_student
				FROM students AS s
				JOIN academic_records AS ar ON s.id_student = ar.id_student
				WHERE s.username = '$username'";
			$query = mysqli_query($connect, $sql);
			$result = mysqli_num_rows($query);
			$arr = mysqli_fetch_array($query);
			$id_student = $arr[0];
		?>

	<form action="" method="post">
		<div class="container" style="padding-left: 100px;;">
			<h5 class="content-label" style="text-align: center;">Chỉnh sửa thông tin</h5>
			<h5 class="content-label">Thông tin đào tạo</h5>
			<button id="button-edit" type="submit" style="position: absolute; right: 50px; top: 0px;" class="btn btn-primary" name="editAccess">Sửa</button>
			<div class="content">
				<div class="infor">
					<label>Trường:</label>
					<input name="school" style="width: 400px;" type="text" value="<?php if(!isset($_POST['school'])) echo ""; else echo $_POST['school']; ?>"><br>
					<label>Địa chỉ trường:</label>
					<input name="school_address" style="width: 400px;" type="text" value="<?php if(!isset($_POST['school_address'])) echo ""; else echo $_POST['school_address']; ?>"><br>
				</div>
				<div>
					<div class="infor">
						<label>Toán</label>
						<input name="Toan" class="score" type="number" value="<?php if(!isset($_POST['Toan'])) echo ""; else echo $_POST['Toan']; ?>"><br>
						<label>Ngữ văn</label>
						<input name="NguVan" class="score" type="number" value="<?php if(!isset($_POST['NguVan'])) echo ""; else echo $_POST['NguVan']; ?>"><br>
						<label>Tiếng Anh</label>
						<input name="TiengAnh" class="score" type="number" value="<?php if(!isset($_POST['TiengAnh'])) echo ""; else echo $_POST['TiengAnh']; ?>"><br>
					</div>
					<div class="infor">
						<label>Vật lý</label>
						<input name="VatLy" class="score" type="number" value="<?php if(!isset($_POST['VatLy'])) echo ""; else echo $_POST['VatLy']; ?>"><br>
						<label>Hóa học</label>
						<input name="HoaHoc" class="score" type="number" value="<?php if(!isset($_POST['HoaHoc'])) echo ""; else echo $_POST['HoaHoc']; ?>"><br>
						<label>Sinh học</label>
						<input name="SinhHoc" class="score" type="number" value="<?php if(!isset($_POST['SinhHoc'])) echo ""; else echo $_POST['SinhHoc']; ?>"><br>
					</div>
					<div class="infor">
						<label>Lịch sử</label>
						<input name="LichSu" class="score" type="number" value="<?php if(!isset($_POST['LichSu'])) echo ""; else echo $_POST['LichSu']; ?>"><br>
						<label>Địa lý</label>
						<input name="DiaLy" class="score" type="number" value="<?php if(!isset($_POST['DiaLy'])) echo ""; else echo $_POST['DiaLy']; ?>"><br>
						<label>Tin học</label>
						<input name="TinHoc" class="score" type="number" value="<?php if(!isset($_POST['TinHoc'])) echo ""; else echo $_POST['TinHoc']; ?>"><br>
					</div>
					<div class="infor">
						<label>Công nghệ</label>
						<input name="CongNghe" class="score" type="number" value="<?php if(!isset($_POST['CongNghe'])) echo ""; else echo $_POST['CongNghe']; ?>"><br>
						<label>Giáo dục công dân</label>
						<input name="GiaoDucCongDan" class="score" type="number" value="<?php if(!isset($_POST['GiaoDucCongDan'])) echo ""; else echo $_POST['GiaoDucCongDan']; ?>"><br>
						<label>Giáo dục thể chất</label>
						<input name="GiaoDucTheChat" class="score" type="number" value="<?php if(!isset($_POST['GiaoDucTheChat'])) echo ""; else echo $_POST['GiaoDucTheChat']; ?>"><br>
					</div>
				</div>
			</div>
		</div>
		<?php
			if(isset($_POST["editAccess"])) {
				if($_POST['school'] == '' ||
				$_POST['school_address'] == '' ||
				$_POST['Toan'] == '' ||
				$_POST['NguVan'] == '' ||
				$_POST['TiengAnh'] == '' ||
				$_POST['VatLy'] == '' ||
				$_POST['HoaHoc'] == '' ||
				$_POST['SinhHoc'] == '' ||
				$_POST['LichSu'] == '' ||
				$_POST['DiaLy'] == '' ||
				$_POST['TinHoc'] == '' ||
				$_POST['CongNghe'] == '' ||
				$_POST['GiaoDucCongDan'] == '' ||
				$_POST['GiaoDucTheChat'] == '' ) {
					echo '<script>alert("Bạn chưa nhập đầy đủ thông tin");</script>';
				} else {
					if($_POST['Toan'] < 0 || $_POST['Toan'] > 10 ||
					$_POST['NguVan'] < 0 || $_POST['NguVan'] > 10 ||
					$_POST['TiengAnh'] < 0 || $_POST['TiengAnh'] > 10 ||
					$_POST['VatLy'] < 0 || $_POST['VatLy'] > 10 ||
					$_POST['HoaHoc'] < 0 || $_POST['HoaHoc'] > 10 ||
					$_POST['SinhHoc'] < 0 || $_POST['SinhHoc'] > 10 ||
					$_POST['LichSu'] < 0 || $_POST['LichSu'] > 10 ||
					$_POST['DiaLy'] < 0 || $_POST['DiaLy'] > 10 ||
					$_POST['TinHoc'] < 0 || $_POST['TinHoc'] > 10 ||
					$_POST['CongNghe'] < 0 || $_POST['CongNghe'] > 10 ||
					$_POST['GiaoDucCongDan'] < 0 || $_POST['GiaoDucCongDan'] > 10 ||
					$_POST['GiaoDucTheChat'] < 0 || $_POST['GiaoDucTheChat'] > 10) {
						echo '<script>alert("Điểm phải nằm trong khoảng từ 0 đến 10");</script>';
					} else {
						$school = $_POST['school'];
						$school_address = $_POST['school_address'];
						$Toan = $_POST['Toan'];
						$NguVan = $_POST['NguVan'];
						$TiengAnh = $_POST['TiengAnh'];
						$VatLy = $_POST['VatLy'];
						$HoaHoc = $_POST['HoaHoc'];
						$SinhHoc = $_POST['SinhHoc'];
						$LichSu = $_POST['LichSu'];
						$DiaLy = $_POST['DiaLy'];
						$TinHoc = $_POST['TinHoc'];
						$CongNghe = $_POST['CongNghe'];
						$GiaoDucCongDan = $_POST['GiaoDucCongDan'];
						$GiaoDucTheChat = $_POST['GiaoDucTheChat'];

						$sql_update_academic_records = "UPDATE academic_records
														SET school = '$school',
															address = '$school_address',
															Toan = $Toan,
															NguVan = $NguVan,
															TiengAnh = $TiengAnh,
															VatLy = $VatLy,
															HoaHoc = $HoaHoc,
															SinhHoc = $SinhHoc,
															LichSu = $LichSu,
															DiaLy = $DiaLy,
															TinHoc = $TinHoc,
															CongNghe = $CongNghe,
															GiaoDucCongDan = $GiaoDucCongDan,
															GiaoDucTheChat = $GiaoDucTheChat
														WHERE id_student = $id_student;";

						mysqli_query($connect, $sql_update_academic_records);

						echo '<script>alert("Bạn đã sửa thành công!")</script>';
						echo '<script>window.location="student_knowled_record.php";</script>';
					}
				}
			}
		?>
	</form>

	<?php 
		include './layouts/footer.php';
	?>
</div>
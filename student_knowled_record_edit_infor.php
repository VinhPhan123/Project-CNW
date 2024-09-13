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
			$id_student = $_SESSION["id_student"];
		?>

	<form action="" method="post">
		<div class="container" style="padding-left: 100px;;">
			<h5 class="content-label" style="text-align: center;">Chỉnh sửa thông tin</h5>
			<h5 class="content-label">Thông tin cá nhân</h5>
			<button id="button-edit" type="submit" style="position: absolute; right: 50px; top: 0px;" class="btn btn-primary" name="editAccess">Sửa</button>
			<div class="content">
				<div class="infor" style="margin-right: 100px;">
					<label>Họ và tên:</label>
					<input name="fullname" type="text" value="<?php if(!isset($_POST['fullname'])) echo ""; else echo $_POST['fullname']; ?>"><br>
					<label>Ngày sinh:</label>
					<input name="ngaysinh" type="date" value="<?php if(!isset($_POST['ngaysinh'])) echo ""; else echo $_POST['ngaysinh']; ?>"><br>
					<label>Giới tính:</label>
					<select style="width: 140px;" name="gender" value="<?php if(!isset($_POST['gender'])) echo ""; else echo $_POST['gender']; ?>">
						<option>---</option>
						<option value="Nam" <?php echo $_POST['gender'] == "Nam" ? "selected" : ""?>>Nam</option>
						<option value="Nữ" <?php echo $_POST['gender'] == "Nữ" ? "selected" : ""?>>Nữ</option>
						<option value="Khác" <?php echo $_POST['gender'] == "Khác" ? "selected" : ""?>>Khác</option>
					</select>
				</div>
				<div class="infor">
					<label>Số điện thoại:</label>
					<input name="phone_number" type="tel" value="<?php if(!isset($_POST['phone_number'])) echo ""; else echo $_POST['phone_number']; ?>"><br>
					<label>Địa chỉ thường trú:</label>
					<input name="address" type="text" value="<?php if(!isset($_POST['address'])) echo ""; else echo $_POST['address']; ?>"><br>
					<label>Địa chỉ email:</label>
					<input name="email" style="width: 300px;" type="email" value="<?php if(!isset($_POST['email'])) echo ""; else echo $_POST['email']; ?>">
				</div>
			</div>
		</div>
		<?php
			if(isset($_POST["editAccess"])) {
				if($_POST['fullname'] == '' ||
				$_POST['ngaysinh'] == '' ||
				$_POST['gender'] == '' ||
				$_POST['phone_number'] == '' ||
				$_POST['address'] == '' ||
				$_POST['email'] == '') {
					echo '<script>alert("Bạn chưa nhập đầy đủ thông tin");</script>';
				} else {
					$fullname = $_POST['fullname'];
					$ngaysinh = $_POST['ngaysinh'];
					$gender = $_POST['gender'];
					$phone_number = $_POST['phone_number'];
					$address = $_POST['address'];
					$email = $_POST['email'];

					$sql_update_students = "UPDATE students
									SET fullname = '$fullname',
										ngaysinh ='$ngaysinh',
										gender = '$gender',
										phone_number = '$phone_number',
										address = '$address',
										email = '$email'
									WHERE id_student = $id_student;";

					mysqli_query($connect, $sql_update_students);
					
					$_SESSION['hoVaTen'] = $fullname;
					$_SESSION['gioiTinh'] = $gender;
					$_SESSION['ngaySinh'] = $ngaysinh;
					$_SESSION['diaChi'] = $address;
					$_SESSION['soDienThoai'] = $phone_number;
					$_SESSION['email'] = $email;

					echo '<script>alert("Bạn đã sửa thành công!")</script>';
					echo '<script>window.location="student_knowled_record.php";</script>';
				}
			}
		?>
	</form>

	<?php 
		include './layouts/footer.php';
	?>
</div>
<?php 
	include './layouts/header.php';
	include './XuLyPhien/student.php';
	include './functions.php';
?>

<div style="display: flex; justify-content: center;">

<?php 
    if(isset($_SESSION['role'])) {
		include './layouts/menu.php';
	}
?>

<style>
    #preview {
        width: 90px;
        height: 120px;
        background-size: cover;
        border: 0.5px solid #000;
        margin-left: 50px;
    }
	
    #form_upload_potrait:hover{
        cursor: pointer;
        font-weight: bold;
    }

    #form_upload_potrait {
        overflow: hidden;
    }
</style>
<link rel="stylesheet" href="./assets/css/student_knowled_record.css">
	<div style="display: block; width: 100%;">

		<!-- Page content -->
		<?php
			$id_student = $_SESSION["id_student"];
		?>

	<form action="" method="post" enctype="multipart/form-data">
		<div class="container" style="padding-left: 100px;;">
			<h5 class="content-label" style="text-align: center;">Chỉnh sửa thông tin</h5>
			<h5 class="content-label">Thông tin cá nhân</h5>
			<button id="button-edit" type="submit" style="position: absolute; right: 50px; top: 0px;" class="btn btn-primary" name="editAccess">Sửa</button>
			<div class="content" style="display: flex;">
				<div class="infor" style="padding-right: 50px;">
					<input type="file" id="fileInput_potrait" name="fileInput_potrait" accept="image/*" hidden>
					<img style="margin-left: 0px;" id="preview" src="<?php if($arr_infor['avt'] != null) {echo $arr_infor['avt'];} ?>"><br>
					<span id="form_upload_potrait" style=" color: #000;">
						<i class="ti-cloud-up"></i>
						<span style="font-size: 12px;">Tải lên</span>
					</span>
				</div>
				<div class="infor" style="margin-right: 100px;">
					<label>Họ và tên:</label>
					<input name="fullname" type="text" value="<?php if(!isset($_POST['fullname'])) echo ""; else echo $_POST['fullname']; ?>"><br>
					<label>Ngày sinh:</label>
					<input name="ngaysinh" type="date" value="<?php if(!isset($_POST['ngaysinh'])) echo ""; else echo $_POST['ngaysinh']; ?>"><br>
					<label>Giới tính:</label>
					<select style="width: 140px;" name="gender" value="<?php if(!isset($_POST['gender'])) echo ""; else echo $_POST['gender']; ?>">
						<option>---</option>
						<option value="Nam" <?php echo isset( $_POST['gender']) && $_POST['gender'] == "Nam" ? "selected" : ""?>>Nam</option>
						<option value="Nữ" <?php echo isset( $_POST['gender']) && $_POST['gender'] == "Nữ" ? "selected" : ""?>>Nữ</option>
						<option value="Khác" <?php echo isset( $_POST['gender']) && $_POST['gender'] == "Khác" ? "selected" : ""?>>Khác</option>
					</select>
				</div>
				<div class="infor">
					<label>Số điện thoại:</label>
					<input style="width: 300px;" name="phone_number" type="tel" value="<?php if(!isset($_POST['phone_number'])) echo ""; else echo $_POST['phone_number']; ?>"><br>
					<label>Địa chỉ thường trú:</label>
					<input style="width: 300px;" name="address" type="text" value="<?php if(!isset($_POST['address'])) echo ""; else echo $_POST['address']; ?>"><br>
					<label>Địa chỉ email:</label>
					<input style="width: 300px;" name="email" type="email" value="<?php if(!isset($_POST['email'])) echo ""; else echo $_POST['email']; ?>">
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
					echo '<script>alert("Bạn chưa nhập đầy đủ thông tin!");</script>';
				} else {
					if($_FILES['fileInput_potrait']['name'] == "") {
						echo '<script>alert("Bạn chưa chọn ảnh đại diện!");</script>';
					} else {
						$fullname = $_POST['fullname'];
						$ngaysinh = $_POST['ngaysinh'];
						$gender = $_POST['gender'];
						$phone_number = $_POST['phone_number'];
						$address = $_POST['address'];
						$email = $_POST['email'];
		
						$upload_dir = "uploads/avatar/";
						if (!is_dir($upload_dir)) {
							mkdir($upload_dir, 0755, true);
						}
						// $permitted_extensions = ['jpg', 'png', 'jpeg'];
						// $file_name = $_FILES['fileInput_potrait']['name'];
						// $file_tmp_name = $_FILES['fileInput_potrait']['tmp_name'];
						// $file_extension = explode('.', $file_name);
						// $file_extension = strtolower(end($file_extension));
						// $generated_file_name = $fullname . '-' . time() . '.' . $file_extension;
						// $destination_path = $upload_dir . $generated_file_name;
						// if(in_array($file_extension, $permitted_extensions)){
						// 	move_uploaded_file($file_tmp_name, $destination_path);
						// }
						uploadFileAndSave('fileInput_potrait', $upload_dir, $fullname);

						$sql_update_students = "UPDATE students
										SET fullname = '$fullname',
											ngaysinh ='$ngaysinh',
											gender = '$gender',
											phone_number = '$phone_number',
											address = '$address',
											email = '$email',
											avt = '$destination_path'
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
			}
		?>
	</form>

	<?php 
		include './layouts/footer.php';
	?>
</div>

<script>
        const fileInput_potrait = document.getElementById('fileInput_potrait');

        const formUploadPotrait = document.getElementById('form_upload_potrait');

        const preview = document.getElementById('preview');

        function listenUploadImage(upload, inputTag, imgTag){
            upload.addEventListener('click', function() {
                inputTag.click();
            });
    
    
            // Khi người dùng chọn tệp, hiển thị ảnh xem trước
            inputTag.addEventListener('change', function(event) {
                const file = event.target.files[0];
                
                if (file) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        imgTag.src = e.target.result;
                        imgTag.style.display = 'block'; // Hiển thị ảnh
                    };
                    
                    reader.readAsDataURL(file);
                } else {
                    imgTag.style.display = 'none'; // Ẩn ảnh nếu không có tệp nào được chọn
                }
            });
        }

        listenUploadImage(formUploadPotrait, fileInput_potrait, preview);
</script>
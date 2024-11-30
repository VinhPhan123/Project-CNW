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
			$id_student = $_SESSION['id_student'];
			$sql_infor = "SELECT
					s.fullname,
					s.ngaysinh,
					s.gender,
					s.phone_number,
					s.address,
					s.email,
					s.avt
				FROM students AS s
				WHERE s.id_student = '$id_student'";
			$sql_record ="SELECT
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
						WHERE s.id_student = '$id_student'";
			// $query_infor = mysqli_query($connect, $sql_infor);
			// $query_record = mysqli_query($connect, $sql_record);

			$query_infor = select('students', ['fullname', 'ngaysinh', 'gender', 'phone_number','address','email','avt'], ['id_student' => $id_student]);
			$query_record = selectRecordStudent($id_student);
			$result_infor = mysqli_num_rows($query_infor);
			$result_record = mysqli_num_rows($query_record);
			$arr_infor = mysqli_fetch_array($query_infor);
			$arr_record = mysqli_fetch_array($query_record);
		?>

	<div class="container" style="padding-left: 100px;;">
		<div style="position: relative;">
			<h5 class="content-label">Thông tin cá nhân</h5>
			<button type="button" id="btn-open-infor" style="position: absolute; right: 50px; top: 0px;" class="btn btn-primary">Sửa</button>
		</div>
		<div class="content" style="display: flex;">
			<div class="infor" style="margin-left: 0px; margin-right: 50px;">
				<img id="preview" src="<?php if($arr_infor['avt'] != null) {echo $arr_infor['avt'];} ?>"><br>
			</div>
			<div class="infor" style="margin-right: 100px;">
				<label>Họ và tên:</label>
				<input disabled type="text" value="<?php echo $arr_infor[0]; ?>"><br>
				<label>Ngày sinh:</label>
				<input disabled type="date" value="<?php echo $arr_infor[1]; ?>"><br>
				<label>Giới tính:</label>
				<input disabled type="text" value="<?php echo $arr_infor[2]; ?>">
			</div>
			<div class="infor">
				<label>Số điện thoại:</label>
				<input style="width: 300px;" disabled type="tel" value="<?php echo $arr_infor[3]; ?>"><br>
				<label>Địa chỉ thường trú:</label>
				<input style="width: 300px;" disabled type="text" value="<?php echo $arr_infor[4]; ?>"><br>
				<label>Địa chỉ email:</label>
				<input style="width: 300px;" disabled type="email" value="<?php echo $arr_infor[5]; ?>">
			</div>
		</div>
		<div style="position: relative;">
			<h5 class="content-label">Thông tin đào tạo</h5>
			<button type="button" id="btn-open-record" style="position: absolute; right: 50px; top: 0px;" class="btn btn-primary">Sửa</button>
		</div>
		<div class="content">
			<div class="infor">
				<?php
					if($arr_record == []) {
						echo '
						<div style="visibility: visible;" class="alert">
							<div class="alert-container"></div>
							<div class="alert-content">
								<h5>Thông Báo</h5>
								<hr>
								<div style="width: 100%; text-align: center;">Học bạ của bạn chưa có thông tin!</div>
								<div style="width: 100%; text-align: center;">Chuyển tiếp đến trang nhập học bạ</div>
								<div style="text-align: center; margin-top: 30px;">
									<dev style="margin-left: auto; margin-right: auto; width: 100px; display: inline-block; margin-left: auto; margin-right: auto; " class="btn btn-primary">
										<a style="color: white; text-decoration: none;" href="student_knowled_record_edit_record.php">Đồng ý</a>
									</dev>
								</div>
							</div>
						</div>';
					}
				?>
				<label>Trường:</label>
				<input style="width: 400px;" disabled type="text" value="<?php echo $arr_record[0]; ?>"><br>
				<label>Địa chỉ trường:</label>
				<input style="width: 400px;" disabled type="text" value="<?php echo $arr_record[1]; ?>"><br>
			</div>
			<div>
				<div class="infor">
					<label>Toán</label>
					<input class="score" disabled type="number" value="<?php echo $arr_record[2]; ?>"><br>
					<label>Ngữ văn</label>
					<input class="score" disabled type="number" value="<?php echo $arr_record[3]; ?>"><br>
					<label>Tiếng Anh</label>
					<input class="score" disabled type="number" value="<?php echo $arr_record[4]; ?>"><br>
				</div>
				<div class="infor">
					<label>Vật lý</label>
					<input class="score" disabled type="number" value="<?php echo $arr_record[5]; ?>"><br>
					<label>Hóa học</label>
					<input class="score" disabled type="number" value="<?php echo $arr_record[6]; ?>"><br>
					<label>Sinh học</label>
					<input class="score" disabled type="number" value="<?php echo $arr_record[7]; ?>"><br>
				</div>
				<div class="infor">
					<label>Lịch sử</label>
					<input class="score" disabled type="number" value="<?php echo $arr_record[8]; ?>"><br>
					<label>Địa lý</label>
					<input class="score" disabled type="number" value="<?php echo $arr_record[9]; ?>"><br>
					<label>Tin học</label>
					<input class="score" disabled type="number" value="<?php echo $arr_record[10]; ?>"><br>
				</div>
				<div class="infor">
					<label>Công nghệ</label>
					<input class="score" disabled type="number" value="<?php echo $arr_record[11]; ?>"><br>
					<label>Giáo dục công dân</label>
					<input class="score" disabled type="number" value="<?php echo $arr_record[12]; ?>"><br>
					<label>Giáo dục thể chất</label>
					<input class="score" disabled type="number" value="<?php echo $arr_record[13]; ?>"><br>
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
						<a style="color: white; text-decoration: none; padding: 8px 30px;" href="student_knowled_record_edit_infor.php">Sửa</a>
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
						<a style="color: white; text-decoration: none; padding: 8px 30px;" href="student_knowled_record_edit_record.php">Sửa</a>
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


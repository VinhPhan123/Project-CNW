<?php 
	include './layouts/header.php';
	include './XuLyPhien/teacher.php';
	include './functions.php';
?>

<?php $token = md5(uniqid()); ?>

<div style="display: flex; justify-content: center;">

<style>
    .infor_text {
        color: #b50206;
        font-weight: bold;
        height: 10px;
    }

    .body_content {
        margin-top: 50px;
    }

	.left_content {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
	}
	
    #preview {
        width: 90px;
        height: 120px;
        background-size: cover;
        border: 0.5px solid #000;
        margin-left: 50px;
    }

    .infor_content {
        display: flex;
        justify-content: space-around;
    }

    .mid_content div label,
    .right_content div label {
        min-width: 110px;
        font-weight: 500;
    }


    .mid_content > div, .right_content > div {
        margin: 12px 0;
    }

	.mid_content, .right_content {
		width: 248px;
	}

    .achievements {
        width: 750px;
        display: flex;
        justify-content: space-between;
        position: relative;
    }

    .thanh_tich, 
    .diem_uu_tien, 
    .nguyen_vong {
        margin-top: 20px;
        margin-bottom: 4px;
    }

    .mb_top_8px {
        margin-top: 8px;
    }

    input, select {
        width: 220px;
        height: 28px;
    }

</style>

<style>
	.chonnganh_xettuyen {
		display: flex;
		margin: auto;
		width: 800px;
		justify-content: space-between;
	}

	#chonnganh_select {
		min-width: 254px;
		height: 26px;
	}

	.select_content {
		flex: 1;;
	}

	.btn-chonnganh {
		flex: 0.8;
		align-self: end;
	}

	table, th, tr, td {
		border: 1px solid #000;
		border-collapse: collapse;
	}

	.table_ledgers td, .table_ledgers th {
		min-width: 150px;
	}

	.table_ledgers {
		display: flex;
		justify-content: center;
		margin-top: 40px;
	}

	.btn_chon {
		width: 85px;
		height: 34px;
		line-height: 20px;
	}

	.open {
		display: flex;
	}
</style>

<style>
	.img_truong_chuyen:hover{
		width: 500px;
		height: 500px;
		background-size: cover;
		z-index: 1;
		left: -500px;
		top: -140px;
		border: 1px solid #ccc;
		border-radius: 4px;
		box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
		cursor: pointer;
	}
	.img_hs_gioi:hover{
		width: 500px;
		height: 500px;
		z-index: 1;
		left: -500px;
		top: -244px;
		border: 1px solid #ccc;
		border-radius: 4px;
		cursor: pointer;
		box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
	}
	.img_chung_chi_ielts:hover{
		width: 500px;
		height: 500px;
		z-index: 1;
		left: -500px;
		top: -270px;
		border: 1px solid #ccc;
		border-radius: 4px;
		cursor: pointer;
		box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
	}
	.img_giai_thuong_khac:hover{
		width: 500px;
		height: 500px;
		z-index: 1;
		left: -500px;
		top: -312px;
		border: 1px solid #ccc;
		border-radius: 4px;
		cursor: pointer;
		box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
	}
	.img_doi_tuong_uu_tien:hover{
		width: 500px;
		height: 500px;
		z-index: 1;
		left: -500px;
		top: -430px;
		border: 1px solid #ccc;
		border-radius: 4px;
		cursor: pointer;
		box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
	}
</style>



<?php 
    if(isset($_SESSION['role'])) {
		include './layouts/menu.php';
	}
?>

<?php
    // nếu chưa đăng nhập tài khoản teacher thì out
    if(isset($_SESSION['taiKhoan'])){
		$array_username_teacher = getAllUsernameTeacher();
        if(!in_array($_SESSION['taiKhoan'], $array_username_teacher)){
            header("location: logout.php");
        }
    } else {
        ?>
        <script>
            window.location.href = "logout.php";
        </script>
        <?php
    }
?>

<?php
	// lấy ra id_teacher trong bảng teachers;
	$id_teacher = getIdTeacherFromUsername($_SESSION['taiKhoan']);
	$_SESSION['id_teacher'] = $id_teacher;
	
	$array_chuyennganh_duocphan = getArrayMajorsFromIdTeacher($id_teacher);
	
?>

<div style="display: block; width: 100%;">
	
	<div class="container mt-4">
	<!-- Page content -->
	
		<h2 style="text-align: center; margin-bottom: 16px;">Duyệt hồ sơ xét tuyển học bạ</h2>
		<form action="teacher_duyet_ho_so_major.php" method="post" style="margin-bottom: 24px;">
			<div class="chonnganh_xettuyen">	
				<div class="select_content">
					<h5>Chọn ngành duyệt hồ sơ</h5>
					<select name="chonnganh_select" id="chonnganh_select">
						<option value=""></option>
						<?php
							foreach($array_chuyennganh_duocphan as $chuyen_nganh){
								echo '<option value="' . $chuyen_nganh . '">' . $chuyen_nganh . '</option>';

							}
						?>
					</select>
				</div>
	
				<div class="btn-chonnganh">
					<input type="submit" name="chonnganh_btn" class="btn btn-primary btn_chon">
					<input type="hidden" name="_token" value="<?php echo $token ?>">
        			<?php $_SESSION['token'] = $token; ?>
				</div>
			</div>
		</form>
	<!-- End Page content -->
	</div>
	<?php 
		include './layouts/footer.php';
	?>
</div>
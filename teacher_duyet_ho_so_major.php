<?php 
		include './layouts/header.php';
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
        $a = "SELECT * FROM teachers;";
        $res = mysqli_query($connect, $a);
        $array_username_teacher = array();
        while($r = mysqli_fetch_array($res)){
            array_push($array_username_teacher, $r['username']);
        }
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
	$sql1 = "SELECT * FROM teachers;";
	$query1 = mysqli_query($connect, $sql1);
	$id_teacher = mysqli_fetch_array($query1)['id_teacher'];
	// echo $id_teacher;

	// lấy ra array các ngành mà giáo viên được admin phân
	$sql2 = "select major_name from majors inner join phannganh_giaovien 
			on majors.id_major = phannganh_giaovien.id_major
			where phannganh_giaovien.id_teacher = '$id_teacher';";
	$query2 = mysqli_query($connect, $sql2);
	$array_chuyennganh_duocphan = array();
	while($r = mysqli_fetch_array($query2)){
		array_push($array_chuyennganh_duocphan, $r['major_name']);
	}
	// print_r($array_chuyennganh_duocphan);
?>


<?php
    if(isset($_POST['chonnganh_select']) && ($_SESSION['token'] == $_POST['_token'])){
        $_SESSION['nganh'] = $_POST['chonnganh_select'];
    }
    $nganh = $_SESSION['nganh'];
    // echo $nganh;

    // lấy ra id của ngành
    $sql3 = "SELECT id_major FROM majors WHERE major_name='$nganh';";
    $query3 = mysqli_query($connect, $sql3);
    $id_major = mysqli_fetch_array($query3)['id_major'];
    // echo $id_major;

    // array lưu các student đăng ký xét tuyển ngành được chọn
    $sql3 = "SELECT * FROM ledgers WHERE id_major = '$id_major';";
    $query3 = mysqli_query($connect, $sql3);
    $student_ledgers_array = array();
    
    while ($r = mysqli_fetch_assoc($query3)) {
        $student_id_SB = $r['id_SB'];
        $id_student = $r['id_student'];
    
        // Nếu chưa có, khởi tạo mảng cho id_student này
        if (!isset($student_ledgers_array[$id_student])) {
            $student_ledgers_array[$id_student] = array();
        }
    
        // Thêm id_SB vào mảng tương ứng với id_student
        $student_ledgers_array[$id_student][] = $student_id_SB;
    }
    // print_r($student_ledgers_array);

    echo "<input type='hidden' id='chonnganh_select' value='$nganh'>";
?>

<div style="display: block; width: 100%;">
	<h2 style="text-align: center; margin-bottom: 16px;">Duyệt hồ sơ xét tuyển học bạ</h2>
	<h3 style="text-align: center; margin-bottom: 16px;">Ngành: <?php echo $nganh; ?></h3>
	<div class="container mt-4">
	<!-- Page content -->

		<div class="table_ledgers">
			<table>
				<th>STT</th>
				<th>Tên thí sinh</th>
				<th>Tổ hợp đăng ký</th>
				<th>Hồ sơ thí sinh</th>
				<th>Access</th>
				<th>Deny</th>
							
				<?php
					if(isset($student_ledgers_array)){
						if(sizeof($student_ledgers_array)!=0){
							$count = 0;
							foreach($student_ledgers_array as $id_student => $array_tohop){
								// lay ra ten student
								// echo $id_student . ' - ';
								$sql4 = "SELECT * FROM students WHERE id_student = '$id_student';";
								$query4 = mysqli_query($connect, $sql4);
								$student_name = mysqli_fetch_array($query4)['username'];
								// echo $student_name;

								// lấy ra id_ledgers
								$sql5 = "SELECT * FROM ledgers WHERE id_student = '$id_student';";
								$query5 = mysqli_query($connect, $sql5);
								$id_ledgers = mysqli_fetch_array($query5)['id_ledger'];
								// lấy ra số lượng tohop có status = null với id_major
								$sql7 = "SELECT * FROM ledgers WHERE id_major=$id_major AND id_student=$id_student";
								$query7 = mysqli_query($connect, $sql7);

								$count_tohop = mysqli_num_rows($query7);
								// echo $count_tohop

								if($count_tohop != 0){
									echo '<tr>';
									echo '<td rowspan="' . $count_tohop . '">' . $count . '</td>';
									echo '<td rowspan="' . $count_tohop . '">' . $student_name . '</td>';
									echo '<input type="hidden" name="row_id" value="' . $count . '">';
								}

								foreach($array_tohop as $tohop){
									// kiểm tra status, nếu NULL thì hiển thị
									$sql6 = "SELECT * FROM ledgers WHERE id_major=$id_major AND id_student=$id_student AND id_SB='$tohop';";
									$query6 = mysqli_query($connect, $sql6);
									$arr_query6 = mysqli_fetch_array($query6);
									$ledger_status = $arr_query6['ledger_status'];
									$id_ledger = $arr_query6['id_ledger'];
									echo '<td class="get_to_hop">' . $tohop;
									if($ledger_status == 'Duyệt') {
										echo "<p style='color:#79d28d; font-style: italic;'>(Đã duyệt)</p>";
									} else {
										if($ledger_status == "Không duyệt") {
											echo "<p style='color:#e13647; font-style: italic;'>(Không duyệt)</p>";
										} else {
											echo "<p style='color:#1f96f6; font-style: italic;'>(Chưa duyệt)</p>";
										}
									}
									echo'</td>';
									echo '<td><button style="color: #fff;" class="btn btn-warning" name="show">Click</button></td>';
									echo '<input type="hidden" name="_token" value="' . $token . '">';
									echo '<input type="hidden" name="get_id_ledger" class="get_id_ledger" value="' . $id_ledger . '">';
									
									echo '<td>
										<form action="" method="post">
											<input type="hidden" name="id_ledger" value="' . $id_ledger . '">
        									<button type="submit" class="btn btn-success" name="access">Access</button>
											<input type="hidden" name="_token" value="' . $token . '">
										</form>
										</td>';
									
									echo '<td>
										<form method="post">
											<input type="hidden" name="id_ledger" value="' . $id_ledger . '">
        									<button type="submit" class="btn btn-danger" name="deny">Deny</button>
											<input type="hidden" name="_token" value="' . $token . '">
										</form>
										</td>';
									echo '</tr>';
								}
								
								$count = $count+1;

							}
						} else {
							echo "<tr><td colspan='6'>Không có thí sinh nào !</td></tr>";
						}
					} else {
						echo "<tr><td colspan='6'>Không có thí sinh nào !</td></tr>";
					}
				?>	
			</table>
		</div>
		<div class="overlay"></div>
	
	<!-- End Page content -->
	</div>
	<?php 
		// include './layouts/footer.php';
	?>
</div>

<?php
	// xử lí nút access
	if(isset($_POST['access']) && ($_SESSION['token'] == $_POST['_token'])){
		$id = $_POST['id_ledger'];
		$sql_update_ledger = "UPDATE ledgers SET
								ledger_status = 'Duyệt',
								id_teacher = " . $_SESSION['id_teacher'] ."
							WHERE id_ledger = $id";
		mysqli_query($connect, $sql_update_ledger);
		echo '<script>alert("Đã duyệt hồ sơ thành công!")</script>';
		echo "<script>location.reload();</script>";
	}
	
	// xử lí nút deny
	if(isset($_POST['deny']) && ($_SESSION['token'] == $_POST['_token'])){
		$id = $_POST['id_ledger'];
		$sql_update_ledger = "UPDATE ledgers SET
								ledger_status = 'Không duyệt',
								id_teacher = " . $_SESSION['id_teacher'] ."
							WHERE id_ledger = $id";
		mysqli_query($connect, $sql_update_ledger);
		echo '<script>alert("Đã không duyệt hồ sơ thành công!")</script>';
		echo "<script>location.reload();</script>";
	}
?>

<!-- xử lí ajax khi bấm view gửi đi và nhận lại id_ledger -->
<script>
	const nganh_selected = document.getElementById("chonnganh_select");
	const chuyennganh = nganh_selected.value;
	console.log(chuyennganh);

	// const tohop_selected = document.getElementById("get_to_hop");
	// const tohop = tohop_selected.textContent;
	// console.log(tohop);

	document.querySelectorAll('button[name="show"]').forEach(button => {
		button.addEventListener('click', function(event) {
			// ngăn chặn hành động submit của thẻ button
			event.preventDefault(); 

			const form_ajax = document.querySelector('.overlay');
			const inputElement = this.closest('tr').querySelector('input[class="get_id_ledger"]');
			const id_ledger = inputElement.value;
			console.log(id_ledger);

			const tohop_selected = this.closest('tr').querySelector('.get_to_hop');
			const tohop = tohop_selected.textContent;
			console.log(tohop);

			const xhr = new XMLHttpRequest();
			xhr.open('POST', "teacher_duyet_ho_so_major_ajax.php", true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onload = function() {
				if (xhr.status === 200) {
					// console.log(this.response);
					form_ajax.innerHTML = this.response; // Cập nhật nội dung overlay
					form_ajax.style.display = 'block'; // Hiển thị overlay
				} else {
					console.log('Failed to send data');
				}
			};
			xhr.send('id_ledger=' + id_ledger + '&chuyen_nganh=' + chuyennganh + '&to_hop=' + tohop);
		});
	});
</script>


<script>
	const a = document.querySelector('.overlay');
	a.addEventListener('click', function() {
		this.style.display = 'none';
	});

</script>

<script>
	const overlay = document.querySelector('.overlay');

	// Tạo một observer
	const observer = new MutationObserver(mutations => {
		mutations.forEach(mutation => {
			if (mutation.type === 'childList') {
				const btn_close = document.getElementById('close');

				if (btn_close) {
					// console.log(btn_close);
					btn_close.addEventListener('click', function() {
						overlay.style.display = 'none';
					});
				}

				const overlay_content = document.getElementById('overlay_content');
				overlay_content.addEventListener('click', function(e){
					e.stopPropagation();
				});
			}
		});
	});

	// Bắt đầu theo dõi sự thay đổi trong overlay
	// observe(targetNode, config)
	observer.observe(overlay, {
		childList: true, // Theo dõi thêm hoặc xóa các phần tử con
		subtree: true    //  Theo dõi tất cả các phần tử con trong cây DOM, không chỉ phần tử trực tiếp con của overlay.
	});
</script>

<?php $_SESSION['token'] = $token; ?>
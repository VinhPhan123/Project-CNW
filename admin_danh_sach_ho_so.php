<?php 
    include './layouts/header.php';
    include './functions.php';
?>

<style>
    table, th, tr, td {
        border: 1px solid #000;
        border-collapse: collapse;
    }

    th {
        font-size: 18px;
    }

    tr, td {
        font-size: 15px;
        font-weight: 500;
    }
</style>

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

    .overlay {
        z-index: 11;
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
    // lấy ra các id_student trong bảng student
    $array_id_student = array();
    $sql1 = "SELECT * FROM students;";
    $query1 = mysqli_query($connect, $sql1);
    while($r1 = mysqli_fetch_array($query1)){
        array_push($array_id_student, $r1['id_student']);
    }
    // print_r($array_id_student);

    // tạo array (key-value) = (id_student - [id_major - list_id_SB]);
    $array_idStudent_idMajor_listIdSB = array();
    foreach($array_id_student as $id_student){
        $a = array();

        $list_id_major = array();
        $sql2 = "SELECT distinct id_major FROM ledgers WHERE id_student='$id_student';";
        $query2 = mysqli_query($connect, $sql2);
        while($r2 = mysqli_fetch_array($query2)){
            array_push($list_id_major, $r2['id_major']);
        }
        // print_r($list_id_major);

        foreach($list_id_major as $id_major){
            $list_id_SB = array();
            $sql3 = "SELECT * FROM ledgers WHERE id_student='$id_student' AND id_major='$id_major';";
            $query3 = mysqli_query($connect, $sql3);
            while($r3 = mysqli_fetch_array($query3)){
                array_push($list_id_SB, $r3['id_SB']);
            }
            $a[$id_major] = $list_id_SB;
        }
        $array_idStudent_idMajor_listIdSB[$id_student] = $a;
    }

    // print_r($array_idStudent_idMajor_listIdSB);

    // lấy ra số lượng ledgers;
    $s1 = "SELECT * FROM ledgers;";
    $q1 = mysqli_query($connect, $s1);
    $count_ledger = mysqli_num_rows($q1);
    // echo $count_ledger;

?>

<div style="display: flex; justify-content: center;">

<?php 
    if(isset($_SESSION['role'])) {
		include './layouts/menu.php';
	}
?>

<?php

?> 


<div style="display: block; width: 100%;">
	
	<div class="container mt-4" style="width: max-content; margin-left: auto; margin-right: auto;">
	<!-- Page content -->

    <table>
    <tr>
        <th>STT</th>
        <th>Tên thí sinh</th>
        <th>Ngành xét tuyển</th>
        <th>Tổ hợp đăng ký</th>
        <th>Hồ sơ thí sinh</th>
        <th>Giáo viên phụ trách</th>
        <th>Trạng thái</th>
    </tr>

    <?php 
        if($count_ledger > 0){
            // lấy ra các id_student trong bảng ledgers
            $array_id_student_ledgers = array();
            $sql11 = "SELECT DISTINCT id_student FROM ledgers;";
            $query11 = mysqli_query($connect, $sql11);
            while($r4 = mysqli_fetch_array($query11)){
                array_push($array_id_student_ledgers, $r4['id_student']);
            }

            $index = 0;
            foreach($array_idStudent_idMajor_listIdSB as $id_student => $array_idMajor_listIdSB){
                if(in_array($id_student, $array_id_student_ledgers)){
                    // lấy ra username_student
                    $sql4 = "SELECT * FROM students WHERE id_student='$id_student';";
                    $query4 = mysqli_query($connect, $sql4);
                    $username_student = mysqli_fetch_array($query4)['username'];

                    // lấy ra số lượng id_SB
                    $sql6 = "SELECT * FROM ledgers WHERE id_student='$id_student'";
                    $query6 = mysqli_query($connect, $sql6);
                    $count = mysqli_num_rows($query6);
                    // echo $count;
                    echo '<tr>';
                    echo '<td rowspan="'. $count . '">' . $index . '</td>';
                    echo '<td rowspan="'. $count . '">' . $username_student . '</td>';
                    foreach($array_idMajor_listIdSB as $id_major => $listIdSB){
                        // lấy ra số lượng id_SB
                        $count_id_SB = count($listIdSB);

                        // lấy ra tên ngành dựa vào id_major
                        $sql5 = "SELECT * FROM majors WHERE id_major='$id_major';";
                        $query5 = mysqli_query($connect, $sql5);
                        $ten_nganh = mysqli_fetch_array($query5)['major_name'];

                        echo '<td id="chuyennganh" rowspan="'. $count_id_SB . '">' . $ten_nganh . '</td>';
                        foreach($listIdSB as $id_SB){
                            $sql10 = "SELECT * FROM ledgers where id_student='$id_student' and id_major='$id_major' and id_SB='$id_SB';";
                            $query10 = mysqli_query($connect, $sql10);
                            $id_ledger = mysqli_fetch_array($query10)['id_ledger'];
                            echo '<td class="get_to_hop">' . $id_SB . '</td>';
                            echo '<td><button style="color: #fff;" class="btn btn-warning" name="show">Click</button></td>';
                            echo '<input type="hidden" name="get_id_ledger" class="get_id_ledger" value="' . $id_ledger . '">';
                                

                            // lấy ra id_teacher dựa vào id_student, id_major, id_SB
                            $sql7 = "SELECT * FROM ledgers where id_student='$id_student' and id_major='$id_major' and id_SB='$id_SB';";
                            $query7 = mysqli_query($connect, $sql7);
                            $id_teacher = mysqli_fetch_array($query7)['id_teacher'];
                            if($id_teacher != NULL){
                                $sql8 = "SELECT * FROM teachers WHERE id_teacher='$id_teacher';";
                                $query8 = mysqli_query($connect, $sql8);
                                $teacher_name = mysqli_fetch_array($query8)['fullname'];

                                // lấy ra ledger_status
                                $sql9 = "SELECT * FROM ledgers where id_student='$id_student' and id_major='$id_major' and id_SB='$id_SB';";
                                $query9 = mysqli_query($connect, $sql9);
                                $ledger_status = mysqli_fetch_array($query9)['ledger_status'];
            
                                echo '<td>' . $teacher_name .'</td>
                                    <td>' . $ledger_status . '</td>
                                    </tr>';
                            } else {
                                echo '<td colspan="2">Chờ duyệt</td>';
                                echo '</tr>';
                            }
                        }
                    }
                    $index += 1;
                }
            }
        } else {
            echo '<tr><td colspan="7">Không có hồ sơ nào được nộp</td></tr>';
        }
    ?>
</table>

<div class="overlay"></div>
     
	<!-- End Page content -->
	</div>
	<?php 
		include './layouts/footer.php';
	?>
</div>


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

<script>
	const a = document.querySelector('.overlay');
	a.addEventListener('click', function() {
		this.style.display = 'none';
	});

</script>

<script>
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

            const nganh_selected = document.getElementById("chuyennganh");
            const chuyennganh = nganh_selected.textContent;
        	console.log(chuyennganh);


			const xhr = new XMLHttpRequest();
			xhr.open('POST', "admin_hien_thi_ho_so_ajax.php", true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onload = function() {
				if (xhr.status === 200) {
					// console.log(this.response);
					form_ajax.innerHTML = this.response; // Cập nhật nội dung overlay
					form_ajax.style.display = 'block'; // Hiển thị overlay
                    console.log(this.response);
				} else {
					console.log('Failed to send data');
				}
			};
			xhr.send('id_ledger=' + id_ledger + '&chuyen_nganh=' + chuyennganh + '&to_hop=' + tohop);
		});
	});
</script>
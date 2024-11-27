<?php 
    include './layouts/header.php';
    include 'function.php';
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

<div style="display: flex; justify-content: center;">

<?php 
    if(isset($_SESSION['role'])) {
		include './layouts/menu.php';
	}
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
        $array_ledger = sql_query_fetchAll(
            "SELECT
                l.id_ledger,
                (SELECT count(l1.id_student) FROM xettuyen.ledgers AS l1 WHERE l.id_student = l1.id_student) AS count_ledger_of_student,
                s.fullname AS TenThiSinh,
                (SELECT count(l2.id_major) FROM xettuyen.ledgers AS l2 WHERE l.id_major = l2.id_major AND l.id_student = l2.id_student) AS count_major_of_student,
                m.major_name AS NganhXT,
                l.id_SB AS ToHopDK,
                t.fullname AS GVPhuTrach,
                l.ledger_status AS TrangThai
            FROM xettuyen.ledgers AS l
            JOIN xettuyen.students AS s ON l.id_student = s.id_student
            JOIN xettuyen.majors AS m ON l.id_major = m.id_major
            LEFT OUTER JOIN xettuyen.teachers AS t ON l.id_teacher = t.id_teacher
            ORDER BY l.id_student, l.id_major, l.id_SB;");

        // array_ledger:
            // 0   =>   id_ledger
            // 1   =>   count_ledger_of_student
            // 2   =>   TenThiSinh
            // 3   =>   count_major_of_student
            // 4   =>   NganhXT
            // 5   =>   ToHopDK
            // 6   =>   GVPhuTrach
            // 7   =>   TrangThai
        $count_student = 0;
        $count_major = 0;
        $STT = 0;
        foreach($array_ledger as $key => $value) {
            $count_student += 1;
            $count_major += 1;
            echo '<tr>';
            if($count_student == 1) {
                $STT += 1;
                echo '<td rowspan="'.$value[1].'">'.$STT.'</td>';
                echo '<td rowspan="'.$value[1].'">'.$value[2].'</td>';
            } else {
                if($count_student == $value[1]) {
                    $count_student = 0;
                }
            }
            if($count_major == 1) {
                echo '<td id="chuyennganh" rowspan="'.$value[3].'">'.$value[4].'</td>';
            } else {
                if($count_major == $value[3]) {
                    $count_major = 0;
                }
            }
            echo '<td class="get_to_hop">'.$value[5].'</td>';
            echo '<td><button style="color: #fff;" class="btn btn-warning" name="show">Click</button></td>';
            echo '<input type="hidden" name="get_id_ledger" class="get_id_ledger" value="'.$value[0].'">';
            if($value[6] != NULL) {
                echo '<td>'.$value[6].'</td>';
                echo '<td>'.$value[7].'</td>';
            } else {
                echo '<td colspan="2">Chờ duyệt</td>';
            }
            echo '</tr>';
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

			const tohop_selected = this.closest('tr').querySelector('.get_to_hop');
			const tohop = tohop_selected.textContent;

            const nganh_selected = document.getElementById("chuyennganh");
            const chuyennganh = nganh_selected.textContent;

            console.log(id_ledger, tohop, chuyennganh);

			const xhr = new XMLHttpRequest();
			xhr.open('POST', "admin_hien_thi_ho_so_ajax.php", true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onload = function() {
				if (xhr.status === 200) {
					// console.log(this.response);
					form_ajax.innerHTML = this.response; // Cập nhật nội dung overlay
					form_ajax.style.display = 'block'; // Hiển thị overlay
                    // console.log(this.response);
				} else {
					console.log('Failed to send data');
				}
			};
			xhr.send('id_ledger=' + id_ledger + '&chuyen_nganh=' + chuyennganh + '&to_hop=' + tohop);
		});
	});
</script>
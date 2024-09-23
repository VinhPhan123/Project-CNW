<?php 
		include './layouts/header.php';
?>

<?php
    $token = md5(uniqid());
?>
<?php
    // nếu chưa đăng nhập tài khoản teacher thì out
    if(isset($_SESSION['taiKhoan'])){
        $sql = "SELECT * FROM teachers;";
        $res = mysqli_query($connect, $sql);
        // $username_teacher = $query_username['username'];
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

<div style="display: flex; justify-content: center;">
<?php if(isset($_SESSION['role'])) {include './layouts/menu.php'; } ?>

<?php
    // lấy ra những ngành đã được set tổ hợp trong bảng majors
    $sql_major_list = "SELECT * FROM majors;";
    $query_major_list = mysqli_query($connect, $sql_major_list);
    $arr_major_list = array();
    while($row = mysqli_fetch_array($query_major_list)){
        array_push($arr_major_list, $row);
    }
?>

<div style="display: block; width: 100%;">
	<div class="container mt-4" style="width: max-content; margin-left: auto; margin-right: auto;">
	<!-- Page content -->
    <?php
        // echo "<pre>";
        // print_r($arr_major_list);
        // echo "</pre>";
    ?>
    <div class="container" style="width: 1200px;">
    <div class="chon_nganh_container">
        <div class="nguyen_vong" style="font-size: 18px; font-weight: bold; color: #0c6efd;">CHỌN NGÀNH XÉT TUYỂN</div>
        <div class="register achievements">
            <div style="flex: 1;">
                <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Chọn ngành</div>
                <select name="id_major" id="chonnganh" required>
                    <option value=""></option>
                    <?php foreach($arr_major_list as $nganh) { ?>
                        <?php echo '<option value="' . $nganh[0] .'">' . $nganh[1] . '</option>'?>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
    <div class="danh_sach_container">
        <table id="danh_sach_inner">
            <tr>
                <th>STT</th>
                <th>Tên thí sinh</th>
                <th>Tổ hợp đăng ký</th>
                <th>Hồ sơ thí sinh</th>
                <th>Access</th>
                <th>Deny</th>
            </tr>
            <tr>
                <td colspan="6">Bạn chưa chọn tổ hợp môn!</td>
            </tr>
            <!-- <div class="danh_sach_inner" id="danh_sach_inner"> -->
            </div>
        </table>
    </div>
    
    </form>
	<!-- End Page content -->
	</div>
	<?php 
		include './layouts/footer.php';
	?>
</div>

<script>
    document.getElementById('chonnganh').addEventListener('change', function() {
        var danhSachAjax = document.getElementById("danh_sach_inner");
        const id_major = this.value;
        // console.log(id_major); 

        const xhr = new XMLHttpRequest();
        xhr.open('POST', "teacher_duyet_ho_so_ajax.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            console.log(this.responseText);
            if (xhr.status === 200) {
                danhSachAjax.innerHTML = this.response;
            } else {
                console.log('Failed to send data');
            }
        };
        xhr.send('id_major=' + id_major);
    });
</script>
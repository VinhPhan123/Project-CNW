<?php 
    include './layouts/header.php';
	include './XuLyPhien/student.php';

    $condition = [
        'id_student' => $_SESSION['id_student']
    ];
    $query_check = select('academic_records', '*', $condition);
    if (mysqli_num_rows($query_check) == 0) {
        echo '<script>alert("Bạn chưa điền học bạ!")</script>';
        header("Refresh:0; url=student_knowled_record.php");
    }
?>

<?php
    $token = md5(uniqid());
?>

<style>
    .infor_text {
        color: #b50206;
        font-weight: bold;
        height: 10px;
    }

    .body_content {
        margin-top: 50px;
    }

    #form_upload_potrait:hover{
        cursor: pointer;
        font-weight: bold;
    }

    #form_upload_potrait {
        overflow: hidden;
    }

    #form_upload_minhchung_chuyen:hover {
        cursor: pointer;
        font-weight: bold;
    }
    #form_upload_minhchung_hsg:hover{
        cursor: pointer;
        font-weight: bold;
    }
    #form_upload_minhchung_otherAchieve:hover{
        cursor: pointer;
        font-weight: bold;
    }
    #form_upload_minhchung_ielts:hover{
        cursor: pointer;
        font-weight: bold;
    }
    #form_upload_minhchung_priority:hover{
        cursor: pointer;
        font-weight: bold;
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

    .achievements {
        width: 1000px;
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
        width: 245px;
        height: 28px;
    }

</style>

<?php
    // lấy ra thông tin student đang đăng nhập
    $condition = [
        'username' => $_SESSION['taiKhoan']
    ];
    $query1 = select('students', '*', $condition); 
    $row = mysqli_fetch_array($query1);
    $id_student = $row['id_student'];
    $fullname = $row['fullname'];
    $ngaysinh = $row['ngaysinh'];
    $phone_number = $row['phone_number'];
    $gender = $row['gender'];
    $address = $row['address'];
    $email = $row['email'];
    $avt = $row['avt'];

?>


<?php
    // lấy ra thuộc tính trường chuyên của 
    $condition = [
        'id_student' => $id_student
    ];
    $r = select('students', '*', $condition);
    
    $row = mysqli_fetch_array($r);

    $string_truongchuyen = $row['truong_chuyen'];
    $array_truongchuyen = explode(" | ", $string_truongchuyen);
 

    // lấy ra thuộc tính giai_hs_gioi của students
    $string_giai_hs_gioi = $row['giai_hs_gioi'];
    $array_giai_hs_gioi = explode(" | ", $string_giai_hs_gioi);


    // lấy ra thuộc tính chung_chi_ielts
    $string_chung_chi_ielts = $row['chung_chi_ielts'];
    $array_chung_chi_ielts = explode(" | ", $string_chung_chi_ielts);


    // lấy ra thuộc tính giai_thuong_khac
    $string_giai_thuong_khac = $row['giai_thuong_khac'];
    $array_giai_thuong_khac = explode(" | ", $string_giai_thuong_khac);

    // lấy ra thuộc tính doi_tuong_uu_tien
    $string_doi_tuong_uu_tien = $row['doi_tuong_uu_tien'];
    $array_doi_tuong_uu_tien = explode(" | ", $string_doi_tuong_uu_tien);

    // lấy ra thuộc tính khu_vuc_uu_tien
    $string_khu_vuc_uu_tien = $row['khu_vuc_uu_tien'];
    $array_khu_vuc_uu_tien = explode(" | ", $string_khu_vuc_uu_tien);

    
   
?>


<?php
    $query2 = select('truongchuyen', '*', '');
    $name_truongchuyen_array = array();
    while($row = mysqli_fetch_array($query2)){
        array_push($name_truongchuyen_array, $row['ten_truong']);
    }
?>

<?php
    // lấy ra những ngành đã được set tổ hợp trong bảng majors và có status hiện, còn thời hạn trong bảng chuyennganh
    $query3 = getAvailableMajors();
    $nganh_duoc_xet_array = array();
    while($row = mysqli_fetch_array($query3)){
        array_push($nganh_duoc_xet_array, $row['major_name']);
    }
?>

<?php
    // tạo thư mục uploads nếu chưa tồn tại
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
?>


<?php
    $check = 1;
    if(isset($_POST['send']) && $_SESSION['token'] == $_POST['_token']){
        // lưu dữ liệu và truongchuyen(nếu có) vảo bảng
        if($_POST['truongchuyen'] != '' && $_POST['lopchuyen'] == ''){
            $message_error_1 = "nhap lop chuyen";
            $check = 0;
        } 
        if($_POST['truongchuyen'] != '' && $_FILES['fileInput_truongchuyen']['name'] == ''){
            $message_error_2 = "upload file";
            if(!isset($array_truongchuyen[2])){
                $check = 0;
            }
        }
        if($_POST['lopchuyen'] != '' && $_POST['truongchuyen'] == ''){
            $message_error_3 = "nhap truong chuyen";
            $check = 0;
        }
        if($_POST['lopchuyen'] != '' && $_FILES['fileInput_truongchuyen']['name'] == ''){
            $message_error_4 = "upload file";
            if(!isset($array_truongchuyen[2])){
                $check = 0;
            }
        }
        if($_FILES['fileInput_truongchuyen']['name'] != '' && $_POST['truongchuyen'] == '') {
            $message_error_5 = "nhap truong chuyen";
            $check = 0;
        }
        if($_FILES['fileInput_truongchuyen']['name'] != '' && $_POST['lopchuyen'] == '') {
            $message_error_6 = "nhap lop chuyen";
            $check = 0;
        }

        if($_FILES['fileInput_truongchuyen']['name'] != '' || $_POST['lopchuyen'] != '' || $_POST['truongchuyen'] != ''){
            if(isset($_POST['truongchuyen'])){
                $_SESSION['truongchuyen'] = $_POST['truongchuyen'];
            }
            if(isset($_POST['lopchuyen'])){
                $_SESSION['lopchuyen'] = $_POST['lopchuyen'];
            }
        }

        if($_FILES['fileInput_truongchuyen']['name'] != '' && $_POST['lopchuyen'] != '' && $_POST['truongchuyen'] != ''){
            $check = uploadFile('fileInput_truongchuyen')['check'];
            $m1 = uploadFile('fileInput_truongchuyen')['m'];
            $a1 = uploadFile('fileInput_truongchuyen')['a'];

        }



        // lưu dữ liệu về giải hs giỏi(nếu có)
        if($_POST['monthi'] != '' && $_POST['giai'] == ''){
            $message_error_7 = "nhap giai";
            $check = 0;
        } 
        if($_POST['monthi'] != '' && $_FILES['fileInput_hsg']['name'] == ''){
            $message_error_8 = "upload file";
            if(!isset($array_giai_hs_gioi[2])){
                $check = 0;
            }
        }
        if($_POST['giai'] != '' && $_POST['monthi'] == ''){
            $message_error_9 = "nhap mon thi";
            $check = 0;
        }
        if($_POST['giai'] != '' && $_FILES['fileInput_hsg']['name'] == ''){
            $message_error_10 = "upload file";
            if(!isset($array_giai_hs_gioi[2])){
                $check = 0;
            }
        }
        if($_FILES['fileInput_hsg']['name'] != '' && $_POST['monthi'] == '') {
            $message_error_11 = "nhap mon thi";
            $check = 0;
        }
        if($_FILES['fileInput_hsg']['name'] != '' && $_POST['giai'] == '') {
            $message_error_12 = "nhap giai";
            $check = 0;
        }

        if($_FILES['fileInput_hsg']['name'] != '' || $_POST['monthi'] != '' || $_POST['giai'] != ''){
            if(isset($_POST['giai'])){
                $_SESSION['giai'] = $_POST['giai'];
            }
            if(isset($_POST['monthi'])){
                $_SESSION['monthi'] = $_POST['monthi'];
            }
        }


        if($_FILES['fileInput_hsg']['name'] != '' && $_POST['monthi'] != '' && $_POST['giai'] != ''){
            $check = uploadFile('fileInput_hsg')['check'];
            $m2 = uploadFile('fileInput_hsg')['m'];
            $a2 = uploadFile('fileInput_hsg')['a'];
        }



        // lưu dữ liệu về các giải thưởng khác
        if($_POST['giaithuongkhac'] != '' && $_FILES['fileInput_otherAchieve']['name'] == ''){
            $message_error_13 = "upload file";
            if(!isset($array_giai_thuong_khac[1])){
                $check = 0;
            }
        } 
        if($_FILES['fileInput_otherAchieve']['name'] != '' && $_POST['giaithuongkhac'] == '') {
            $message_error_14 = "mo ta giai thuong";
            $check = 0;
        }

        if(isset($_POST['giaithuongkhac'])){
            $_SESSION['giaithuongkhac'] = $_POST['giaithuongkhac'];
        }

        if($_FILES['fileInput_otherAchieve']['name'] != '' && $_POST['giaithuongkhac'] != ''){
            $check = uploadFile('fileInput_otherAchieve')['check'];
            $m3 = uploadFile('fileInput_otherAchieve')['m'];
            $a3 = uploadFile('fileInput_otherAchieve')['a'];
        }


        // lưu dữ liệu chứng chỉ ielts
        if($_POST['machungnhan'] != '' && $_POST['diem'] == ''){
            $message_error_15 = "nhap diem";
            $check = 0;
        } 
        if($_POST['machungnhan'] != '' && $_FILES['fileInput_ielts']['name'] == ''){
            $message_error_16 = "upload file";
            if(!isset($array_chung_chi_ielts[2])){
                $check = 0;
            }
        }
        if($_POST['diem'] != '' && $_POST['machungnhan'] == ''){
            $message_error_17 = "nhap ma chung nhan";
            $check = 0;
        }
        if($_POST['diem'] != '' && $_FILES['fileInput_ielts']['name'] == ''){
            $message_error_18 = "upload file";
            if(!isset($array_chung_chi_ielts[2])){
                $check = 0;
            }
        }
        if($_FILES['fileInput_ielts']['name'] != '' && $_POST['machungnhan'] == '') {
            $message_error_19 = "nhap ma chung nhan";
            $check = 0;
        }
        if($_FILES['fileInput_ielts']['name'] != '' && $_POST['diem'] == '') {
            $message_error_20 = "nhap diem";
            $check = 0;
        }

        if($_FILES['fileInput_ielts']['name'] != '' || $_POST['machungnhan'] != '' || $_POST['diem'] != ''){
            if(isset($_POST['machungnhan'])){
                $_SESSION['machungnhan'] = $_POST['machungnhan'];
            }
            if(isset($_POST['diem'])){
                $_SESSION['diem'] = $_POST['diem'];
            }
        }


        if($_FILES['fileInput_ielts']['name'] != '' && $_POST['diem'] != '' && $_POST['machungnhan'] != ''){
            $check = uploadFile('fileInput_ielts')['check'];
            $m5 = uploadFile('fileInput_ielts')['m'];
            $a5 = uploadFile('fileInput_ielts')['a'];
        }


        // lưu dữ liệu về đối tượng ưu tiên
        if($_POST['doituonguutien'] != '' && $_FILES['fileInput_priority']['name'] == ''){
            $message_error_21 = "upload file";
            // vì khi reload trang vẫn lưu dữ liệu trong thẻ file=type
            if(!isset($array_doi_tuong_uu_tien[1])){
                $check = 0;
            }
        } 
        if($_FILES['fileInput_priority']['name'] != '' && $_POST['doituonguutien'] == ''){
            $message_error_22 = "nhap doi tuong uu tien";
            
        }


        if($_FILES['fileInput_priority']['name'] != '' || $_POST['doituonguutien'] != ''){
            if(isset($_POST['doituonguutien'])){
                $_SESSION['doituonguutien'] = $_POST['doituonguutien'];
            }
        }


        if($_FILES['fileInput_priority']['name'] != '' && $_POST['doituonguutien'] != ''){
            $check = uploadFile('fileInput_priority')['check'];
            $m4 = uploadFile('fileInput_priority')['m'];
            $a4 = uploadFile('fileInput_priority')['a'];
        }

        
        // lưu dữ liệu về khu vực ưu tiên
        if($_POST['khuvuc'] != ''){
            if(isset($_POST['khuvuc'])){
                $_SESSION['khuvuc'] = $_POST['khuvuc'];
            }
        }
        if($_POST['khuvuc'] == ''){
            $value = [
                'khu_vuc_uu_tien' => ''
            ];
            $condition = [
                'id_student' => $id_student
            ];
            update('students', $value, $condition);
        }



    }
?>

<?php
    // xử lí chọn ngành và tổ hợp
    if(isset($_POST['send']) && ($_SESSION['token'] == $_POST['_token']) && $check == 1 && isset($_POST["diemsan"])){
        if($_POST['chonnganh']!='' && $_POST['toHopDangKy']!=''){
            $nganh = $_POST['chonnganh'];
            $tohopdangky = $_POST['toHopDangKy'];


            $diemsan = $_POST["diemsan"];

            $condition = [
                'id_student' => $id_student
            ];

            $query7 = select('academic_records', '*', $condition);

            $assoc_academic = mysqli_fetch_assoc($query7);
            // tạo array lưu các môn với tổ hợp tương ứng
            $array_mon = array();

            $condition = [
                'id_SB' => $tohopdangky
            ];
            $query8 = select('subject_combination', '*', $condition);
            $row = mysqli_fetch_array($query8);

            if ($row) { // Kiểm tra xem có dữ liệu không
                array_push($array_mon, $row['sub_1']);
                array_push($array_mon, $row['sub_2']);
                array_push($array_mon, $row['sub_3']);
            }

            // lấy ra tổng điểm các môn của tổ hợp tương ứng
            $mark = 0;
            foreach($assoc_academic as $index => $value){
                if($index == 'Toan') {
                    $mon_hoc = 'Toán';
                } else if($index == 'NguVan') {
                    $mon_hoc = 'Ngữ Văn';
                } else if($index == 'TiengAnh') {
                    $mon_hoc = 'Tiếng Anh';
                } else if($index == 'VatLy') {
                    $mon_hoc = 'Vật Lý';
                } else if($index == 'HoaHoc') {
                    $mon_hoc = 'Hóa Học';
                } else if($index == 'SinhHoc') {
                    $mon_hoc = 'Sinh Học';
                } else if($index == 'LichSu') {
                    $mon_hoc = 'Lịch Sử';
                } else if($index == 'DiaLy') {
                    $mon_hoc = 'Địa Lý';
                } else if($index == 'TinHoc') {
                    $mon_hoc = 'Tin Học';
                } else if($index == 'CongNghe') {
                    $mon_hoc = 'Công Nghệ';
                } else if($index == 'GiaoDucCongDan') {
                    $mon_hoc = 'Giáo Dục Công Dân';
                } else if($index == 'GiaoDucTheChat') {
                    $mon_hoc = 'Giáo Dục Thể Chất';
                } else {
                    continue;
                }
                foreach($array_mon as $mon){
                    // echo $mon . '-';
                    if($mon_hoc === $mon) {
                        $mark += $value;
                    }
                }
            }

            if($mark >= $diemsan){
                $condition = [
                    'major_name' => $nganh
                ];
    
                $result = select('majors', '*', $condition);

                $id_major = mysqli_fetch_array($result)['id_major'];
                
    
                // kiểm tra nếu chuyên ngành-tổ hợp đã được nộp trước đó chưa, nếu có rồi thì báo Chuyên ngành - tổ hợp đã đăng ký trước đó
                $condition = [
                    'id_student' => $id_student,
                    'id_major' => $id_major,
                    'id_SB' => $tohopdangky
                ];
    
                $query_ledgers = select('ledgers', '*', $condition);

                $count_row = mysqli_num_rows($query_ledgers);

                if($count_row > 0 && isset($_POST['send'])){
                    $check = 0;
                    ?>
                    <script>
                        alert("Ngành và tổ hợp đã được đăng ký trước đó !");
                        location.reload(true);
                    </script>
                    <?php
                } else {
                    $data = [
                        'id_student' => $id_student,
                        'id_major' => $id_major,
                        'id_SB' => $tohopdangky,
                        'score' => $mark,
                    ];
                    $res = insert('ledgers', $data);
                    if($res) {
                        ?>
                        <script>
                            alert("Nop ho so thanh cong!");
                            location.reload(true);
                        </script>
                        <?php
                    }
                }
            } else {
                ?>
                <script>
                    alert("Yêu cầu đăng ký thất bại \n Điểm học bạ thấp hơn điểm sàn!");
                </script>
                <?php
            }
        }
    }
?>

<?php
    if(isset($_POST['send']) && $_SESSION['token'] == $_POST['_token'] && $check==1){
        if($_FILES['fileInput_truongchuyen']['name'] == '' && $_POST['lopchuyen'] == '' && $_POST['truongchuyen'] == ''){
            update('students', ['truong_chuyen'=>''], ['id_student'=>$id_student]);
        }

        if($_FILES['fileInput_hsg']['name'] == '' && $_POST['giai'] == '' && $_POST['monthi'] == ''){
            update('students', ['giai_hs_gioi'=>''], ['id_student'=>$id_student]);
        }

        if($_FILES['fileInput_otherAchieve']['name'] == '' && $_POST['giaithuongkhac'] == ''){
            update('students', ['giai_thuong_khac'=>''], ['id_student'=>$id_student]);
        }

        if($_FILES['fileInput_ielts']['name'] == '' && $_POST['diem']== '' && $_POST['machungnhan'] == ''){
            update('students', ['chung_chi_ielts'=>''], ['id_student'=>$id_student]);
        }

        if($_FILES['fileInput_priority']['name'] == '' && $_POST['doituonguutien'] == ''){
            update('students', ['fileInput_priority'=>''], ['id_student'=>$id_student]);
        }

    }
?>


<?php
    if(isset($_POST['send']) && $_SESSION['token'] == $_POST['_token'] && $check==1){
        if($check==1){
        // nếu check=1, insert truongchuyen
            $truong_chuyen = $_POST['truongchuyen'];
            $lop_chuyen = $_POST['lopchuyen'];
            $data_parts = [$truong_chuyen, $lop_chuyen];
            uploadAndUpdate($upload_dir, $id_student, 'truong_chuyen', $data_parts, 'fileInput_truongchuyen');


        // check=1, insert giai_hsg
            $monthi = $_POST['monthi'];
            $giai = $_POST['giai'];
            $data_parts = [$monthi, $giai];
            uploadAndUpdate($upload_dir, $id_student, 'giai_hs_gioi', $data_parts, 'fileInput_hsg');

        // check=1, insert giai_thuong_khac
            $giaithuongkhac = $_POST['giaithuongkhac'];
            $file_name = $_FILES['fileInput_otherAchieve']['name'];
            $data_parts = [$giaithuongkhac];
            uploadAndUpdate($upload_dir, $id_student, 'giai_thuong_khac', $data_parts, 'fileInput_otherAchieve');

        // check=1, insert chung_chi_ielts
            $ma_chung_nhan = $_POST['machungnhan'];
            $diem = $_POST['diem'];
            $data_parts = [$ma_chung_nhan, $diem];
            uploadAndUpdate($upload_dir, $id_student, 'chung_chi_ielts', $data_parts, 'fileInput_ielts');

        // check=1, insert doi_tuong_uu_tien
            $doi_tuong_uu_tien = $_POST['doituonguutien'];
            $data_parts = [$doi_tuong_uu_tien];
            uploadAndUpdate($upload_dir, $id_student, 'doi_tuong_uu_tien', $data_parts, 'fileInput_priority');

        // check=1, insert khu_vuc_uu_tien
            $khu_vuc_uu_tien = $_POST['khuvuc'];
            update('students', ['khu_vuc_uu_tien' => $khu_vuc_uu_tien], ['id_student' => $id_student]);

        // xóa các session trong ô input, select thay vào đó là dữ liệu đã được insert
            unset($_SESSION['truongchuyen']);
            unset($_SESSION['lopchuyen']);
            unset($_SESSION['giai']);
            unset($_SESSION['monthi']);
            unset($_SESSION['giaithuongkhac']);
            unset($_SESSION['khuvuc']);
            unset($_SESSION['machungnhan']);
            unset($_SESSION['diem']);
            unset($_SESSION['doituonguutien']);

        }
    }
?>



<?php
    if(isset($_FILES['fileInput_potrait']) && isset($_POST['send']) && ($_SESSION['token'] == $_POST['_token'])){
        $fileInput_potrait_name = $_FILES['fileInput_potrait']['name'];
        echo $fileInput_potrait_name;
    }
?>


<div style="display: flex; justify-content: center;">

<?php 
    if(isset($_SESSION['role'])) {
		include './layouts/menu.php';
	}
?>

<div class="body_content" style="display: block; width: 100%;">
	
<form id="form" method="post" enctype="multipart/form-data">
    <div class="container" style="width: 1000px;">
        <div class="infor_text">
            THÔNG TIN CÁ NHÂN
        </div>
        <hr>

        <div class="infor_content">
            <div class="left_content">
                <div>
                    <input type="file" id="fileInput_potrait" name="fileInput_potrait" accept="image/*" hidden>
                    <img id="preview" src="<?php if($avt != null) {echo $avt;} ?>"><br>
                </div>
    
                <span id="form_upload_potrait" style="color: #000; display: none;">
                    <i class="ti-cloud-up"></i>
                    <span style="font-size: 12px;">Tải lên</span>
                </span>
            </div>
            
            <div class="mid_content">
                <div>
                    <label>Họ và tên</label>
                    <input type="text" value="<?php echo $fullname ?>" readonly>
                </div>

                <div>
                    <label>Ngày sinh</label>
                    <input type="date" value="<?php echo $ngaysinh ?>" readonly>
                </div>

                <div>
                    <label>Giới tính</label>
                    <select name="" id="" disabled>
                        <option value=""></option>
                        <option value="nam" <?php echo ($gender=='Nam') ? 'selected' : '' ?>>Nam</option>
                        <option value="nu" <?php echo ($gender=='Nữ') ? 'selected' : '' ?>>Nữ</option>
                    </select>
                </div>


            </div>

            <div class="right_content">
                <div>
                    <label>Email</label>
                    <input type="email" value="<?php echo $email ?>" readonly>
                </div>

                <div>
                    <label>Số điện thoại</label>
                    <input type="text" value="<?php echo $phone_number ?>" readonly>
                </div>

                <div>
                    <label>Địa chỉ</label>
                    <input type="text" value="<?php echo $address ?>" readonly>
                </div>
            </div>
        </div>


        <div class="thanh_tich" style="font-size: 18px; font-weight: bold; color: #b50206;">1. Thành tích học tập</div>
        <div class="academic_achivements">

        <!-- trường chuyên -->
            <div class="mb_top_8px" style="font-weight: 600;">1.1. Minh chứng lớp chuyên (nếu có)</div>
            <div class="achievements">
                <div>
                    <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Trường chuyên</div>
                    <span class="red" style="position: absolute; top: 8px; left: 116px;"><?php if(!isset($array_truongchuyen[0])){echo (isset($message_error_3)||isset($message_error_5)) ? "nhap truong chuyen" : "";}?></span>
                    <select name="truongchuyen" id="">
                        <option value=""></option>
                        <?php
                            foreach($name_truongchuyen_array as $ten_truong){ ?>
                                <option 
                                    <?php 
                                        if ($array_truongchuyen[0] == $ten_truong) {
                                            echo 'selected'; 
                                        } else {
                                            if(isset($_SESSION['truongchuyen'])){
                                                if($_SESSION['truongchuyen'] == $ten_truong){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> 
                                    value="<?php echo htmlspecialchars($ten_truong); ?>">
                                    <?php echo htmlspecialchars($ten_truong); ?>
                                </option>
                        <?php } ?>
                    </select>
                </div>

                <div>
                    <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Lớp chuyên</div>
                    <span class="red" style="position: absolute; top: 8px; right: 330px;">
                        <?php echo (isset($message_error_1)||isset($message_error_6)) ? "nhap lop chuyen" : "" ?>
                    </span>
                    <input name="lopchuyen" type="text" placeholder="Lớp chuyên(vd: chuyên hóa)" value=
                        "<?php if(isset($array_truongchuyen[1])){
                            echo $array_truongchuyen[1];
                        } else {
                            if(isset($_SESSION['lopchuyen'])){
                                echo $_SESSION['lopchuyen'];
                            }
                        } ?>">
                </div>

                <div style="position: relative; display: flex; flex-direction: column; justify-content: space-between; width: 100px; height: 72px;">
                    <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Minh chứng</div>
                    <span class="red" style="width: 108px; text-align: left; position: absolute; top: 8px; right: -99px;">
                        <?php if(isset($m1)){
                            echo $m1;
                        } else if(isset($a1)) {
                            echo $a1;
                        } else {
                            if(!isset($array_truongchuyen[2])){echo (isset($message_error_2) || isset($message_error_4)) ? "upload file" : "";}
                        }
                        ?>
                    </span>
                    <input type="file" id="fileInput_truongchuyen" name="fileInput_truongchuyen" style="visibility: hidden; position: absolute; top: 31px; font-size: 10px; left: 0px;">
                    <span id="form_upload_minhchung_chuyen" style=" color: #000; height: 22px;">
                        <i class="ti-cloud-up"></i>
                        <span style="font-size: 12px;">Tải lên</span>
                    </span>
                </div>
            </div>


            <!-- Giải hs giỏi -->
            <div class="mb_top_8px" style="font-weight: 600;">1.2. Giải học sinh giỏi (nếu có)</div>
            <div class="achievements">
                <div>
                    <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Môn thi</div>
                    <span class="red" style="position: absolute; top: 8px; left: 69px;"><?php echo (isset($message_error_9)||isset($message_error_11)) ? "nhap mon thi" : "" ?></span>
                    <select name="monthi" id="">
                        <option value=""></option>
                        <option value="Toán" <?php 
                                        if ($array_giai_hs_gioi[0] == "Toán") {
                                            echo 'selected'; 
                                        } else {
                                            if(isset($_SESSION['truongchuyen'])){
                                                if($_SESSION['truongchuyen'] == 'Toán'){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >Toán</option>
                        <option value="Ngữ văn" <?php 
                                        if ($array_giai_hs_gioi[0] == "Ngữ văn") {
                                            echo 'selected'; 
                                        } else {
                                            if(isset($_SESSION['monthi'])){
                                                if($_SESSION['monthi'] == 'Ngữ văn'){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >Ngữ văn</option>
                        <option value="Tiếng Anh" <?php 
                                        if ($array_giai_hs_gioi[0] == "Tiếng Anh") {
                                            echo 'selected'; 
                                        } else {
                                            if(isset($_SESSION['monthi'])){
                                                if($_SESSION['monthi'] == 'Tiếng Anh'){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >Tiếng Anh</option>
                        <option value="Vật lý" <?php 
                                        if ($array_giai_hs_gioi[0] == "Vật lý") {
                                            echo 'selected'; 
                                        } else {
                                            if(isset($_SESSION['monthi'])){
                                                if($_SESSION['monthi'] == 'Vật lý'){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >Vật lý</option>
                        <option value="Hóa học" <?php 
                                        if ($array_giai_hs_gioi[0] == "Hóa học") {
                                            echo 'selected'; 
                                        } else {
                                            if(isset($_SESSION['monthi'])){
                                                if($_SESSION['monthi'] == 'Hóa học'){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >Hóa học</option>
                        <option value="Sinh học" <?php 
                                        if ($array_giai_hs_gioi[0] == "Sinh học") {
                                            echo 'selected'; 
                                        } else {
                                            if(isset($_SESSION['monthi'])){
                                                if($_SESSION['monthi'] == 'Sinh học'){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >Sinh học</option>
                        <option value="Lịch sử" <?php 
                                        if ($array_giai_hs_gioi[0] == "Lịch sử") {
                                            echo 'selected'; 
                                        } else {
                                            if(isset($_SESSION['monthi'])){
                                                if($_SESSION['monthi'] == 'Lịch sử'){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >Lịch sử</option>
                        <option value="Địa lý" <?php 
                                        if ($array_giai_hs_gioi[0] == "Địa lý") {
                                            echo 'selected'; 
                                        } else {
                                            if(isset($_SESSION['monthi'])){
                                                if($_SESSION['monthi'] == 'Địa lý'){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >Địa lý</option>
                        <option value="Tin học" <?php 
                                        if ($array_giai_hs_gioi[0] == "Tin học") {
                                            echo 'selected'; 
                                        } else {
                                            if(isset($_SESSION['monthi'])){
                                                if($_SESSION['monthi'] == 'Tin học'){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >Tin học</option>
                        <option value="Công nghệ" <?php 
                                        if ($array_giai_hs_gioi[0] == "Công nghệ") {
                                            echo 'selected'; 
                                        } else {
                                            if(isset($_SESSION['monthi'])){
                                                if($_SESSION['monthi'] == 'Công nghệ'){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >Công nghệ</option>
                        <option value="Giáo dục công dân" <?php 
                                        if ($array_giai_hs_gioi[0] == "Giáo dục công dân") {
                                            echo 'selected'; 
                                        } else {
                                            if(isset($_SESSION['monthi'])){
                                                if($_SESSION['monthi'] == 'Giáo dục công dân'){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >Giáo dục công dân</option>
                        <option value="Giáo dục thể chất" <?php 
                                        if ($array_giai_hs_gioi[0] == "Giáo dục thể chất") {
                                            echo 'selected'; 
                                        } else {
                                            if(isset($_SESSION['monthi'])){
                                                if($_SESSION['monthi'] == 'Giáo dục thể chất'){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >Giáo dục thể chất</option>
                    </select>
                </div>

                <div>
                    <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Giải</div>
                    <span class="red" style="position: absolute; top: 8px; right: 446px;"><?php echo (isset($message_error_7)||isset($message_error_12)) ? "nhap giai" : "" ?></span>
                    <select name="giai" id="">
                        <option value=""></option>
                        <option value="Nhất" <?php 
                                        if (isset($array_giai_hs_gioi[1])) {
                                            echo $array_giai_hs_gioi[1]=="Nhất" ? "selected" : "";
                                        } else {
                                            if(isset($_SESSION['giai'])){
                                                if($_SESSION['giai'] == "Nhất"){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >Nhất</option>
                        <option value="Nhì" <?php 
                                        if (isset($array_giai_hs_gioi[1])) {
                                            echo $array_giai_hs_gioi[1]=="Nhì" ? "selected" : "";
                                        } else {
                                            if(isset($_SESSION['giai'])){
                                                if($_SESSION['giai'] == "Nhì"){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >Nhì</option>
                        <option value="Ba" <?php 
                                        if (isset($array_giai_hs_gioi[1])) {
                                            echo $array_giai_hs_gioi[1]=="Ba" ? "selected" : "";
                                        } else {
                                            if(isset($_SESSION['giai'])){
                                                if($_SESSION['giai'] == "Ba"){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >Ba</option>
                        <option value="Khuyến khích" <?php 
                                        if (isset($array_giai_hs_gioi[1])) {
                                            echo $array_giai_hs_gioi[1]=="Khuyến khích" ? "selected" : "";
                                        } else {
                                            if(isset($_SESSION['giai'])){
                                                if($_SESSION['giai'] == "Khuyến khích"){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >Khuyến khích</option>
                    </select>
                </div>

                <div style="position: relative; display: flex; flex-direction: column; justify-content: space-between; width: 100px; height: 72px;">
                <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Minh chứng</div>
                <span class="red" style="width: 108px; text-align: left; position: absolute; top: 8px; right: -99px;">
                    <?php if(isset($m2)){
                            echo $m2;
                    }else if(isset($a2)) {
                        echo $a2;
                    } else {
                        if(!isset($array_giai_hs_gioi[2])){echo (isset($message_error_8) || isset($message_error_10)) ? "upload file" : "";}
                    }
                    ?>
                </span>
                <input type="file" id="fileInput_hsg" name="fileInput_hsg" style="visibility: hidden; position: absolute; top: 31px; font-size: 10px; left: 0px;">
                <span id="form_upload_minhchung_hsg" style=" color: #000; height: 22px;">
                        <i class="ti-cloud-up"></i>
                        <span style="font-size: 12px;">Tải lên</span>
                    </span>
                </div>
            </div>


            <!-- Chứng chỉ ielts -->
            <div class="mb_top_8px" style="font-weight: 600;">1.3. Chứng chỉ ielts (nếu có)</div>
            <div class="achievements">
                <div>
                    <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Mã chứng nhận</div>
                    <span class="red" style="position: absolute; top: 8px; left: 120px;"><?php echo (isset($message_error_17)||isset($message_error_19)) ? "nhap ma chung nhan" : "" ?></span>
                    <input type="text" name="machungnhan" value=
                    "<?php if(isset($array_chung_chi_ielts[0]) && $array_chung_chi_ielts[0]!=""){
                            echo $array_chung_chi_ielts[0];
                        } else {
                            if(isset($_SESSION['machungnhan'])){
                                echo $_SESSION['machungnhan'];
                            }
                    }?>">
                </div>

                <div>
                    <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Điểm</div>
                    <span class="red" style="position: absolute; top: 8px; right: 426px;"><?php echo (isset($message_error_15)||isset($message_error_20)) ? "nhap diem" : "" ?></span>
                    <select name="diem" id="">
                        <option value=""></option>
                        <option value="4.5" <?php 
                                        if (isset($array_chung_chi_ielts[1])) {
                                            echo $array_chung_chi_ielts[1]=="4.5" ? "selected" : "";
                                        } else {
                                            if(isset($_SESSION['diem'])){
                                                if($_SESSION['diem'] == "4.5"){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >4.5</option>
                        <option value="5" <?php 
                                        if (isset($array_chung_chi_ielts[1])) {
                                            echo $array_chung_chi_ielts[1]=="5" ? "selected" : "";
                                        } else {
                                            if(isset($_SESSION['diem'])){
                                                if($_SESSION['diem'] == "5"){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >5</option>
                        <option value="5.5" <?php 
                                        if (isset($array_chung_chi_ielts[1])) {
                                            echo $array_chung_chi_ielts[1]=="5.5" ? "selected" : "";
                                        } else {
                                            if(isset($_SESSION['diem'])){
                                                if($_SESSION['diem'] == "5.5"){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >5.5</option>
                        <option value="6" <?php 
                                        if (isset($array_chung_chi_ielts[1])) {
                                            echo $array_chung_chi_ielts[1]=="6" ? "selected" : "";
                                        } else {
                                            if(isset($_SESSION['diem'])){
                                                if($_SESSION['diem'] == "6"){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >6</option>
                        <option value="6.5" <?php 
                                        if (isset($array_chung_chi_ielts[1])) {
                                            echo $array_chung_chi_ielts[1]=="6.5" ? "selected" : "";
                                        } else {
                                            if(isset($_SESSION['diem'])){
                                                if($_SESSION['diem'] == "6.5"){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >6.5</option>
                        <option value="7" <?php 
                                        if (isset($array_chung_chi_ielts[1])) {
                                            echo $array_chung_chi_ielts[1]=="7" ? "selected" : "";
                                        } else {
                                            if(isset($_SESSION['diem'])){
                                                if($_SESSION['diem'] == "7"){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >7</option>
                        <option value="7.5" <?php 
                                        if (isset($array_chung_chi_ielts[1])) {
                                            echo $array_chung_chi_ielts[1]=="7.5" ? "selected" : "";
                                        } else {
                                            if(isset($_SESSION['diem'])){
                                                if($_SESSION['diem'] == "7.5"){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >7.5</option>
                        <option value="8" <?php 
                                        if (isset($array_chung_chi_ielts[1])) {
                                            echo $array_chung_chi_ielts[1]=="8" ? "selected" : "";
                                        } else {
                                            if(isset($_SESSION['diem'])){
                                                if($_SESSION['diem'] == "8"){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >8</option>
                        <option value="8.5" <?php 
                                        if (isset($array_chung_chi_ielts[1])) {
                                            echo $array_chung_chi_ielts[1]=="8.5" ? "selected" : "";
                                        } else {
                                            if(isset($_SESSION['diem'])){
                                                if($_SESSION['diem'] == "8.5"){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >8.5</option>
                        <option value="9" <?php 
                                        if (isset($array_chung_chi_ielts[1])) {
                                            echo $array_chung_chi_ielts[1]=="9" ? "selected" : "";
                                        } else {
                                            if(isset($_SESSION['diem'])){
                                                if($_SESSION['diem'] == "9"){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >9</option>
                    </select>
                </div>

                <div style="position: relative; display: flex; flex-direction: column; justify-content: space-between; width: 100px; height: 72px;">
                    <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Minh chứng</div>
                    <span class="red" style="width: 108px; text-align: left; position: absolute; top: 8px; right: -99px;">
                        <?php if(isset($m5)){
                            echo $m5;
                        } else if(isset($a5)) {
                            echo $a5;
                        } else {
                            if(!isset($array_chung_chi_ielts[2])){echo (isset($message_error_16) || isset($message_error_18)) ? "upload file" : "";}
                        }
                        ?>
                    </span>
                    <input type="file" id="fileInput_ielts" name="fileInput_ielts" style="visibility: hidden; position: absolute; top: 31px; font-size: 10px; left: 0px;">
                    <span id="form_upload_minhchung_ielts" style=" color: #000; height: 22px;">
                        <i class="ti-cloud-up"></i>
                        <span style="font-size: 12px;">Tải lên</span>
                    </span>
                </div>
            </div>


            <div class="mb_top_8px" style="font-weight: 600;">1.4. Các thành tích giải thưởng khác</div>
            <div class="achievements">
                <div>
                    <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Mô tả</div>
                    <span class="red" style="position: absolute; top: 8px; left: 60px;"><?php echo isset($message_error_14) ? "mo ta giai thuong" : "" ?></span>
                    <input name="giaithuongkhac" type="text" value=
                    "<?php if(isset($array_giai_thuong_khac[0]) && $array_giai_thuong_khac[0]!=""){
                            echo $array_giai_thuong_khac[0];
                        } else {
                            if(isset($_SESSION['giaithuongkhac'])){
                                echo $_SESSION['giaithuongkhac'];
                            }
                    }?>">
                </div>

                <div style="position: relative; display: flex; flex-direction: column; justify-content: space-between; width: 100px; height: 72px;">
                    <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Minh chứng</div>
                    <span class="red" style="width: 108px; text-align: left; position: absolute; top: 8px; right: -99px;">
                        <?php if(isset($m3)){
                            echo $m3;
                        } else if(isset($a3)) {
                            echo $a3;
                        } else {
                            if(!isset($array_giai_thuong_khac[1])){echo isset($message_error_13) ? "upload file" : "";}
                        }
                        ?>
                    </span>
                    <input type="file" id="fileInput_otherAchieve" name="fileInput_otherAchieve" style="visibility: hidden; position: absolute; top: 31px; font-size: 10px; left: 0px;">
                    <span id="form_upload_minhchung_otherAchieve" style=" color: #000; height: 22px;">
                            <i class="ti-cloud-up"></i>
                            <span style="font-size: 12px;">Tải lên</span>
                        </span>
                </div>
            </div>
        </div>


        <!-- Điểm ưu tiên -->
        <div class="diem_uu_tien" style="font-size: 18px; font-weight: bold; color: #b50206;">2. Điểm ưu tiên</div>
        <div class="priority_point achievements">
            <div>
                <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Khu vực</div>
                <span class="red" style="position: absolute; top: 8px; left: 69px;"><?php echo (isset($message_error_23)||isset($message_error_25)) ? "nhap khu vuc" : "" ?></span>
                <select name="khuvuc" id="">
                    <option value=""></option>
                    <option value="Khu vực 1" <?php 
                                        if ($array_khu_vuc_uu_tien[0] == "Khu vực 1") {
                                            echo 'selected'; 
                                        } else {
                                            if(isset($_SESSION['khuvuc'])){
                                                if($_SESSION['khuvuc'] == "Khu vực 1"){
                                                    echo 'selected';
                                                }
                                            }
                                        }
                                    ?> >Khu vực 1</option>
                    <option value="Khu vực 2" <?php 
                                        if ($array_khu_vuc_uu_tien[0] == "Khu vực 2") {
                                            echo 'selected'; 
                                        } else {
                                            if(isset($_SESSION['khuvuc'])){
                                                if($_SESSION['khuvuc'] == "Khu vực 2"){
                                                    echo 'selected';
                                                }
                                            }
                                        }
                                    ?> >Khu vực 2</option>
                    <option value="Khu vực 3" <?php 
                                        if ($array_khu_vuc_uu_tien[0] == "Khu vực 3") {
                                            echo 'selected'; 
                                        } else {
                                            if(isset($_SESSION['khuvuc'])){
                                                if($_SESSION['khuvuc'] == "Khu vực 3"){
                                                    echo 'selected';
                                                }
                                            }
                                        }
                                    ?> >Khu vực 3</option>
                </select>
            </div>

            <div>
                <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Đối tượng ưu tiên</div>
                <span class="red" style="position: absolute; top: 8px; right: 250px;"><?php echo (isset($message_error_22)) ? "nhap doi tuong uu tien" : "" ?></span>
                <input name="doituonguutien" type="text" value=
                "<?php if(isset($array_doi_tuong_uu_tien[0]) && $array_doi_tuong_uu_tien[0]!=""){
                            echo $array_doi_tuong_uu_tien[0];
                        } else {
                            if(isset($_SESSION['doituonguutien'])){
                                echo $_SESSION['doituonguutien'];
                            }
                    }?>">
            </div>

            <div style="position: relative; display: flex; flex-direction: column; justify-content: space-between; width: 100px; height: 72px;">
                <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Minh chứng</div>
                <span class="red" style="width: 108px; text-align: left; position: absolute; top: 8px; right: -99px;">
                    <?php if(isset($m4)){
                            echo $m4;
                        } else if(isset($a4)) {
                            echo $a4;
                        } else {
                            if(!isset($array_doi_tuong_uu_tien[1])){echo (isset($message_error_21)) ? "upload file" : "";}
                        }
                        ?>
                </span>
                <input type="file" id="fileInput_priority" name="fileInput_priority" style="visibility: hidden; position: absolute; top: 31px; font-size: 10px; left: 0px;">
                <span id="form_upload_minhchung_priority" style=" color: #000; height: 22px;">
                    <i class="ti-cloud-up"></i>
                    <span style="font-size: 12px;">Tải lên</span>
                </span>
            </div>
        </div>

        <div class="nguyen_vong" style="font-size: 18px; font-weight: bold; color: #b50206;">3. Đăng ký nguyện vọng xét tuyển</div>
        <div class="register achievements">
            <div style="flex: 1;">
                <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Chọn ngành</div>
                <select name="chonnganh" id="chonnganh" required>
                    <option value=""></option>
                    <?php foreach($nganh_duoc_xet_array as $ten_nganh) { ?>
                        <?php echo '<option value="' . $ten_nganh .'">' . $ten_nganh . '</option>'?>
                    <?php } ?>
                </select>
            </div>


            <div style="flex: 1.25;">
                <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Tổ hợp đăng ký</div>
                <select name="toHopDangKy" id="toHopDangKy" required>
                    <option value=""></option>
                </select>
            </div>

            <div style="position: absolute; right: 34px;">
                <span id="insert_diem_san"></span>
            </div>
        </div>

        <br><br>
        <input type="submit" class="btn btn-primary" value="Nộp hồ sơ" name="send" style="text-align: center; width: 100%; height: 36px; color: #fff;"/>
        <input type="hidden" name="_token" value="<?php echo $token ?>">
        <?php $_SESSION['token'] = $token; ?>
    </div>

</form>


	<?php 
		include './layouts/footer.php';
	?>
</div>

<script>
        const fileInput_potrait = document.getElementById('fileInput_potrait');
        const fileInput_truongchuyen = document.getElementById('fileInput_truongchuyen');
        const fileInput_hsg = document.getElementById('fileInput_hsg');
        const fileInput_ielts = document.getElementById('fileInput_ielts');
        const fileInput_otherAchieve = document.getElementById('fileInput_otherAchieve');
        const fileInput_priority = document.getElementById('fileInput_priority');


        const formUploadPotrait = document.getElementById('form_upload_potrait');
        const formUploadChuyen = document.getElementById('form_upload_minhchung_chuyen');
        const formUploadHsg = document.getElementById('form_upload_minhchung_hsg');
        const formUploadOtherAchieve = document.getElementById('form_upload_minhchung_otherAchieve');
        const formUploadielts = document.getElementById('form_upload_minhchung_ielts');
        const formUploadPrior = document.getElementById('form_upload_minhchung_priority');




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

        function listenUploadFile(upload, inputTag){
            upload.addEventListener('click', function() {
                inputTag.click();
            });

            inputTag.addEventListener('change', function(event) {
                const file = event.target.files[0];
                
                if (file) {
                    inputTag.style.visibility = "visible";
                } else {
                    inputTag.style.visibility = "hidden";; // Ẩn ảnh nếu không có tệp nào được chọn
                }
            });
        }

        listenUploadImage(formUploadPotrait, fileInput_potrait, preview);
        listenUploadFile(formUploadChuyen, fileInput_truongchuyen);
        listenUploadFile(formUploadHsg, fileInput_hsg);
        listenUploadFile(formUploadOtherAchieve, fileInput_otherAchieve);
        listenUploadFile(formUploadielts, fileInput_ielts);
        listenUploadFile(formUploadPrior, fileInput_priority);


</script>

    
<script>
    document.getElementById('chonnganh').addEventListener('change', function() {
        var toHopAjax = document.getElementById("toHopDangKy");
        const tenNganh = this.value;
        // console.log(tenNganh); 

        const xhr = new XMLHttpRequest();
        xhr.open('POST', "student_nop_ho_so_ajax.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                if(this.responseText != '<select name="toHopDangKy" id=""></select>'){
                    toHopAjax.innerHTML = this.response;
                    // console.log(this.responseText);
                } else {
                    toHopAjax.innerHTML = '<select name="toHopDangKy" id="toHopDangKy"><option value=""></option></select>';
                }

            } else {
                console.log('Failed to send data');
            }
        };
        xhr.send('tenNganh=' + tenNganh);
    });
</script>


<script>
    document.getElementById('toHopDangKy').addEventListener('change', function() {
        const tenNganh =  document.getElementById('chonnganh').value;
        const tohop = this.value;

        $insert_diem_san = document.getElementById("insert_diem_san");
        
        if(tohop != '') {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', "student_respone_diem_san_ajax.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    insert_diem_san.innerHTML = this.response;
                } else {
                    console.log('Failed to send data');
                }
            };
            xhr.send('tenNganh=' + tenNganh + '&toHop=' + tohop);
        }
    });
</script>
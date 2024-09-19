<?php 
    include './layouts/header.php';
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
    #form_upload_minhchung_ilets:hover{
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

    /* .left_content {
        flex: 0.5;
    }

    .mid_content {
        flex: 1;
    } */

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

    /* select {
        min-width: 200px;
    }

    input {
        min-width: 220px;
    } */

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
    // nếu chưa đăng nhập tài khoản student thì out
    if(isset($_SESSION['taiKhoan'])){
        $sql = "SELECT * FROM students;";
        $res = mysqli_query($connect, $sql);
        $query_username = mysqli_fetch_array($res);
        // $username_student = $query_username['username'];
        $array_username_student = array();
        while($r = mysqli_fetch_array($res)){
            array_push($array_username_student, $r['username']);
        }
        if(!in_array($_SESSION['taiKhoan'], $array_username_student)){
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
    // lấy ra thông tin student đang đăng nhập
    $username = $_SESSION['taiKhoan'];
    $sql1 = "SELECT * FROM students WHERE username = '$username';";
    $query1 = mysqli_query($connect, $sql1);
    $row = mysqli_fetch_array($query1);
    $id_student = $row['id_student'];
    $fullname = $row['fullname'];
    $ngaysinh = $row['ngaysinh'];
    $phone_number = $row['phone_number'];
    $gender = $row['gender'];
    $address = $row['address'];
    $email = $row['email'];

    // echo $id_student . ' - ' . $fullname . ' - ' . $ngaysinh . ' - ' . $phone_number . ' - ' . $gender . ' - ' . $address . ' - ' . $email;
?>


<?php
    // lấy ra thuộc tính trường chuyên của students
    $a1 = "SELECT * FROM students WHERE id_student = '$id_student';";
    $r1 = mysqli_query($connect, $a1);
    $string_truongchuyen = mysqli_fetch_array($r1)['truong_chuyen'];
    $array_truongchuyen = explode(" | ", $string_truongchuyen);
    // print_r($array_truongchuyen);
    // echo $array_truongchuyen[0] . '<br>';
    // echo $array_truongchuyen[1] . '<br>';
    // echo $array_truongchuyen[2];


    // lấy ra thuộc tính giai_hs_gioi của students
    $a2 = "SELECT * FROM students WHERE id_student = '$id_student';";
    $r2 = mysqli_query($connect, $a2);
    $string_giai_hs_gioi = mysqli_fetch_array($r2)['giai_hs_gioi'];
    $array_giai_hs_gioi = explode(" | ", $string_giai_hs_gioi);
    // echo $array_giai_hs_gioi[0] . '<br>';
    // echo $array_giai_hs_gioi[1] . '<br>';
    // echo $array_giai_hs_gioi[2];

    // lấy ra thuộc tính chung_chi_ilets
    $a3 = "SELECT * FROM students WHERE id_student = '$id_student';";
    $r3 = mysqli_query($connect, $a3);
    $string_chung_chi_ilets = mysqli_fetch_array($r3)['chung_chi_ilets'];
    $array_chung_chi_ilets = explode(" | ", $string_chung_chi_ilets);
    // echo $array_chung_chi_ilets[0] . '<br>';
    // echo $array_chung_chi_ilets[1] . '<br>';
    // echo $array_chung_chi_ilets[2];

    // lấy ra thuộc tính giai_thuong_khac
    $a4 = "SELECT * FROM students WHERE id_student = '$id_student';";
    $r4 = mysqli_query($connect, $a4);
    $string_giai_thuong_khac = mysqli_fetch_array($r4)['giai_thuong_khac'];
    $array_giai_thuong_khac = explode(" | ", $string_giai_thuong_khac);

    // lấy ra thuộc tính diem_uu_tien
    $a5 = "SELECT * FROM students WHERE id_student = '$id_student';";
    $r5 = mysqli_query($connect, $a5);
    $string_diem_uu_tien = mysqli_fetch_array($r5)['diem_uu_tien'];
    $array_diem_uu_tien = explode(" | ", $string_diem_uu_tien);
    // echo $array_diem_uu_tien[0] . '<br>';
    // echo $array_diem_uu_tien[1] . '<br>';
    // echo $array_diem_uu_tien[2];

?>


<?php
    $s2 = "SELECT * FROM truongchuyen;";
    $query2 = mysqli_query($connect, $s2);
    $name_truongchuyen_array = array();
    while($row = mysqli_fetch_array($query2)){
        array_push($name_truongchuyen_array, $row['ten_truong']);
    }
?>

<?php
    // lấy ra những ngành đã được set tổ hợp trong bảng majors
    $s3 = "SELECT * FROM majors;";
    $query3 = mysqli_query($connect, $s3);
    $nganh_duoc_xet_array = array();
    while($row = mysqli_fetch_array($query3)){
        array_push($nganh_duoc_xet_array, $row['major_name']);
    }
?>

<?php
    if(isset($_POST['rate']) && ($_SESSION['token'] == $_POST['_token'])){
        $tohopdangky = $_POST['toHopDangKy'];
        echo $tohopdangky;
        // echo "1321241243";
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
            // echo "nhap lop chuyen";
            $message_error_1 = "nhap lop chuyen";
            $check = 0;
        } 
        if($_POST['truongchuyen'] != '' && $_FILES['fileInput_truongchuyen']['name'] == ''){
            // echo "upload file";
            $message_error_2 = "upload file";
            if(!isset($array_truongchuyen[2])){
                $check = 0;
            }
        }
        if($_POST['lopchuyen'] != '' && $_POST['truongchuyen'] == ''){
            // echo "nhap truong chuyen";
            $message_error_3 = "nhap truong chuyen";
            $check = 0;
        }
        if($_POST['lopchuyen'] != '' && $_FILES['fileInput_truongchuyen']['name'] == ''){
            // echo "upload file";
            $message_error_4 = "upload file";
            if(!isset($array_truongchuyen[2])){
                $check = 0;
            }
        }
        if($_FILES['fileInput_truongchuyen']['name'] != '' && $_POST['truongchuyen'] == '') {
            // echo "nhap truong chuyen";
            $message_error_5 = "nhap truong chuyen";
            $check = 0;
        }
        if($_FILES['fileInput_truongchuyen']['name'] != '' && $_POST['lopchuyen'] == '') {
            // echo "nhap lop chuyen";
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

        if($_FILES['fileInput_truongchuyen']['name'] == '' && $_POST['lopchuyen'] == '' && $_POST['truongchuyen'] == ''){
            $sql2 = "UPDATE students SET truong_chuyen = '' WHERE id_student = '$id_student';";
            mysqli_query($connect, $sql2);
        }

        if($_FILES['fileInput_truongchuyen']['name'] != '' && $_POST['lopchuyen'] != '' && $_POST['truongchuyen'] != ''){
            $permitted_extensions = ['png', 'jpg', 'jpeg'];
            $file_name = $_FILES['fileInput_truongchuyen']['name'];
            $file_extension = explode('.', $file_name);
            $file_extension = strtolower(end($file_extension));
            if(in_array($file_extension, $permitted_extensions)){
                $truong_chuyen = $_POST['truongchuyen'];
                $lop_chuyen = $_POST['lopchuyen'];
                $fileInput_truongchuyen = $_FILES['fileInput_truongchuyen'];
                $file_name = $fileInput_truongchuyen['name'];
                $generated_file_name = time().'-'.$file_name;
                $destination_path = $upload_dir . time() . '-' . $file_name;
                $file_tmp_name = $fileInput_truongchuyen['tmp_name'];
                $file_size = $fileInput_truongchuyen['size'];
                
                if($file_size <= 1000000){
                    move_uploaded_file($file_tmp_name, $destination_path);
                    $truong_chuyen_insert = $truong_chuyen . " | " . $lop_chuyen . " | " . $destination_path;
                    // echo $truong_chuyen_insert;
                    $sql2 = "UPDATE students SET truong_chuyen = '$truong_chuyen_insert' WHERE id_student = '$id_student';";
                    mysqli_query($connect, $sql2);
                } else {
                    echo "File is too large";
                }
            } else {
                echo "upload dung dinh dang file";
                $m1 = "upload khong dung dinh dang";
                $check = 0;
            }
        }


        // lưu dữ liệu về giải hs giỏi(nếu có)
        if($_POST['monthi'] != '' && $_POST['giai'] == ''){
            // echo "nhap giai";
            $message_error_7 = "nhap giai";
            $check = 0;
        } 
        if($_POST['monthi'] != '' && $_FILES['fileInput_hsg']['name'] == ''){
            // echo "upload file";
            $message_error_8 = "upload file";
            if(!isset($array_giai_hs_gioi[2])){
                $check = 0;
            }
        }
        if($_POST['giai'] != '' && $_POST['monthi'] == ''){
            // echo "nhap mon thi";
            $message_error_9 = "nhap mon thi";
            $check = 0;
        }
        if($_POST['giai'] != '' && $_FILES['fileInput_hsg']['name'] == ''){
            // echo "upload file";
            $message_error_10 = "upload file";
            if(!isset($array_giai_hs_gioi[2])){
                $check = 0;
            }
        }
        if($_FILES['fileInput_hsg']['name'] != '' && $_POST['monthi'] == '') {
            // echo "nhap mon thi";
            $message_error_11 = "nhap mon thi";
            $check = 0;
        }
        if($_FILES['fileInput_hsg']['name'] != '' && $_POST['giai'] == '') {
            // echo "nhap giai";
            $message_error_12 = "nhap giai";
            $check = 0;
        }

        if($_FILES['fileInput_hsg']['name'] == '' && $_POST['giai'] == '' && $_POST['monthi'] == ''){
            $sql = "UPDATE students SET giai_hs_gioi = '' WHERE id_student = '$id_student';";
            mysqli_query($connect, $sql);
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
            $permitted_extensions = ['png', 'jpg', 'jpeg'];
            $file_name = $_FILES['fileInput_hsg']['name'];
            $file_extension = explode('.', $file_name);
            $file_extension = strtolower(end($file_extension));
            if(in_array($file_extension, $permitted_extensions)){
                $monthi = $_POST['monthi'];
                $giai = $_POST['giai'];
                $fileInput_hsg = $_FILES['fileInput_hsg'];
                $file_name = $fileInput_hsg['name'];
                $generated_file_name = time().'-'.$file_name;
                $destination_path = $upload_dir . time() . '-' . $file_name;
                $file_tmp_name = $fileInput_hsg['tmp_name'];
                $file_size = $fileInput_hsg['size'];
                
                if($file_size <= 1000000){
                    move_uploaded_file($file_tmp_name, $destination_path);
                    $giai_hs_gioi_insert = $monthi . " | " . $giai . " | " . $destination_path;
                    // echo $giai_hs_gioi_insert;
                    $sql3 = "UPDATE students SET giai_hs_gioi = '$giai_hs_gioi_insert' WHERE id_student = '$id_student';";
                    mysqli_query($connect, $sql3);
                } else {
                    echo "File is too large";
                }
            } else {
                echo "upload dung dinh dang file";
                $check = 0;
            }
        }


        // lưu dữ liệu về các giải thưởng khác
        if($_POST['giaithuongkhac'] != '' && $_FILES['fileInput_otherAchieve']['name'] == ''){
            // echo "upload file";
            $message_error_13 = "upload file";
            if(!isset($array_giai_thuong_khac[1])){
                $check = 0;
            }
        } 
        if($_FILES['fileInput_otherAchieve']['name'] != '' && $_POST['giaithuongkhac'] == '') {
            // echo "nhap giai thuong";
            $message_error_14 = "mo ta giai thuong";
            $check = 0;
        }

        if(isset($_POST['giaithuongkhac'])){
            $_SESSION['giaithuongkhac'] = $_POST['giaithuongkhac'];
        }

        if($_FILES['fileInput_otherAchieve']['name'] == '' && $_POST['giaithuongkhac'] == ''){
            $sql = "UPDATE students SET giai_thuong_khac = '' WHERE id_student = '$id_student';";
            mysqli_query($connect, $sql);
        }

        if($_FILES['fileInput_otherAchieve']['name'] != '' && $_POST['giaithuongkhac'] != ''){
            $permitted_extensions = ['png', 'jpg', 'jpeg'];
            $file_name = $_FILES['fileInput_otherAchieve']['name'];
            $file_extension = explode('.', $file_name);
            $file_extension = strtolower(end($file_extension));
            if(in_array($file_extension, $permitted_extensions)){
                $giaithuongkhac = $_POST['giaithuongkhac'];
                $fileInput_otherAchieve = $_FILES['fileInput_otherAchieve'];
                $file_name = $fileInput_otherAchieve['name'];
                $generated_file_name = time().'-'.$file_name;
                $destination_path = $upload_dir . time() . '-' . $file_name;
                $file_tmp_name = $fileInput_otherAchieve['tmp_name'];
                $file_size = $fileInput_otherAchieve['size'];
                
                if($file_size <= 1000000){
                    move_uploaded_file($file_tmp_name, $destination_path);
                    $giai_thuong_khac_array = $giaithuongkhac . " | " . $destination_path;
                    // echo $giai_thuong_khac_array;
                    $sql4 = "UPDATE students SET giai_thuong_khac = '$giai_thuong_khac_array' WHERE id_student = '$id_student';";
                    mysqli_query($connect, $sql4);
                } else {
                    echo "File is too large";
                }
            } else {
                echo "upload dung dinh dang file";
                $check = 0;
            }
        }


        // lưu dữ liệu về điểm ưu tiên
        if($_POST['khuvuc'] != '' && $_POST['doituonguutien'] == ''){
            // echo "nhap doi tuong uu tien";
            $message_error_21 = "nhap doi tuong uu tien";
            $check = 0;
        } 
        if($_POST['khuvuc'] != '' && $_FILES['fileInput_priority']['name'] == ''){
            // echo "upload file";
            $message_error_22 = "upload file";
            if(!isset($array_diem_uu_tien[2])){
                $check = 0;
            }
        }
        if($_POST['doituonguutien'] != '' && $_POST['khuvuc'] == ''){
            // echo "nhap khu vuc";
            $message_error_23 = "nhap khu vuc";
            $check = 0;
        }
        if($_POST['doituonguutien'] != '' && $_FILES['fileInput_truongchuyen']['name'] == ''){
            // echo "upload file";
            $message_error_24 = "upload file";
            if(!isset($array_diem_uu_tien[2])){
                $check = 0;
            }
        }
        if($_FILES['fileInput_priority']['name'] != '' && $_POST['khuvuc'] == '') {
            // echo "nhap khu vuc";
            $message_error_25 = "nhap khu vuc";
            $check = 0;
        }
        if($_FILES['fileInput_priority']['name'] != '' && $_POST['doituonguutien'] == '') {
            // echo "nhap doi tuong uu tien";
            $message_error_26 = "nhap doi tuong uu tien";
            $check = 0;
        }


        if($_FILES['fileInput_priority']['name'] != '' || $_POST['doituonguutien'] != '' || $_POST['khuvuc'] != ''){
            if(isset($_POST['khuvuc'])){
                $_SESSION['khuvuc'] = $_POST['khuvuc'];
            }
            if(isset($_POST['doituonguutien'])){
                $_SESSION['doituonguutien'] = $_POST['doituonguutien'];
            }
        }

        if($_FILES['fileInput_priority']['name'] == '' && $_POST['doituonguutien'] == '' && $_POST['khuvuc'] == ''){
            $sql = "UPDATE students SET diem_uu_tien = '' WHERE id_student = '$id_student';";
            mysqli_query($connect, $sql);
        }


        if($_FILES['fileInput_priority']['name'] != '' && $_POST['doituonguutien'] != '' && $_POST['khuvuc'] != ''){
            $permitted_extensions = ['png', 'jpg', 'jpeg'];
            $file_name = $_FILES['fileInput_priority']['name'];
            $file_extension = explode('.', $file_name);
            $file_extension = strtolower(end($file_extension));
            if(in_array($file_extension, $permitted_extensions)){
                $khuvuc = $_POST['khuvuc'];
                $doi_tuong_uu_tien = $_POST['doituonguutien'];
                $fileInput_priority = $_FILES['fileInput_priority'];
                $file_name = $fileInput_priority['name'];
                $generated_file_name = time().'-'.$file_name;
                $destination_path = $upload_dir . time() . '-' . $file_name;
                $file_tmp_name = $fileInput_priority['tmp_name'];
                $file_size = $fileInput_priority['size'];
                
                // echo $truong_chuyen . '-' . $lop_chuyen . '-' . $file_name;
                // echo '<br>';
                // print_r($_FILES['fileInput_truongchuyen']);
                // echo $destination_path;
                if($file_size <= 1000000){
                    move_uploaded_file($file_tmp_name, $destination_path);
                    $doi_tuong_uu_tien_insert = $khuvuc . " | " . $doi_tuong_uu_tien . " | " . $destination_path;
                    // echo $doi_tuong_uu_tien_insert;
                    $sql5 = "UPDATE students SET diem_uu_tien = '$doi_tuong_uu_tien_insert' WHERE id_student = '$id_student';";
                    mysqli_query($connect, $sql5);
                } else {
                    echo "File is too large";
                }
            } else {
                echo "upload dung dinh dang file";
                $check = 0;
            }
        }


        // lưu dữ liệu chứng chỉ ilets
        if($_POST['machungnhan'] != '' && $_POST['diem'] == ''){
            // echo "nhap diem";
            $message_error_15 = "nhap diem";
            $check = 0;
        } 
        if($_POST['machungnhan'] != '' && $_FILES['fileInput_ilets']['name'] == ''){
            // echo "upload file";
            $message_error_16 = "upload file";
            if(!isset($array_chung_chi_ilets[2])){
                $check = 0;
            }
        }
        if($_POST['diem'] != '' && $_POST['machungnhan'] == ''){
            // echo "nhap ma chung nhan";
            $message_error_17 = "nhap ma chung nhan";
            $check = 0;
        }
        if($_POST['diem'] != '' && $_FILES['fileInput_ilets']['name'] == ''){
            // echo "upload file";
            $message_error_18 = "upload file";
            if(!isset($array_chung_chi_ilets[2])){
                $check = 0;
            }
        }
        if($_FILES['fileInput_ilets']['name'] != '' && $_POST['machungnhan'] == '') {
            // echo "nhap ma chung nhan";
            $message_error_19 = "nhap ma chung nhan";
            $check = 0;
        }
        if($_FILES['fileInput_ilets']['name'] != '' && $_POST['diem'] == '') {
            // echo "nhap diem";
            $message_error_20 = "nhap diem";
            $check = 0;
        }

        if($_FILES['fileInput_ilets']['name'] != '' || $_POST['machungnhan'] != '' || $_POST['diem'] != ''){
            if(isset($_POST['machungnhan'])){
                $_SESSION['machungnhan'] = $_POST['machungnhan'];
            }
            if(isset($_POST['diem'])){
                $_SESSION['diem'] = $_POST['diem'];
            }
        }

        if($_FILES['fileInput_ilets']['name'] == '' && $_POST['diem']== '' && $_POST['machungnhan'] == ''){
            $sql = "UPDATE students SET chung_chi_ilets = '' WHERE id_student = '$id_student';";
            mysqli_query($connect, $sql);
        }

        if($_FILES['fileInput_ilets']['name'] != '' && $_POST['diem'] != '' && $_POST['machungnhan'] != ''){
            $permitted_extensions = ['png', 'jpg', 'jpeg'];
            $file_name = $_FILES['fileInput_ilets']['name'];
            $file_extension = explode('.', $file_name);
            $file_extension = strtolower(end($file_extension));
            if(in_array($file_extension, $permitted_extensions)){
                $ma_chung_nhan = $_POST['machungnhan'];
                $diem = $_POST['diem'];
                $fileInput_ilets = $_FILES['fileInput_ilets'];
                $file_name = $fileInput_ilets['name'];
                $generated_file_name = time().'-'.$file_name;
                $destination_path = $upload_dir . time() . '-' . $file_name;
                $file_tmp_name = $fileInput_ilets['tmp_name'];
                $file_size = $fileInput_ilets['size'];
                
                // echo $truong_chuyen . '-' . $lop_chuyen . '-' . $file_name;
                // echo '<br>';
                // print_r($_FILES['fileInput_truongchuyen']);
                // echo $destination_path;
                if($file_size <= 1000000){
                    move_uploaded_file($file_tmp_name, $destination_path);
                    $chung_chi_ilets_insert = $ma_chung_nhan . " | " . $diem . " | " . $destination_path;
                    // echo $chung_chi_ilets_insert;
                    $sql6 = "UPDATE students SET chung_chi_ilets = '$chung_chi_ilets_insert' WHERE id_student = '$id_student';";
                    mysqli_query($connect, $sql6);
                } else {
                    echo "File is too large";
                }
            } else {
                echo "upload dung dinh dang file";
                $check = 0;
            }
        }
    }
?>

<?php
    // echo $check;
?>

<?php
    // xử lí chọn ngành và tổ hợp
    if(isset($_POST['send']) && ($_SESSION['token'] == $_POST['_token']) && $check == 1){
        if($_POST['chonnganh']!='' && $_POST['toHopDangKy']!=''){
            $nganh = $_POST['chonnganh'];
            $tohopdangky = $_POST['toHopDangKy'];
            // echo $nganh;
            // echo $tohopdangky;
            $s1 = "SELECT * FROM majors WHERE major_name = '$nganh';";
            $result = mysqli_query($connect, $s1);
            $id_major = mysqli_fetch_array($result)['id_major'];
            $sql = "INSERT INTO ledgers(id_student, id_major, id_SB) VALUES('$id_student', '$id_major', '$tohopdangky');";
            $res = mysqli_query($connect, $sql);
            if($res) {
                // echo "Success";
                ?>
                <script>
                    alert("Nop ho so thanh cong!");
                </script>
                <?php
            }
        }
    }
?>

<?php
    // echo $_SESSION['truongchuyen'];
?>

<div style="display: flex; justify-content: center;">

<?php 
    if(isset($_SESSION['role'])) {
		include './layouts/menu.php';
	}
?>

<div class="body_content" style="display: block; width: 100%;">
	
<form id="form" method="post" enctype="multipart/form-data">
    <div class="container" style="width: 1500px;">
        <div class="infor_text">
            THÔNG TIN CÁ NHÂN
        </div>
        <hr>

        <div class="infor_content">
            <div class="left_content">
                <div>
                    <input type="file" id="fileInput_potrait" accept="image/*" hidden>
                    <img id="preview" alt="">
                </div>
    
    
                <span id="form_upload_potrait" style=" color: #000;">
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
            <div class="mb_top_8px" style="font-weight: 600;">1.1. Minh chứng lớp chuyên (nếu có)</div>
            <div class="achievements">
                <div>
                    <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Trường chuyên</div>
                    <span class="red" style="position: absolute; top: 8px; left: 116px;"><?php if(!isset($array_truongchuyen[0])){echo (isset($message_error_3)||isset($message_error_5)) ? "nhap truong chuyen" : "";}?></span>
                    <select name="truongchuyen" id="">
                        <option value=""></option>
                        <?php
                            foreach($name_truongchuyen_array as $ten_truong){ ?>
                                <?php #echo '<option value="' . $ten_truong .'">' . $ten_truong . '</option>'?>
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
                    <span class="red" style="position: absolute; top: 8px; right: -72px;"><?php if(!isset($array_truongchuyen[2])){echo (isset($message_error_2) || isset($message_error_4)) ? "upload file" : "";} ?></span>
                    <input type="file" id="fileInput_truongchuyen" name="fileInput_truongchuyen" style="visibility: hidden; position: absolute; top: 31px; font-size: 10px; left: 0px;">
                    <span id="form_upload_minhchung_chuyen" style=" color: #000; height: 22px;">
                        <i class="ti-cloud-up"></i>
                        <span style="font-size: 12px;">Tải lên</span>
                    </span>
                </div>
            </div>


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
                <span class="red" style="position: absolute; top: 8px; right: -72px;"><?php if(!isset($array_giai_hs_gioi[2])){echo (isset($message_error_8) || isset($message_error_10)) ? "upload file" : "";} ?></span>
                <input type="file" id="fileInput_hsg" name="fileInput_hsg" style="visibility: hidden; position: absolute; top: 31px; font-size: 10px; left: 0px;">
                <span id="form_upload_minhchung_hsg" style=" color: #000; height: 22px;">
                        <i class="ti-cloud-up"></i>
                        <span style="font-size: 12px;">Tải lên</span>
                    </span>
                </div>
            </div>


            <div class="mb_top_8px" style="font-weight: 600;">1.3. Chứng chỉ ILETS (nếu có)</div>
            <div class="achievements">
                <div>
                    <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Mã chứng nhận</div>
                    <span class="red" style="position: absolute; top: 8px; left: 120px;"><?php echo (isset($message_error_17)||isset($message_error_19)) ? "nhap ma chung nhan" : "" ?></span>
                    <input type="text" name="machungnhan" value=
                    "<?php if(isset($array_chung_chi_ilets[0]) && $array_chung_chi_ilets[0]!=""){
                            echo $array_chung_chi_ilets[0];
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
                                        if (isset($array_chung_chi_ilets[1])) {
                                            echo $array_chung_chi_ilets[1]=="4.5" ? "selected" : "";
                                        } else {
                                            if(isset($_SESSION['diem'])){
                                                if($_SESSION['diem'] == "4.5"){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >4.5</option>
                        <option value="5" <?php 
                                        if (isset($array_chung_chi_ilets[1])) {
                                            echo $array_chung_chi_ilets[1]=="5" ? "selected" : "";
                                        } else {
                                            if(isset($_SESSION['diem'])){
                                                if($_SESSION['diem'] == "5"){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >5</option>
                        <option value="5.5" <?php 
                                        if (isset($array_chung_chi_ilets[1])) {
                                            echo $array_chung_chi_ilets[1]=="5.5" ? "selected" : "";
                                        } else {
                                            if(isset($_SESSION['diem'])){
                                                if($_SESSION['diem'] == "5.5"){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >5.5</option>
                        <option value="6" <?php 
                                        if (isset($array_chung_chi_ilets[1])) {
                                            echo $array_chung_chi_ilets[1]=="6" ? "selected" : "";
                                        } else {
                                            if(isset($_SESSION['diem'])){
                                                if($_SESSION['diem'] == "6"){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >6</option>
                        <option value="6.5" <?php 
                                        if (isset($array_chung_chi_ilets[1])) {
                                            echo $array_chung_chi_ilets[1]=="6.5" ? "selected" : "";
                                        } else {
                                            if(isset($_SESSION['diem'])){
                                                if($_SESSION['diem'] == "6.5"){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >6.5</option>
                        <option value="7" <?php 
                                        if (isset($array_chung_chi_ilets[1])) {
                                            echo $array_chung_chi_ilets[1]=="7" ? "selected" : "";
                                        } else {
                                            if(isset($_SESSION['diem'])){
                                                if($_SESSION['diem'] == "7"){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >7</option>
                        <option value="7.5" <?php 
                                        if (isset($array_chung_chi_ilets[1])) {
                                            echo $array_chung_chi_ilets[1]=="7.5" ? "selected" : "";
                                        } else {
                                            if(isset($_SESSION['diem'])){
                                                if($_SESSION['diem'] == "7.5"){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >7.5</option>
                        <option value="8" <?php 
                                        if (isset($array_chung_chi_ilets[1])) {
                                            echo $array_chung_chi_ilets[1]=="8" ? "selected" : "";
                                        } else {
                                            if(isset($_SESSION['diem'])){
                                                if($_SESSION['diem'] == "8"){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >8</option>
                        <option value="8.5" <?php 
                                        if (isset($array_chung_chi_ilets[1])) {
                                            echo $array_chung_chi_ilets[1]=="8.5" ? "selected" : "";
                                        } else {
                                            if(isset($_SESSION['diem'])){
                                                if($_SESSION['diem'] == "8.5"){
                                                    echo "selected";
                                                }
                                            }
                                        }
                                    ?> >8.5</option>
                        <option value="9" <?php 
                                        if (isset($array_chung_chi_ilets[1])) {
                                            echo $array_chung_chi_ilets[1]=="9" ? "selected" : "";
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
                    <span class="red" style="position: absolute; top: 8px; right: -72px;"><?php if(!isset($array_chung_chi_ilets[2])){echo (isset($message_error_16) || isset($message_error_18)) ? "upload file" : "";} ?></span>
                    <input type="file" id="fileInput_ilets" name="fileInput_ilets" style="visibility: hidden; position: absolute; top: 31px; font-size: 10px; left: 0px;">
                    <span id="form_upload_minhchung_ilets" style=" color: #000; height: 22px;">
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
                    <span class="red" style="position: absolute; top: 8px; right: -72px;"><?php if(!isset($array_giai_thuong_khac[1])){echo isset($message_error_13) ? "upload file" : "";} ?></span>
                    <input type="file" id="fileInput_otherAchieve" name="fileInput_otherAchieve" style="visibility: hidden; position: absolute; top: 31px; font-size: 10px; left: 0px;">
                    <span id="form_upload_minhchung_otherAchieve" style=" color: #000; height: 22px;">
                            <i class="ti-cloud-up"></i>
                            <span style="font-size: 12px;">Tải lên</span>
                        </span>
                </div>
            </div>
        </div>

        <div class="diem_uu_tien" style="font-size: 18px; font-weight: bold; color: #b50206;">2. Điểm ưu tiên</div>
        <div class="priority_point achievements">
            <div>
                <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Khu vực</div>
                <span class="red" style="position: absolute; top: 8px; left: 69px;"><?php echo (isset($message_error_23)||isset($message_error_25)) ? "nhap khu vuc" : "" ?></span>
                <select name="khuvuc" id="">
                    <option value=""></option>
                    <option value="Khu vực 1" <?php 
                                        if ($array_diem_uu_tien[0] == "Khu vực 1") {
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
                                        if ($array_diem_uu_tien[0] == "Khu vực 2") {
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
                                        if ($array_diem_uu_tien[0] == "Khu vực 3") {
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
                <span class="red" style="position: absolute; top: 8px; right: 250px;"><?php echo (isset($message_error_21)||isset($message_error_26)) ? "nhap doi tuong uu tien" : "" ?></span>
                <input name="doituonguutien" type="text" value=
                "<?php if(isset($array_diem_uu_tien[1]) && $array_diem_uu_tien[1]!=""){
                            echo $array_diem_uu_tien[1];
                        } else {
                            if(isset($_SESSION['doituonguutien'])){
                                echo $_SESSION['doituonguutien'];
                            }
                    }?>">
            </div>

            <div style="position: relative; display: flex; flex-direction: column; justify-content: space-between; width: 100px; height: 72px;">
                <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Minh chứng</div>
                <span class="red" style="position: absolute; top: 8px; right: -72px;"><?php if(!isset($array_diem_uu_tien[2])){echo (isset($message_error_22) || isset($message_error_24)) ? "upload file" : "";} ?></span>
                <input type="file" id="fileInput_priority" name="fileInput_priority" style="visibility: hidden; position: absolute; top: 31px; font-size: 10px; left: 0px;">
                <span id="form_upload_minhchung_priority" style=" color: #000; height: 22px;">
                    <i class="ti-cloud-up"></i>
                    <span style="font-size: 12px;">Tải lên</span>
                </span>
            </div>
        </div>

        <div class="nguyen_vong" style="font-size: 18px; font-weight: bold; color: #b50206;">3. Đăng ký nguyện vọng xết tuyển</div>
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


            <div style="flex: 1.2;">
                <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Tổ hợp đăng ký</div>
                <select name="toHopDangKy" id="toHopDangKy" required>
                    <option value=""></option>
                </select>
            </div>
        </div>

        <br>
        <!-- <input type="submit" class="btn btn-success" style="width: 136px; height: 40px;" value="Đánh giá hồ sơ" name="rate">
        <input type="hidden" name="_token" value="<?php # echo $token ?>">
        <?php # $_SESSION['token'] = $token; ?>

        <div class="danh_gia">
            <div>- Điểm thành tích học tập: </div>
            <div>- Điểm học bạ: </div>
            <div>- Điểm ưu tiên: </div>
        </div> -->
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
        const fileInput_ilets = document.getElementById('fileInput_ilets');
        const fileInput_otherAchieve = document.getElementById('fileInput_otherAchieve');
        const fileInput_priority = document.getElementById('fileInput_priority');


        const formUploadPotrait = document.getElementById('form_upload_potrait');
        const formUploadChuyen = document.getElementById('form_upload_minhchung_chuyen');
        const formUploadHsg = document.getElementById('form_upload_minhchung_hsg');
        const formUploadOtherAchieve = document.getElementById('form_upload_minhchung_otherAchieve');
        const formUploadIlets = document.getElementById('form_upload_minhchung_ilets');
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
        listenUploadFile(formUploadIlets, fileInput_ilets);
        listenUploadFile(formUploadPrior, fileInput_priority);


</script>

    
<script>
    document.getElementById('chonnganh').addEventListener('change', function() {
        var toHopAjax = document.getElementById("toHopDangKy");
        const tenNganh = this.value;
        console.log(tenNganh); 

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


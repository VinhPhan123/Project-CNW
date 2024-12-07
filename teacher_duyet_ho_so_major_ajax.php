<?php
if (isset($_POST['id_ledger'])) {
    include './database/connect.php';
    include './functions.php';

    // Lấy id_ledger từ POST
    $id_ledger = $_POST['id_ledger'];
    // lấy ra chuyên ngành
    $chuyen_nganh = $_POST['chuyen_nganh'];
    // lấy ra tổ hợp
    $to_hop = $_POST['to_hop'];

    // Kiểm tra kết nối
    if ($connect->connect_error) {
        die("Connection failed: " . $connect->connect_error);
    }

    $condition = [
        'id_ledger' => $id_ledger
    ];
    $query1 = select('ledgers', '*', $condition);

    // Kiểm tra xem có kết quả không
    if (mysqli_num_rows($query1) > 0) {
        $array_query1 = mysqli_fetch_array($query1);
        $id_student = $array_query1['id_student'];
        $score = $array_query1['score'];

        // lấy ra ledger_status, nếu bằng NULL - chưa duyệt, 1 - đã duyệt

        $condition = [
            'id_student' => $id_student
        ];
        $query2 = select('students', '*', $condition);
        $row = mysqli_fetch_array($query2);

        // Lấy thông tin cá nhân
        $fullname = $row['fullname'];
        $ngaysinh = $row['ngaysinh'];
        $phone_number = $row['phone_number'];
        $gender = $row['gender'];
        $address = $row['address'];
        $email = $row['email'];
        $avt = $row['avt'];
        $truong_chuyen = $row['truong_chuyen'];
        $giai_hs_gioi = $row['giai_hs_gioi'];
        $chung_chi_ielts = $row['chung_chi_ielts'];
        $giai_thuong_khac = $row['giai_thuong_khac'];
        $doi_tuong_uu_tien = $row['doi_tuong_uu_tien'];
        $khu_vuc_uu_tien = $row['khu_vuc_uu_tien'];
        // Tên trường - Lớp - Minh chứng
        $array_truong_chuyen = explode(" | ", $truong_chuyen);
        // Môn - Giải - Minh chứng
        $array_giai_hs_gioi = explode(" | ", $giai_hs_gioi);
        // Mã chứng nhân - Điểm - Minh chứng
        $array_chung_chi_ielts = explode(" | ", $chung_chi_ielts);
        // Mô tả - Minh chứng
        $array_giai_thuong_khac = explode(" | ", $giai_thuong_khac);
        // Đối tượng - Minh chứng
        $array_doi_tuong_uu_tien = explode(" | ", $doi_tuong_uu_tien);
        // Khu vực
        $array_khu_vuc_uu_tien = explode(" | ", $khu_vuc_uu_tien);



        // Hiển thị thông tin
        echo '<div class="overlay" style="overflow: scroll ;position: fixed; top: 0; bottom: 0; left: 0; right: 0; background-color: rgba(0, 0, 0, 0.2); display: flex; justify-content: center; align-items: center;">
            <div class="overlay_content" id="overlay_content">
                <div id="form" method="post" enctype="multipart/form-data" style="background-color: #fff; width: 900px; margin: auto; padding: 32px 8px; margin-top: 24px; border-radius: 4px;">
                    <div class="container" style="width: 800px;">
                        <div class="infor_text">THÔNG TIN CÁ NHÂN</div>
                        <hr>
                        <div class="infor_content">
                            <div class="left_content">
                                <div>
                                    <input type="file" id="fileInput_potrait" accept="image/*" hidden>
					                <img style="margin-left: 0px;" id="preview" src="'. $avt.'"><br>
                                </div>
                            </div>
                            <div class="mid_content">
                                <div><label>Họ và tên</label><input type="text" value="' . $fullname . '" disabled></div>
                                <div><label>Ngày sinh</label><input type="date" value="' . $ngaysinh . '" disabled></div>
                                <div><label>Giới tính</label>
                                    <select name="" id="" disabled>
                                        <option value=""></option>
                                        <option value="nam"' . (($gender == 'Nam') ? 'selected' : '') . '>Nam</option>
                                        <option value="nu"' . (($gender == 'Nữ') ? 'selected' : '') . '>Nữ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="right_content">
                                <div><label>Email</label><input type="email" value="' . $email . '" disabled></div>
                                <div><label>Số điện thoại</label><input type="text" value="' . $phone_number . '" disabled></div>
                                <div><label>Địa chỉ</label><input type="text" value="' . $address . '" disabled></div>
                            </div>
                        </div>';

        if($truong_chuyen != '' || $giai_hs_gioi != '' || $chung_chi_ielts != '' || $giai_thuong_khac != ''){
            echo '<div class="thanh_tich" style="font-size: 18px; font-weight: bold; color: #b50206;">1. Thành tích học tập</div>';
        }
   
        if($truong_chuyen != ''){
            echo '<div class="mb_top_8px" style="font-weight: 600;">1.1. Minh chứng lớp chuyên (nếu có)</div>
                    <div class="achievements">
                        <div>
                            <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Trường chuyên</div>
                            <span class="red" style="position: absolute; top: 8px; left: 116px;"><?php if(!isset($array_truongchuyen[0])){echo (isset($message_error_3)||isset($message_error_5)) ? "nhap truong chuyen" : "";}?></span>
                            <input disabled type="text" value="' . $array_truong_chuyen[0] . '">
                        </div>

                        <div>
                            <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Lớp chuyên</div>
                            <input disabled name="lopchuyen" type="text" value="' . $array_truong_chuyen[1] . '">
                        </div>

                        <div style="position: relative; display: flex; flex-direction: row; justify-content: space-between; width: 100px; height: 72px;align-items: center;">
                            <img class="img_truong_chuyen" style="position: absolute;" width="50px" height="50px" src="' . $array_truong_chuyen[2] . '">
                        </div>
                    </div>';
        }

        
        if($giai_hs_gioi != ''){
            echo '<div class="mb_top_8px" style="font-weight: 600;">1.2. Giải học sinh giỏi (nếu có)</div>
                    <div class="achievements">
                        <div>
                            <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Môn thi</div>
                            <input disabled type="text" value="' . $array_giai_hs_gioi[0] . '">
                        </div>

                        <div>
                            <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Giải</div>
                            <input disabled type="text" value="' . $array_giai_hs_gioi[1] . '">
                        
                        </div>

                        <div style="position: relative; display: flex; flex-direction: row; justify-content: space-between; width: 100px; height: 72px;align-items: center;">
                            <img class="img_hs_gioi" style="position: absolute;" width="50px" height="50px" src="' . $array_giai_hs_gioi[2] . '">
                        </div>	
                    </div>';
        }

        if($chung_chi_ielts != ''){
            echo '<div class="mb_top_8px" style="font-weight: 600;">1.3. Chứng chỉ ielts (nếu có)</div>
                    <div class="achievements">
                        <div>
                            <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Mã chứng nhận</div>
                            <input disabled name="machungnhan" type="text" value="' . $array_chung_chi_ielts[0] . '">
                        </div>

                        <div>
                            <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Điểm</div>
                            <input disabled type="text" value="' . $array_chung_chi_ielts[1] . '">
                        </div>

                        <div style="position: relative; display: flex; flex-direction: row; justify-content: space-between; width: 100px; height: 72px;align-items: center;">
                            <img class="img_chung_chi_ielts" style="position: absolute;" width="50px" height="50px" src="' . $array_chung_chi_ielts[2] . '">
                        </div>
                    </div>';
        }

        if($giai_thuong_khac != ''){
            echo '<div class="mb_top_8px" style="font-weight: 600;">1.4. Các thành tích giải thưởng khác</div>
                    <div class="achievements">
                        <div>
                            <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Mô tả</div>
                            <input disabled name="doituonguutien" type="text" value="' . $array_giai_thuong_khac[0] . '">
                        </div>

                        <div style="position: relative; display: flex; flex-direction: row; justify-content: space-between; width: 100px; height: 72px;align-items: center;">
                            <img class="img_giai_thuong_khac" style="position: absolute;" width="50px" height="50px" src="' . $array_giai_thuong_khac[1] . '">
                        </div>
                    </div>';
        }

        if($khu_vuc_uu_tien != '' || $doi_tuong_uu_tien!=''){
            echo '<div class="diem_uu_tien" style="font-size: 18px; font-weight: bold; color: #b50206;">2. Điểm ưu tiên</div>
                <div class="priority_point achievements">';
        }

        if($khu_vuc_uu_tien != ''){
            echo '<div>
                    <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Khu vực</div>
                    <input disabled type="text" value="' . $array_khu_vuc_uu_tien[0] . '">
                </div>';
        }

        if($doi_tuong_uu_tien != ''){
            echo '<div>
                    <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Đối tượng ưu tiên</div>
                    <input disabled name="doituonguutien" type="text" value="' . $array_doi_tuong_uu_tien[0] . '">
                </div>

                <div style="position: relative; display: flex; flex-direction: row; justify-content: space-between; width: 100px; height: 72px;align-items: center;">
                    <img class="img_doi_tuong_uu_tien" style="position: absolute;" width="50px" height="50px" src="' . $array_doi_tuong_uu_tien[1] . '">
                </div>';
        }

        if($khu_vuc_uu_tien != '' || $doi_tuong_uu_tien!=''){
            echo '</div>';
        }

        // hiển thị ngành và điểm
        echo '<div class="diem_uu_tien" style="font-size: 18px; font-weight: bold; color: #b50206;">3. Điểm xét tuyển</div>
            <div class="achievements" style="width: 645px;">
                <div>
                    <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Ngành xét tuyển</div>
                    <input disabled name="nganhxettuyen" type="text" value="' . $chuyen_nganh . '">
                </div>

                <div>
                    <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Điểm xét tuyển</div>
                    <input disabled type="text" value="' . $score . '">
                </div>

                <div>   </div>
            </div>';

        
        echo '          <br><input type="submit" class="btn btn-primary" value="Close" id="close" name="close" style="text-align: center; width: 100%; height: 36px; color: #fff; background-color: #b50206;"/>
                    </div>
                </div>
            </div>
        </div>';
    }
}
?>
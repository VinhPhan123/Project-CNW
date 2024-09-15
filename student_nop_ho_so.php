<?php 
		include './layouts/header.php';
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
        min-width: 100px;
        font-weight: 500;
    }


    .mid_content > div, .right_content > div {
        margin: 12px 0;
    }

    .achievements {
        width: 1000px;
        display: flex;
        justify-content: space-between;
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

<div style="display: flex; justify-content: center;">

<?php 
    if(isset($_SESSION['role'])) {
		include './layouts/menu.php';
	}
?>

<div class="body_content" style="display: block; width: 100%;">
	
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
                    <input type="text">
                </div>

                <div>
                    <label>Ngày sinh</label>
                    <input type="date">
                </div>

                <div>
                    <label>Giới tính</label>
                    <select name="" id="">
                        <option value="nam">Nam</option>
                        <option value="nu">Nữ</option>
                    </select>
                </div>


            </div>

            <div class="right_content">
                <div>
                    <label>Email</label>
                    <input type="email">
                </div>

                <div>
                    <label>Số điện thoại</label>
                    <input type="text">
                </div>

                <div>
                    <label>Địa chỉ</label>
                    <input type="text">
                </div>
            </div>
        </div>


        <div class="thanh_tich" style="font-size: 18px; font-weight: bold; color: #b50206;">1. Thành tích học tập</div>
        <div class="academic_achivements">
            <div class="mb_top_8px" style="font-weight: 600;">1.1. Minh chứng lớp chuyên (nếu có)</div>
            <div class="achievements">
                <div>
                    <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Trường chuyên</div>
                    <select name="truongchuyen" id="">
                        <option value=""></option>
                        <option value="">THPT Chuyên Nguyễn Huệ</option>
                        <option value="">THPT Chuyên Đại Học Sư Phạm</option>
                    </select>
                </div>

                <div>
                    <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Lớp chuyên</div>
                    <input type="text" placeholder="Lớp chuyên(vd: chuyên hóa)">
                </div>

                <div style="position: relative; display: flex; flex-direction: column; justify-content: space-between; width: 100px; height: 72px;">
                    <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Minh chứng</div>
                    <input type="file" id="fileInput_truongchuyen" style="visibility: hidden; position: absolute; top: 31px; font-size: 10px; left: 0px;">
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
                    <select name="monthi" id="">
                        <option value=""></option>
                        <option value="">Toán</option>
                        <option value="">Lí</option>
                    </select>
                </div>

                <div>
                    <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Giải (nhất, nhì, ba, khuyến khích)</div>
                    <select name="giai" id="">
                        <option value=""></option>
                        <option value="nhat">Nhất</option>
                        <option value="nhi">Nhì</option>
                        <option value="ba">Ba</option>
                        <option value="khuyenkhich">Khuyến khích</option>
                    </select>
                </div>

                <div style="position: relative; display: flex; flex-direction: column; justify-content: space-between; width: 100px; height: 72px;">
                <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Minh chứng</div>
                <input type="file" id="fileInput_hsg" style="visibility: hidden; position: absolute; top: 31px; font-size: 10px; left: 0px;">
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
                    <input type="text">
                </div>

                <div>
                    <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Điểm</div>
                    <select name="giai" id="">
                        <option value=""></option>
                        <option value="">4.5</option>
                        <option value="">5</option>
                        <option value="">5.5</option>
                        <option value="">6</option>
                        <option value="">6.5</option>
                        <option value="">7</option>
                        <option value="">7.5</option>
                        <option value="">8</option>
                        <option value="">8.5</option>
                        <option value="">9</option>
                    </select>
                </div>

                <div style="position: relative; display: flex; flex-direction: column; justify-content: space-between; width: 100px; height: 72px;">
                    <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Minh chứng</div>
                    <input type="file" id="fileInput_ilets" style="visibility: hidden; position: absolute; top: 31px; font-size: 10px; left: 0px;">
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
                    <input type="text">
                </div>

                <div style="position: relative; display: flex; flex-direction: column; justify-content: space-between; width: 100px; height: 72px;">
                    <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Minh chứng</div>
                    <input type="file" id="fileInput_otherAchieve" style="visibility: hidden; position: absolute; top: 31px; font-size: 10px; left: 0px;">
                    <span id="form_upload_minhchung_otherAchieve" style=" color: #000; height: 22px;">
                            <i class="ti-cloud-up"></i>
                            <span style="font-size: 12px;">Tải lên</span>
                        </span>
                </div>
            </div>
        </div>

        <div class="diem_uu_tien" style="font-size: 18px; font-weight: bold; color: #b50206;">2. Điểm ưu tiên</div>
        <div class="priority_poin achievements">
            <div>
                <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Khu vực</div>
                <select name="khuvuc" id="">
                    <option value=""></option>
                    <option value="">THPT Chuyên Nguyễn Huệ</option>
                    <option value="">THPT Chuyên Đại Học Sư Phạm</option>
                </select>
            </div>

            <div>
                <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Đối tượng ưu tiên</div>
                <input type="text">
            </div>

            <div style="position: relative; display: flex; flex-direction: column; justify-content: space-between; width: 100px; height: 72px;">
                <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Minh chứng</div>
                <input type="file" id="fileInput_priority" style="visibility: hidden; position: absolute; top: 31px; font-size: 10px; left: 0px;">
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
                <select name="khuvuc" id="">
                    <option value=""></option>
                    <option value="">THPT Chuyên Nguyễn Huệ</option>
                    <option value="">THPT Chuyên Đại Học Sư Phạm</option>
                </select>
            </div>

            <div style="flex: 1.2;">
                <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Tổ hợp đăng ký</div>
                <select name="khuvuc" id="">
                    <option value=""></option>
                    <option value="">THPT Chuyên Nguyễn Huệ</option>
                    <option value="">THPT Chuyên Đại Học Sư Phạm</option>
                </select>
            </div>

        </div>

        <br>
        <input type="submit" class="btn btn-success" style="width: 136px; height: 40px;" value="Đánh giá hồ sơ">

        <div class="danh_gia">
            <div>- Điểm thành tích học tập: </div>
            <div>- Điểm học bạ: </div>
            <div>- Điểm ưu tiên: </div>
        </div>
        <br><br>
        <input type="submit" class="btn btn-primary" value="Nộp hồ sơ" name="submit1" style="text-align: center; width: 100%; height: 36px; color: #fff;"/>
    </div>



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
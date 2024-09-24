<div class="overlay" style="overflow: scroll ;position: fixed; top: 0; bottom: 0; left: 0; right: 0; background-color: rgba(0, 0, 0, 0.2); display: none;">
    <div class="overlay_content">
        <form id="form" method="post" enctype="multipart/form-data" style="background-color: #fff; width: 800px; margin: auto; padding: 0 16px;">
            <div class="container" style="width: 800px;">
                <div class="infor_text">
                    THÔNG TIN CÁ NHÂN
                </div>
                <hr>

                <div class="infor_content">
                    <div class="left_content">
                        <div>
                            <input type="file" id="fileInput_potrait" accept="image/*" hidden>
                            <img id="preview" alt="" src="">
                        </div>
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

                                <!-- xử lí  -->
                            </select>
                        </div>

                        <div>
                            <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Lớp chuyên</div>
                            <input name="lopchuyen" type="text">
                        
                            <!-- xử lí  -->
                        </div>

                        <div style="position: relative; display: flex; flex-direction: column; justify-content: space-between; width: 100px; height: 72px;">
                            <!-- img -->
                        </div>
                    </div>


                    <!-- Giải hs giỏi -->
                    <div class="mb_top_8px" style="font-weight: 600;">1.2. Giải học sinh giỏi (nếu có)</div>
                    <div class="achievements">
                        <div>
                            <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Môn thi</div>
                            <select name="monthi" id="">
                                <option value=""></option>
                                
                                <!-- xử lí  -->
                            </select>
                        </div>

                        <div>
                            <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Giải</div>
                            <select name="giai" id="">
                                <option value=""></option>

                                <!-- xử lí  -->
                            </select>
                        </div>

                        <div style="position: relative; display: flex; flex-direction: column; justify-content: space-between; width: 100px; height: 72px;">
                            <!-- img -->
                        </div>	
                    </div>


                    <!-- Chứng chỉ ielts -->
                    <div class="mb_top_8px" style="font-weight: 600;">1.3. Chứng chỉ ielts (nếu có)</div>
                    <div class="achievements">
                        <div>
                            <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Mã chứng nhận</div>
                            <input name="machungnhan" type="text">
                            <!-- xử lí  -->
                        </div>

                        <div>
                            <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Điểm</div>
                            <select name="diem" id="">
                                <option value=""></option>
                                
                            <!-- xử lí  -->
                            </select>
                        </div>

                        <div style="position: relative; display: flex; flex-direction: column; justify-content: space-between; width: 100px; height: 72px;">
                            <!-- img -->
                        </div>
                    </div>

                    <!-- Giải thương khác -->
                    <div class="mb_top_8px" style="font-weight: 600;">1.4. Các thành tích giải thưởng khác</div>
                    <div class="achievements">
                        <div>
                            <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Mô tả</div>
                            <input name="doituonguutien" type="text">
                            <!-- xử lí  -->
                        </div>

                        <div style="position: relative; display: flex; flex-direction: column; justify-content: space-between; width: 100px; height: 72px;">
                            <!-- img -->
                        </div>
                    </div>
                </div>


                <!-- Điểm ưu tiên -->
                <div class="diem_uu_tien" style="font-size: 18px; font-weight: bold; color: #b50206;">2. Điểm ưu tiên</div>
                <div class="priority_point achievements">
                    <div>
                        <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Khu vực</div>
                        <select name="khuvuc" id="">
                            <option value=""></option>

                            <!-- xử lí  -->
                        </select>
                    </div>

                    <div>
                        <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Đối tượng ưu tiên</div>
                        <input name="doituonguutien" type="text">
                        <!-- xử lí  -->

                    </div>

                    <div style="position: relative; display: flex; flex-direction: column; justify-content: space-between; width: 100px; height: 72px;">
                        <!-- img -->
                    </div>
                </div>

                <div class="nguyen_vong" style="font-size: 18px; font-weight: bold; color: #b50206;">3. Đăng ký nguyện vọng xết tuyển</div>
                <div class="register achievements">
                    <div style="flex: 1;">
                        <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Ngành đăng ký</div>
                        <select name="chonnganh" id="chonnganh" required>
                            <option value=""></option>
                            <!-- xử lí -->
                        </select>
                    </div>


                    <div style="flex: 1.3;">
                        <div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Tổ hợp đăng ký</div>
                        <select name="toHopDangKy" id="toHopDangKy" required>
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                
                <br>
                <input type="submit" class="btn btn-primary" value="Close" name="send" style="text-align: center; width: 100%; height: 36px; color: #fff; background-color: #b50206;"/>
                
            </div>

        </form>
    </div>
</div>
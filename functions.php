<?php 
    include './database/connect.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/PHPMailer/src/Exception.php';
    require 'vendor/PHPMailer/src/PHPMailer.php';
    require 'vendor/PHPMailer/src/SMTP.php';
?>

<?php
    function queryNoReturn($sql){
        global $connect;
        mysqli_query($connect, $sql);
    }

    function queryReturn($sql){
        global $connect;
        $result = mysqli_query($connect, $sql);
        return $result;
    }

    function checkEmailExist($email){
        global $connect;
        $condition = [
            'email' => $email
        ];
        $result1 = select('teachers', '*', $condition);
        $result2 = select('students', '*', $condition);
        
        if(mysqli_num_rows($result1) > 0 || mysqli_num_rows($result2) > 0){
            return true;
        } else {
            return false;
        }
    }


    // lấy ra array ngành mà giáo viên được phân dựa vào id_teacher
    function getArrayMajorsFromIdTeacher($id_teacher){
        global $connect;
        $sql = "SELECT major_name from majors inner join phannganh_giaovien 
			on majors.id_major = phannganh_giaovien.id_major
			where phannganh_giaovien.id_teacher = '$id_teacher';";
        $query = mysqli_query($connect, $sql);
        $array_chuyennganh_duocphan = array();
        while($r = mysqli_fetch_array($query)){
            array_push($array_chuyennganh_duocphan, $r['major_name']);
        }
        return $array_chuyennganh_duocphan;
    }


    function getIdTeacherFromUsername($taiKhoan){
        global $connect;
        $condition = [
            'username' => $taiKhoan
        ];

        $query = select('teachers', '*', $condition);
        $id_teacher = mysqli_fetch_array($query)['id_teacher'];
        return $id_teacher;
    }


    function getAllUsernameTeacher(){
        global $connect;
        $res = select('teachers', '*', '');
        $array_username_teacher = array();
        while($r = mysqli_fetch_array($res)){
            array_push($array_username_teacher, $r['username']);
        }
        return $array_username_teacher;
    }


    function getStudentNameById($id_student){
        $condition = [
            'id_student' => $id_student
        ];
        $query = select('students', '*', $condition);
        $student_name = mysqli_fetch_array($query)['username'];
        return $student_name;
    }

    function updateLedger($status, $id, $id_teacher){
        global $connect;
        $sql_update_ledger = "UPDATE ledgers SET
								ledger_status = '$status',
								id_teacher = " . $id_teacher ."
							WHERE id_ledger = $id";
		mysqli_query($connect, $sql_update_ledger);
    }


    function insert($table, $data) {
        global $connect;
    
        // Trích xuất các cột (keys) và giá trị (values) từ mảng $data
        $columns = implode(', ', array_keys($data));
        $values = array_map(function ($val) use ($connect) {
            // Escaping dữ liệu để tránh SQL Injection
            return "'" . mysqli_real_escape_string($connect, $val) . "'";
        }, array_values($data));
    
        // Nối các giá trị thành chuỗi
        $values = implode(', ', $values);
    
        // Tạo câu lệnh SQL
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
    
        // Thực thi câu lệnh SQL
        $result = mysqli_query($connect, $sql);
    
        // Trả về true nếu thành công, false nếu thất bại
        return $result ? true : false;
    }
    

    function select($table, $value, $condition) {
        global $connect;
    
        // Nếu $value là mảng, chuyển thành chuỗi các cột
        if (is_array($value)) {
            $value = implode(', ', array_map(function ($col) use ($connect) {
                return mysqli_real_escape_string($connect, $col);
            }, $value));
        } else {
            // Nếu không phải mảng, giữ nguyên giá trị (hoặc là '*')
            $value = ($value == '*') ? '*' : mysqli_real_escape_string($connect, $value);
        }
        
        // Nếu $condition là mảng, chuyển thành chuỗi điều kiện
        if (is_array($condition)) {
            $conditionArray = [];
            foreach ($condition as $key => $val) {
                $key = mysqli_real_escape_string($connect, $key);
                $val = mysqli_real_escape_string($connect, $val);
                $conditionArray[] = "$key='$val'";
            }
            $condition = implode(' AND ', $conditionArray);
        }
    
        // Nếu $condition rỗng, mặc định là '1'
        $condition = ($condition == '') ? '1' : $condition;
    
        // Xây dựng câu lệnh SQL
        $sql = "SELECT $value FROM $table WHERE $condition;";
        
        // Thực thi câu lệnh SQL
        $query = mysqli_query($connect, $sql);
        return $query;
    }

    function selectDistinct($table, $value, $condition) {
        global $connect;
    
        // Nếu $value là mảng, chuyển thành chuỗi các cột
        if (is_array($value)) {
            $value = implode(', ', array_map(function ($col) use ($connect) {
                return mysqli_real_escape_string($connect, $col);
            }, $value));
        } else {
            // Nếu không phải mảng, giữ nguyên giá trị (hoặc là '*')
            $value = ($value == '*') ? '*' : mysqli_real_escape_string($connect, $value);
        }
        
        // Nếu $condition là mảng, chuyển thành chuỗi điều kiện
        if (is_array($condition)) {
            $conditionArray = [];
            foreach ($condition as $key => $val) {
                $key = mysqli_real_escape_string($connect, $key);
                $val = mysqli_real_escape_string($connect, $val);
                $conditionArray[] = "$key='$val'";
            }
            $condition = implode(' AND ', $conditionArray);
        }
    
        // Nếu $condition rỗng, mặc định là '1'
        $condition = ($condition == '') ? '1' : $condition;
    
        // Xây dựng câu lệnh SQL
        $sql = "SELECT DISTINCT $value FROM $table WHERE $condition;";
        
        // Thực thi câu lệnh SQL
        $query = mysqli_query($connect, $sql);
        return $query;
    }


    function update($table, $value, $condition) {
        global $connect;
    
        // Xử lý các cột và giá trị trong phần SET
        $setArray = [];
        foreach ($value as $key => $val) {
            // Escaping dữ liệu để tránh SQL Injection
            $key = mysqli_real_escape_string($connect, $key);
            $val = mysqli_real_escape_string($connect, $val);
            $setArray[] = "$key='$val'";
        }
        $setClause = implode(', ', $setArray);
    
        // Xử lý điều kiện WHERE
        $conditionArray = [];
        foreach ($condition as $key => $val) {
            $key = mysqli_real_escape_string($connect, $key);
            $val = mysqli_real_escape_string($connect, $val);
            $conditionArray[] = "$key='$val'";
        }
        $conditionClause = implode(' AND ', $conditionArray);
    
        // Tạo câu lệnh SQL
        $sql = "UPDATE $table SET $setClause WHERE $conditionClause;";
    
        // Thực thi câu lệnh SQL
        $result = mysqli_query($connect, $sql);
    
        // Trả về true nếu thành công, false nếu thất bại
        return $result ? true : false;
    }

    function delete($table, $condition) {
        global $connect;
    
        // Xử lý điều kiện WHERE
        $conditionArray = [];
        foreach ($condition as $key => $val) {
            // Escaping dữ liệu để tránh SQL Injection
            $key = mysqli_real_escape_string($connect, $key);
            $val = mysqli_real_escape_string($connect, $val);
            $conditionArray[] = "$key='$val'";
        }
        $conditionClause = implode(' AND ', $conditionArray);
    
        // Tạo câu lệnh SQL
        $sql = "DELETE FROM $table WHERE $conditionClause;";
    
        // Thực thi câu lệnh SQL
        $result = mysqli_query($connect, $sql);
    
        // Trả về true nếu thành công, false nếu thất bại
        return $result ? true : false;
    }
    

    function getAvailableMajors(){
        global $connect;
        $s3 = "SELECT DISTINCT major_name FROM majors join chuyennganh on majors.id_major = chuyennganh.id_major
            where NOW() <= chuyennganh.time_end and chuyennganh.status = 'Hiện';";
        $query3 = mysqli_query($connect, $s3);
        return $query3;
    }

    function uploadFile($inputName) {
        $permitted_extensions = ['png', 'jpg', 'jpeg'];
        $file_name = $_FILES[$inputName]['name'];
        $file_extension = explode('.', $file_name);
        $file_extension = strtolower(end($file_extension));
        $fileInput = $_FILES[$inputName];
        $file_size = $fileInput['size'];
        
        $check = 1; // Khởi tạo biến kiểm tra mặc định là hợp lệ
        $m = "";
        $a = "";
    
        if (!in_array($file_extension, $permitted_extensions)) {
            $m = "invalid file type";
            $check = 0;
        }
        if ($file_size >= 10000000) {
            $a = "file is too large";
            $check = 0;
        }
    
        return [
            'check' => $check,
            'm' => $m,
            'a' => $a,
        ];
    }

    function uploadFileAndSave($inputName, $upload_dir, $fullname){
        $permitted_extensions = ['jpg', 'png', 'jpeg'];
        $file_name = $_FILES[$inputName]['name'];
        $file_tmp_name = $_FILES[$inputName]['tmp_name'];
        $file_extension = explode('.', $file_name);
        $file_extension = strtolower(end($file_extension));
        $generated_file_name = $fullname . '-' . time() . '.' . $file_extension;
        $destination_path = $upload_dir . $generated_file_name;
        if(in_array($file_extension, $permitted_extensions)){
            move_uploaded_file($file_tmp_name, $destination_path);
        }
        return $destination_path;
    }
    

    // function uploadAndUpdate($upload_dir, $id_student, $column_name, $data_parts, $fileInput) {
    //     global $connect;
    //     // Lấy thông tin file
    //     $file_name = $_FILES[$fileInput]['name'];
    //     $file_tmp_name = $_FILES[$fileInput]['tmp_name'];
        
    //     // Kiểm tra nếu có file
    //     if ($file_name != "") {
    //         $generated_file_name = time() . '-' . $file_name;
    //         $destination_path = $upload_dir . $generated_file_name;
    
    //         // Di chuyển file vào thư mục upload
    //         if (move_uploaded_file($file_tmp_name, $destination_path)) {
    //             // Gộp các phần dữ liệu lại thành chuỗi
    //             $data_parts[] = $destination_path; // Thêm đường dẫn file vào dữ liệu
    //             $final_value = implode(" | ", $data_parts);
    
    //             // Tạo câu lệnh SQL cập nhật
    //             // $sql = "UPDATE students SET $column_name = '$final_value' WHERE id_student = '$id_student';";
    //             // mysqli_query($connect, $sql);
    //             update('students', [$column_name => $final_value], ['id_student' => $id_student]);
    
    //             return true; // Thành công
    //         }
    //     }
    //     return false; // Thất bại
    // }
    
    function uploadAndUpdate($upload_dir, $id_student, $column_name, $data_parts, $fileInput) {
        $this_file = $_FILES[$fileInput];
        $file_name = $this_file['name'];
        $file_tmp_name = $this_file['tmp_name'];
        $destination_path = $upload_dir . time() . '-' . $file_name;
        if($file_name != ""){
            move_uploaded_file($file_tmp_name, $destination_path);
            // $data_parts[] = $destination_path; // Thêm đường dẫn file vào dữ liệu
            array_push($data_parts, $destination_path);
            $value_update = implode(" | ", $data_parts);
            update('students', [$column_name => $value_update], ['id_student' => $id_student]);
            return true;
        }
        return false;
    }
    
    // student_knowled_record
    function selectRecordStudent($id_student){
        global $connect;
        $sql_record ="SELECT
							ar.school,
							ar.address,
							ar.Toan,
							ar.NguVan,
							ar.TiengAnh,
							ar.VatLy,
							ar.HoaHoc,
							ar.SinhHoc,
							ar.LichSu,
							ar.DiaLy,
							ar.TinHoc,
							ar.CongNghe,
							ar.GiaoDucCongDan,
							ar.GiaoDucTheChat
						FROM students AS s
						JOIN academic_records AS ar ON s.id_student = ar.id_student
						WHERE s.id_student = '$id_student'";
        $query_record = mysqli_query($connect, $sql_record);
        return $query_record;
    }

    // hàm insert vào bảng phannganh_giaovien nếu cặp dữ liệu (major_id, teacher_id) không bị trùng lặp
	function insertIfNotExist($major_id, $teacher_id){
        global $connect;
        // Câu lệnh SQL để tạo và gọi stored procedure
        $sql = "
            DROP PROCEDURE IF EXISTS insert_if_not_exist;
            CREATE PROCEDURE insert_if_not_exist(
                IN major_id_param INT,
                IN teacher_id_param INT
            )
            BEGIN
                IF NOT EXISTS (
                    SELECT 1
                    FROM phannganh_giaovien
                    WHERE id_major = major_id_param AND id_teacher = teacher_id_param
                ) THEN
                    INSERT INTO phannganh_giaovien (id_major, id_teacher)
                    VALUES (major_id_param, teacher_id_param);
                END IF;
            END;
        ";

		if (mysqli_multi_query($connect, $sql)) {
            // đảm bảo rằng tất cả các kết quả từ các câu lệnh SQL được xử lý và bộ nhớ được giải phóng đúng cách
            do {
                //  lưu trữ kết quả của câu lệnh SQL hiện tại và trả về một đối tượng mysqli_result
                if ($result = $connect->store_result()) {
					// giải phóng bộ nhớ được sử dụng bởi đối tượng mysqli_result
                    $result->free();
                }
				//  $connect->more_results() : kiểm tra xem có còn kết quả khác từ các câu lệnh SQL chưa được xử lý không
				// $connect->next_result(): di chuyển đến kết quả tiếp theo để xử lý nếu có nhiều câu lệnh SQL
            } while ($connect->more_results() && $connect->next_result());

            // gọi stored procedure
            $insert_command = "CALL insert_if_not_exist($major_id, $teacher_id);";
            mysqli_query($connect, $insert_command);
            echo "insert success";
        } else {
            echo "insert failed";
        }
    }

    // hàm random ra 1 chuỗi 15 kí tự
    function generateRandomString() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        $maxIndex = strlen($characters) - 1;

        for ($i = 0; $i < 15; $i++) {
            $randomString .= $characters[random_int(0, $maxIndex)];
        }

        return $randomString;
    }

    function send_email($email_admin, $emailTeacher, $randomCode){
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $email_admin;                     //SMTP username
            $mail->Password   = 'fobc yprh fdlx jfss';                                //SMTP password
            $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS
    
            //Recipients
            $mail->setFrom($emailTeacher, 'Admin');
            $mail->addAddress($emailTeacher, 'Admin');     //Add a recipient

            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Pass Code';
            $mail->Body    = '<b>This is your passcode</b>';

            // lấy code bất kì còn hạn
            $mail->Body    = '<b>' . $randomCode . '</b>';
    
            $mail->send();

            header("location: admin_duyetTK.php");
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
?>
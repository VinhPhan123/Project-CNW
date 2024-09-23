<?php
    if(isset($_POST['tenNganh'])){
        $server = 'localhost';
        $user = 'root';
        $pass = 'Vinh123204@';
        $database = 'xettuyen';
        $connect = new mysqli($server, $user,$pass, $database);
        
        $tenNganh = $_POST['tenNganh'];
        $query1 = "SELECT * FROM majors WHERE major_name = '$tenNganh';";
        $result1 = mysqli_query($connect, $query1);
        $id_major = mysqli_fetch_array($result1)['id_major'];

        $query2 = " SELECT * FROM students AS s
                    JOIN ledgers AS l ON s.id_student = l.id_student
                    WHERE l.id_major = $id_major
                    ORDER BY l.id_SB, s.username;";
        $result2 = mysqli_query($connect, $query2);
        $arr_danh_sach = array();
        while($row = mysqli_fetch_array($result2)){
            array_push($arr_danh_sach, $row);
        }

        $output = '';

        foreach($arr_danh_sach as $arr){
            $output .= '<option value="' . $tohop . '">' . $tohop . '</option>';   
        }

        $output = '<option value=""></option>' . $output;

        $output = '<select required name="toHopDangKy" id="">' . $output . '</select>';

        echo $output;
    }
?>
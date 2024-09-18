<?php
    if(isset($_POST['tenNganh'])){
        $connect = new mysqli('localhost', 'root', '', 'xettuyen');
        $tenNganh = $_POST['tenNganh'];
        $query1 = "SELECT * FROM majors WHERE major_name = '$tenNganh';";
        $result1 = mysqli_query($connect, $query1);
        $id_major = mysqli_fetch_array($result1)['id_major'];

        $query2 = "SELECT * FROM chuyennganh WHERE id_major = '$id_major';";
        $result2 = mysqli_query($connect, $query2);

        $array_tohop = array();
        while($row = mysqli_fetch_array($result2)){
            array_push($array_tohop, $row['id_SB']);
        }

        $output = '';

        foreach($array_tohop as $tohop){
            $output .= '<option value="' . $tohop . '">' . $tohop . '</option>';   
        }

        $output = '<option value=""></option>' . $output;

        $output = '<select required name="toHopDangKy" id="">' . $output . '</select>';

        echo $output;
    }
?>
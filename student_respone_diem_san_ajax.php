<?php
    if(isset($_POST['tenNganh'])){
        $server = 'localhost';
        $user = 'root';
        $pass = 'Vinh123204@';
        $database = 'xettuyen';
        $connect = new mysqli($server, $user,$pass, $database);

        $tenNganh = $_POST['tenNganh'];
        $toHop = $_POST['toHop'];

        // lấy ra id_major
        $query1 = "SELECT * FROM majors WHERE major_name = '$tenNganh';";
        $result1 = mysqli_query($connect, $query1);
        $id_major = mysqli_fetch_array($result1)['id_major'];

        // lấy ra điểm sàn thông qua id_major và id_SB
        $query2 = "SELECT diem_san from chuyennganh
                where id_major=$id_major and id_SB='$toHop'";
        $result2 = mysqli_query($connect, $query2);
        $diem_san = mysqli_fetch_array($result2)['diem_san'];

        echo '<div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Điểm sàn</div>
            <input type="text" style="width: 55px; text-align: center;" id="diemsan" name="diemsan" value="' . $diem_san . '" readonly>';

    }
?>
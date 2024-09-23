<?php
    if(isset($_POST['id_major'])){
        $server = 'localhost';
        $user = 'root';
        $pass = 'Vinh123204@';
        $database = 'xettuyen';
        $connect = new mysqli($server, $user,$pass, $database);
        
        $output = '<tr>
                        <th>STT</th>
                        <th>Tên thí sinh</th>
                        <th>Tổ hợp đăng ký</th>
                        <th>Hồ sơ thí sinh</th>
                        <th>Access</th>
                        <th>Deny</th>
                    </tr>';
        if($_POST['id_major'] != ""){
            $id_major = $_POST['id_major'];
            $query2 = " SELECT * FROM students AS s
                        JOIN ledgers AS l ON s.id_student = l.id_student
                        WHERE l.id_major = $id_major
                        ORDER BY l.id_SB, s.username;";
            $result2 = mysqli_query($connect, $query2);
            $arr_danh_sach = array();
            while($row = mysqli_fetch_array($result2)){
                array_push($arr_danh_sach, $row);
            }
    
            if(count($arr_danh_sach) > 0){
                for($i = 0; $i < count($arr_danh_sach); $i++) {
                    $tmp = $i + 1;
                    $output .= '<tr>
                                    <td>' . $tmp . '</td>
                                    <td>' . $arr_danh_sach[$i]['fullname'] . '</td>
                                    <td>' . $arr_danh_sach[$i]['id_SB'] . '</td>
                                    <td>
                                        <form action="" method="post">
                                            <input type="hidden" name="id_ledger">
                                            <input type="button" class="btn btn-primary" value="View" name="view"/>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="" method="post">
                                            <input type="hidden" name="id_ledger">
                                            <input type="submit" class="btn btn-success" value="Access" name="access"/>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="" method="post">
                                            <input type="hidden" name="id_ledger">
                                            <input type="submit" class="btn btn-danger" value="Deny" name="deny"/>
                                        </form>
                                    </td>
                                </tr>';
                }
            } else {
                $output = '<tr>
                                <th>STT</th>
                                <th>Tên thí sinh</th>
                                <th>Tổ hợp đăng ký</th>
                                <th>Hồ sơ thí sinh</th>
                                <th>Access</th>
                                <th>Deny</th>
                            </tr>
                            <tr>
                                <td colspan="6">Không có thí sinh nào!</td>
                            </tr>';
            }
        } else {
            $output = '<tr>
                            <th>STT</th>
                            <th>Tên thí sinh</th>
                            <th>Tổ hợp đăng ký</th>
                            <th>Hồ sơ thí sinh</th>
                            <th>Access</th>
                            <th>Deny</th>
                        </tr>
                        <tr>
                            <td colspan="6">Bạn chưa chọn tổ hợp môn!</td>
                        </tr>';
        }

        echo $output;
    }
?>


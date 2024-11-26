<?php 
    include './layouts/header.php';
	include './XuLyPhien/student.php';
    include './functions.php'
?>

<style>
    table, th, tr, td {
        border: 1px solid #000;
        border-collapse: collapse;
    }

    th {
        font-size: 18px;
    }

    tr, td {
        font-size: 15px;
        font-weight: 500;
    }
</style>

<div style="display: flex; justify-content: center;">

<?php 
    if(isset($_SESSION['role'])) {
		include './layouts/menu.php';
	}
?>

<?php
    $id_student = $_SESSION['id_student'];
    // echo $id_student . '<br>';
?>

<?php
    // lấy ra tên các chuyên ngành đã đăng ký
    // $sql1 = "SELECT DISTINCT id_major FROM ledgers WHERE id_student='$id_student';";
    // $query1 = mysqli_query($connect, $sql1);

    $query1 = selectDistinct('ledgers', ['id_major'], ['id_student' => $id_student]);

    // lấy ra id_major 
    $array_id_major = array();
    while($r = mysqli_fetch_array($query1)){
        array_push($array_id_major, $r['id_major']);
    }
    // print_r($array_id_major);

    // lấy ra tên các chuyên ngành
    $array_id_major_chuyennganh = array();
    foreach($array_id_major as $id_major){
        // $sql2 = "SELECT * FROM majors WHERE id_major='$id_major';";
        // $query2 = mysqli_query($connect, $sql2);

        $query2 = select('majors', '*', ['id_major' => $id_major]);
        $chuyennganh = mysqli_fetch_array($query2)['major_name'];
        // array_push($array_chuyennganh, $chuyennganh);
        $array_id_major_chuyennganh[$id_major] = $chuyennganh;
    }
    // print_r($array_id_major_chuyennganh);
    // echo sizeof($array_id_major_chuyennganh);

    
?>

<div style="display: block; width: 100%;">
	
	<div class="container mt-4" style="width: max-content; margin-left: auto; margin-right: auto;">
	<!-- Page content -->

    <table>
        <th>STT</th>
        <th>Ngành xét tuyển</th>
        <th>Tổ hợp xét tuyển</th>
        <th>Giáo viên phụ trách</th>
        <th>Trạng thái</th>

        <?php 
            $index = 0;
            if (sizeof($array_id_major_chuyennganh) === 0) {
                echo '<tr><td colspan="5">Bạn chưa nộp hồ sơ nào!</td></tr>';
            } else {
                foreach($array_id_major_chuyennganh as $id_major => $chuyennganh){
                    // lấy ra số lượng các id_SB tương ứng với id_student, id_major
                    // $sql3 = "SELECT * from ledgers where id_student='$id_student' and id_major='$id_major';";
                    // $query3 = mysqli_query($connect, $sql3);
                    $query3 = select('ledgers', '*', ['id_student' => $id_student, 'id_major' => $id_major]);
                    $count = mysqli_num_rows($query3);
                    // echo $count . '<br>';

                    // lấy ra các id_SB
                    $array_id_SB = array();
                    while($r = mysqli_fetch_array($query3)){
                        array_push($array_id_SB, $r['id_SB']);
                    }
                    // print_r($array_id_SB);

                    ?>
                        <tr>
                            <td rowspan="<?php echo $count ?>"><?php echo $index ?></td>
                            <td rowspan="<?php echo $count ?>"><?php echo $chuyennganh ?></td>
                            <?php
                            foreach($array_id_SB as $id_SB){
                                echo '<td>' . $id_SB . '</td>';

                                // lấy ra giáo viên phụ trách dựa vào id_student, id_SB, id_major
                                // $sql4 = "SELECT * FROM ledgers where id_student='$id_student' and id_major='$id_major' and id_SB='$id_SB';";
                                // $query4 = mysqli_query($connect, $sql4);

                                $query4 = select('ledgers', '*', ['id_student' => $id_student, 'id_major' => $id_major, 'id_SB' => $id_SB]);
                                $id_teacher = mysqli_fetch_array($query4)['id_teacher'];

                                if($id_teacher != NULL){
                                    // lấy ra fullname teacher dựa vào id_teacher
                                    // $sql5 = "SELECT * FROM teachers WHERE id_teacher='$id_teacher';";
                                    // $query5 = mysqli_query($connect, $sql5);

                                    $query5 = select('teachers', '*', ['id_teacher' => $id_teacher]);
                                    $fullname_teacher = mysqli_fetch_array($query5)['fullname']; 
            
                                    // lấy ra ledger_status dựa vào id_student, id_SB, id_major, id_teacher
                                    // $sql6 = "SELECT * FROM ledgers where id_student='$id_student' and id_major='$id_major' and id_SB='$id_SB' and id_teacher='$id_teacher';";
                                    // $query6 = mysqli_query($connect, $sql6);
                                    $query6 = select('ledgers', '*', ['id_student' => $id_student, 'id_major' => $id_major, 'id_SB' => $id_SB, 'id_teacher' => $id_teacher]);
                                    $status_ledgers = mysqli_fetch_array($query6)['ledger_status'];
                                    
                                    // echo $status_ledgers;

                                    echo '<td>' . $fullname_teacher . '</td>';
                                    echo '<td>' . ($status_ledgers==null ? "Chờ duyệt" : $status_ledgers) . '</td>';
                                    echo '</tr>';
                                } else {
                                    echo '<td colspan="2">Chờ duyệt</td>';
                                    echo '</tr>';
                                }

                            }
                            $index += 1;
                        ?>
                <?php
                }
            }
        ?>
    </table>
     
	<!-- End Page content -->
	</div>
	<?php 
		include './layouts/footer.php';
	?>
</div>
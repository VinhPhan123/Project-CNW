<?php 
    include './layouts/header.php';
?>

<style>
    tr, td {
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
    // array all chuyên ngành [id_major => major_name]
    $query1 = select('majors', '*', '');
    $arr_majors = array();
    while($r = mysqli_fetch_array($query1)){
        $arr_majors[$r['id_major']] = $r['major_name'];
    }
?>


<div style="display: block; width: 100%;">

    <div class="container mt-4" style="width: max-content; margin-left: auto; margin-right: auto;">
        <!-- Page content -->

        <h2 style="text-align: center; margin-bottom: 20px;">Thống kê số lượng hồ sơ</h2>
        <table>
            <tr>
                <th>STT</th>
                <th>Ngành xét tuyển</th>
                <th>Đang chờ</th>
                <th>Không duyệt</th>
                <th>Đã duyệt</th>
                <th>Tổng số lượng</th>
            </tr>

        <?php 
            $query2 = select('ledgers', '*', '');
            if(mysqli_num_rows($query2) == 0){
                echo '<tr><td colspan="6">Không có hồ sơ nào được nộp</td></tr>';
            } else {
                $index = 1;
                foreach($arr_majors as $id_major => $major_name){
                    $query3 = select('ledgers', '*', ['id_major'=>$id_major, 'ledger_status'=>'Duyệt']);
                    $count_da_duyet = mysqli_num_rows($query3);

                    $query4 = select('ledgers', '*', ['id_major'=>$id_major, 'ledger_status'=>'Không duyệt']);
                    $count_khong_duyet = mysqli_num_rows($query4);

                    $sql = "SELECT * from ledgers where id_major = '$id_major' and ledger_status is NULL;";
                    $query4 = mysqli_query($connect, $sql);
                    $count_cho = mysqli_num_rows($query4);

                    $query5 = select('ledgers', '*', ['id_major'=>$id_major]);
                    $count_all = mysqli_num_rows($query5);

                    echo '<tr>';
                    echo '<td>' . $index . '</td>';
                    echo '<td>' . $major_name . '</td>';
                    echo '<td>' . $count_cho . '</td>';
                    echo '<td>' . $count_khong_duyet . '</td>';
                    echo '<td>' . $count_da_duyet . '</td>';
                    echo '<td>' . $count_all . '</td>';
                    echo '</tr>';
                    $index += 1;
                }
            }
        ?>

</div>
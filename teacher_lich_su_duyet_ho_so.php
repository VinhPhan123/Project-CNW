
<?php 
    include './layouts/header.php';
	include './XuLyPhien/teacher.php';
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


    $query1 = select('teachers', '*', ['username'=> $_SESSION['taiKhoan']]);
    while($r = mysqli_fetch_array($query1)){
        $id_teacher = $r['id_teacher'];
        $string_list_id_major = $r['major_id_list'];
    }

    $list_id_major = $array = array_map('intval', array_map('trim', explode('-', $string_list_id_major)));

    $list_major = array();
    $query = select('majors', '*', '');
    while($r = mysqli_fetch_array($query)){
        if(in_array($r['id_major'], $list_id_major)){
            array_push($list_major, $r['major_name']);
        }
    }
?>

<div style="display: block; width: 100%;">

    <div class="container mt-4" style="width: max-content; margin-left: auto; margin-right: auto;">
        <!-- Page content -->

        <h2 style="text-align: center; margin-bottom: 20px;">Lịch sử duyệt hồ sơ</h2>
        <table>
            <tr>
                <th>STT</th>
                <th>Ngành xét tuyển</th>
                <th>Không duyệt</th>
                <th>Đã duyệt</th>
                <th>Tổng số lượng</th>
            </tr>

        <?php 
            $query2 = select('ledgers', '*', ['id_teacher'=>$id_teacher]);
            if(mysqli_num_rows($query2) == 0){
                echo '<tr><td colspan="6">Chưa có hồ sơ nào được duyệt</td></tr>';
            } else {
                $index = 1;
                foreach($list_major as $major_name){
                    $queyr3 = select('majors', '*',  ['major_name' => $major_name]);
                    $id_major = mysqli_fetch_array($queyr3)['id_major'];

                    $query4 = select('ledgers', '*', ['id_major'=>$id_major, 'ledger_status'=>'Duyệt', 'id_teacher'=>$id_teacher]);
                    $count_da_duyet = mysqli_num_rows($query4);

                    $query5 = select('ledgers', '*', ['id_major'=>$id_major, 'ledger_status'=>'Không duyệt', 'id_teacher'=>$id_teacher]);
                    $count_khong_duyet = mysqli_num_rows($query5);

                    $query6 = select('ledgers', '*', ['id_major'=>$id_major, 'id_teacher'=>$id_teacher]);
                    $count_all = mysqli_num_rows($query6);

                    echo '<tr>';
                    echo '<td>' . $index . '</td>';
                    echo '<td>' . $major_name . '</td>';
                    echo '<td>' . $count_khong_duyet . '</td>';
                    echo '<td>' . $count_da_duyet . '</td>';
                    echo '<td>' . $count_all . '</td>';
                    echo '</tr>';
                    $index += 1;

                }
            }
        ?>

</div>
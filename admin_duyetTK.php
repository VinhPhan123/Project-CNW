<?php 
    include './layouts/header.php';
    include './XuLyPhien/admin.php';
    include './functions.php';
?>
<?php 
    $token = md5(uniqid());
?>


<?php
    $j = 0;

    // lấy ra email admin
    $s1 = "SELECT * FROM admins LIMIT 1;";
    $query = mysqli_query($connect, $s1);
    $query_table_admin = mysqli_fetch_assoc($query);
    $email_admin = $query_table_admin['email'];
    $id_admin = $query_table_admin['id_admin'];

    // echo $id_admin;



    // lấy ra những emails chưa được duyệt(status=1) trong bảng guest và gán giá trị vào mảng getEmails tương ứng với index $ii
    $i = 0;
    $getEmails = array(); // [key-value]
    $emails = [];
    $statuses = [];
    // $sql = "SELECT * FROM guest WHERE status=1;";
    // $result = mysqli_query($connect, $sql);
    $result = select('guest', '*', ['status'=>1]);
    while($row = mysqli_fetch_array($result)){
        array_push($emails, $row['teacher_email']);

        $getEmails[$i] = $row['teacher_email'];
        $i += 1;
    }

    // lấy ra số lượng email chưa được duyệt (status=1)
    $countEmails = mysqli_num_rows($result);
    // echo ($_POST['submitAccess']);
    // token ngăn gửi email nhiều lần nếu teachers chưa xác thực mà admin reload lại trang
    if(isset($_POST['submitAccess']) && $_SESSION['token'] == $_POST['_token']){
        // randomCode luu vao bang gen_code
        $randomCode = generateRandomString();

        $a1 = "INSERT INTO gen_code(id_admin, code, gen_time, expiry_time) VALUES ('$id_admin', '$randomCode', NOW(), DATE_ADD(NOW(), INTERVAL 2 MINUTE));";
        mysqli_query($connect, $a1);
        $row_id = $_POST['row_id'];

        $emailTeacher = $getEmails[$row_id];
        // echo $emailTeacher;
       
        send_email($email_admin, $emailTeacher, $randomCode);
        
        echo($emailTeacher);
    }

    if(isset($_POST['submitDeny'])){
        $row_id = $_POST['row_id'];
        $email_guest = $getEmails[$row_id];
        echo ($email_guest);
        // $b = "UPDATE guest SET status = 0 WHERE teacher_email = '$email_guest';";
        // mysqli_query($connect, $b);
        update('guest', ['status'=>0], ['teacher_email'=>$email_guest]);

        header("location: admin_duyetTK.php");
        exit();
    }
?>

<div style="display: flex; justify-content: center;">

<?php 
    if(isset($_SESSION['role'])) {
		include './layouts/menu.php';
	}
?>

<link rel="stylesheet" href="./assets/css/index.css">
<div style="display: block; width: 100%;">
	
<?php 
    if($countEmails != 0){
        echo '<form action="" method="post" style="min-height: 500px;">
                <table>
                    <th>STT</th>
                    <th>Email</th>
                    <th>Access</th>
                    <th>Deny</th>

                    <form action="" method="post">'?>
                    <?php
                    foreach($emails as $index => $email){
                        echo '<tr id="id_' . $j . '">';
                            echo '<td>' . $j . '</td>';
                            echo '<td>' . $email .'</td>';
                            echo '<td>
                                    <form action="" method="post">
                                        <input type="hidden" name="row_id" value="' . $j . '">
                                        <button type="submit" class="btn btn-primary" name="submitAccess">Click</button>
                                        <input type="hidden" name="_token" value="'?><?php echo $token .'"/>' ?>
				                        <?php $_SESSION['token'] = $token; ?>
                                    <?php echo '</form>
                                </td>';
                            echo '<td>
                                    <form action="" method="post">
                                        <input type="hidden" name="row_id" value="' . $j . '">
                                        <button type="submit" class="btn btn-danger" name="submitDeny">Click</button>
                                    </form>
                                </td>';
                            $j += 1;
                        echo '</tr>';
                    }
                    ?>
                        <?php
                    echo'
                    </form>
                </table>
            </form>'
                ?>
    <?php
    } else {
        echo '<div style="text-align: center; min-height: 1000px;">
                <h4>Không có tài khoản giáo viên đăng ký mới</h4>
            </div>';
    }
    ?>


	<?php 
		include './layouts/footer.php';
	?>
</div>
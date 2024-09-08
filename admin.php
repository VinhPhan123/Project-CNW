<?php 
    include './layouts/header.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/PHPMailer/src/Exception.php';
    require 'vendor/PHPMailer/src/PHPMailer.php';
    require 'vendor/PHPMailer/src/SMTP.php';
?>

<?php 
    // nếu chưa đăng nhập thì out
    $sql = "SELECT * FROM admins;";
    $res = mysqli_query($connect, $sql);
    $query_username = mysqli_fetch_array($res);
    $username_admin = $query_username['username'];
    if($_SESSION['taiKhoan'] != $username_admin){
        header("location: logout.php");
    }
?>

<?php 
    $token = md5(uniqid());
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
    $sql = "SELECT * FROM guest WHERE status=1;";
    $result = mysqli_query($connect, $sql);
    while($row = mysqli_fetch_array($result)){
        array_push($emails, $row['teacher_email']);

        $getEmails[$i] = $row['teacher_email'];
        $i += 1;
    }

    // lấy ra số lượng email chưa được duyệt (status=1)
    $countEmails = mysqli_num_rows($result);


    if(isset($_POST['submitAccess'])){
        // randomCode luu vao bang gen_code
        $randomCode = generateRandomString();
        $a1 = "INSERT INTO gen_code(id_admin, code, gen_time, expiry_time) VALUES ('$id_admin', '$randomCode', NOW(), DATE_ADD(NOW(), INTERVAL 1 MINUTE));";
        mysqli_query($connect, $a1);
        
        $row_id = $_POST['row_id'];

        $emailTeacher = $getEmails[$row_id];

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $email_admin;                     //SMTP username
            $mail->Password   = 'smab floy tdrw zizh';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($emailTeacher, 'Admin');
            $mail->addAddress($emailTeacher, 'Admin');     //Add a recipient

            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Pass Code';
            $mail->Body    = '<b>This is your passcode</b>';

            // lấy code bất kì còn hạn
            $mail->Body    = '<b>' . $randomCode . '</b>';
    
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }


        // echo "Access clicked for row " . $row_id;
    }

    if(isset($_POST['submitDeny'])){
        $row_id = $_POST['row_id'];
        $email_guest = $getEmails[$row_id];
        $b = "UPDATE guest SET status = 0 WHERE teacher_email = '$email_guest';";
        mysqli_query($connect, $b);

        header("location: admin.php");
        // echo "Deny clicked for row " . $row_id;
    }
?>

<?php 
    if($countEmails != 0){
        echo '<form action="" method="post">
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
                                    </form>
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
    <?php }?>

<script>
    console.log(document.getElementById("id_1"));
</script>

<div id="dev"></div>

<?php 
    include './layouts/footer.php';
?>
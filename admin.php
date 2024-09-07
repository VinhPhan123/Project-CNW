<?php 
    include './layouts/header.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/PHPMailer/src/Exception.php';
    require 'vendor/PHPMailer/src/PHPMailer.php';
    require 'vendor/PHPMailer/src/SMTP.php';
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


    // lấy ra các code còn thời hạn
    // $codes = array();
    // $s2 = "SELECT code FROM gen_code WHERE (expiry_time-gen_time)>0;";
    // $query_code = mysqli_query($connect, $s2);
    // while($r = mysqli_fetch_array($query_code)) {
    //     array_push($codes, $r['code']);
    // }

    // 
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

        // if($row['status'] == 1){
        //     array_push($statuses, "chưa duyệt");
        // } else if($row['status'] == 0){
        //     array_push($statuses, "hủy");
        // } else if($row['status'] == 2){
        //     array_push($statuses, "xác nhận");
        // }
    }


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

<form action="" method="post">
    <table>
        <th>STT</th>
        <th>Email</th>
        <th>Access</th>
        <th>Deny</th>

        <form action="" method="post">
        <?php
        foreach($emails as $index => $email){
            // $status = $statuses[$index];
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
            ?>
            <?php
        }
        ?>
        </form>
    </table>
</form>



<script>
    console.log(document.getElementById("id_1"));
</script>

<div id="dev"></div>

<?php 
    include './layouts/footer.php';
?>
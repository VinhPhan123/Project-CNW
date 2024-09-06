<?php 
    include './layouts/header.php';
?>

<?php
    $sql = "SELECT * FROM guest;";

    $result = mysqli_query($connect, $sql);


    $emails = [];
    $statuses = [];
    while($row = mysqli_fetch_array($result)){
        array_push($emails, $row['teacher_email']);
        if($row['status'] == 1){
            array_push($statuses, "chưa duyệt");
        } else if($row['status'] == 0){
            array_push($statuses, "hủy");
        } else if($row['status'] == 2){
            array_push($statuses, "xác nhận");
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table, th, tr, td {
            border: 1px solid #000;
            text-align: center;
        }
        td {
            height: 50px;
            width: 100px;
        }
    </style>
</head>
<body>
    <form action="">
        <table>
            <th>Email</th>
            <th>Status</th>
            <th>Access</th>
            <th>Deny</th>
            
            <?php
            echo '<tr>';
                foreach($emails as $index => $email){
                    $status = $statuses[$index];
                    echo '<td>' . $email .'</td>';
                    echo '<td>' . $status .'</td>';
                    echo '<td> <button type="submit" class="btn btn-primary" id="access">Click</button> </td>';
                    echo '<td> <button type="submit" class="btn btn-danger" id="deny">Click</button> </td>';
                }
            echo '</tr>';
            ?>
        </table>
    </form>
</body>
</html>

<?php 
    include './layouts/footer.php';
?>
<?php
    if(!isset($_SESSION['role'])) {
        echo '<script>alert("Chỉ giáo viên mới được điều hướng đến trang này!")</script>';
        header("Refresh:0; url=logout.php");
        exit();
    } else {
        if($_SESSION['role'] != "teacher") {
            echo '<script>alert("Chỉ giáo viên mới được điều hướng đến trang này!")</script>';
            header("Refresh:0; url=index.php");
            exit();
        }
    }
?>
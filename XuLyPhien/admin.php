<?php
    if(!isset($_SESSION['role'])) {
        echo '<script>alert("Chỉ admin mới được điều hướng đến trang này!")</script>';
        header("Refresh:0; url=logout.php");
        exit();
    } else {
        if($_SESSION['role'] != "admin") {
            echo '<script>alert("Chỉ admin mới được điều hướng đến trang này!")</script>';
            header("Refresh:0; url=index.php");
            exit();
        }
    }
?>
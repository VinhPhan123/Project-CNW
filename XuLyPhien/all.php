<?php
    if(!isset($_SESSION['role'])) {
        echo '<script>alert("Bạn không được phép điều hướng tới trang này khi chưa đăng ký hoặc đăng nhập!")</script>';
        header("Refresh:0; url=logout.php");
        exit();
    }
?>
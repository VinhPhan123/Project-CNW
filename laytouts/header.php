<?php 
    include './database/connect.php';
	session_start();
	$current_page = $_SERVER['PHP_SELF'];
?>

<?php
	$uri = $_SERVER['REQUEST_URI'];
	if(!strpos($uri, "/xacthuc.php")) {
		if (isset($_SESSION['taiKhoan'])) {
			$taiKhoan = $_SESSION['taiKhoan'];

			$sql_admins = "SELECT * FROM admins WHERE username ='$taiKhoan'";
			$sql_teachers = "SELECT * FROM teachers WHERE username ='$taiKhoan'";
			$sql_students = "SELECT * FROM students WHERE username ='$taiKhoan'";
	
			$query_admins = mysqli_query($connect, $sql_admins);
			$query_teachers = mysqli_query($connect, $sql_teachers);
			$query_students = mysqli_query($connect, $sql_students);
	
			$result_admins = mysqli_num_rows($query_admins);
			$result_teachers = mysqli_num_rows($query_teachers);
			$result_students = mysqli_num_rows($query_students);
	
			
			$check = true;
			if($result_admins == 1) {
				$_SESSION['role'] = "admin";
				$arr = mysqli_fetch_array($query_admins);
			} elseif($result_teachers == 1) {
				$_SESSION['role'] = "teacher";
				$arr = mysqli_fetch_array($query_teachers);
			} elseif($result_students == 1) {
				$_SESSION['role'] = "student";
				$arr = mysqli_fetch_array($query_students);
			} else {
				$check = false;
			}
			if($check == false) {
				$email = $_SESSION['email'];
				$sql = "DELETE FROM guest WHERE teacher_email = '$email'";
				mysqli_query($connect, $sql);

				header("location: ./logout.php");
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/dangky.css">
</head>
<body>


<nav class="container navbar navbar-expand-lg bg-light">
		<div class="container-fluid">
			<a class="navbar-brand" href="index.php"> <img
				src="./assets/img/logo_blue.svg"
				alt="Bootstrap">
			</a>
			<button class="navbar-toggler" type="button"
				data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
				aria-controls="navbarSupportedContent" aria-expanded="false"
				aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item"><a class="nav-link active"
						aria-current="page" href="#">Trang chủ</a></li>
					<li class="nav-item"><a class="nav-link" href="#"></a></li>
					<li class="nav-item dropdown"><a
						class="nav-link dropdown-toggle" href="#" role="button"
						data-bs-toggle="dropdown" aria-expanded="false"> Thể loại </a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="#">Quần Jean</a></li>
							<li><a class="dropdown-item" href="#">Áo thun</a></li>
							<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item" href="#">Áo sơ mi</a></li>
						</ul></li>
					<li class="nav-item"><a class="nav-link disabled">Hết hàng</a>
					</li>
				</ul>
				
				<form class="d-flex" role="search" style="position: relative;display: block;float: right;">
					<input class="form-control me-2" type="search"
						placeholder="Nội dung tìm kiếm" aria-label="Search">
					<button class="btn btn-outline-success" type="submit">Tìm</button>
                
                <?php 
					// if(isset($_SESSION['taiKhoan'])){
                    if(isset($_SESSION['taiKhoan']) && (!strpos($current_page, 'dangky.php')) && (!strpos($current_page, 'xacthuc.php'))){
                ?>
					<ul class="navbar-nav me-auto mb-2 mb-lg-0 bg-infor ">
						<li class="nav-item dropdown dropstart"><a
							class="nav-link dropdown-toggle" href="#" role="button"
							data-bs-toggle="dropdown" aria-expanded="false">
							<?php echo($_SESSION['hoVaTen']);
							?></a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="#">Đơn hàng của tôi</a></li>
								<li><a class="dropdown-item" href="#">Thông báo</a></li>
								<li><a class="dropdown-item" href="thaydoithongtin.jsp">Thay đổi thông tin</a></li>
								<li><a class="dropdown-item" href="doimatkhau.jsp">Đổi mật khẩu</a></li>
								<li><hr class="dropdown-divider"></li>
								<li><a class="dropdown-item" href="logout.php" id="logout">Thoát tài khoản</a></li>
							</ul></li>
					</ul>			
                <?php } else { ?>	
                    <?php 
                       
                        // echo $current_page;
                        if(strpos($current_page, 'dangky.php')) {    
                    ?>
                        <a class="btn btn-primary" style="white-space: nowrap;" href="<?php echo 'dangnhap.php'?>">
							Đăng nhập
                        </a>
                    <?php }else if(strpos($current_page, 'dangnhap.php')) {?>
                        <a class="btn btn-primary" style="white-space: nowrap;" href="<?php echo 'dangky.php'?>">
							Đăng ký
                        </a>
                    <?php } else {?>
                        <a class="btn btn-primary" style="white-space: nowrap;" href="<?php echo 'dangnhap.php'?>">
                                Đăng nhập
                        </a>
                        <a class="btn btn-primary" style="white-space: nowrap;" href="<?php echo 'dangky.php'?>">
                                Đăng ký
                        </a>
                    <?php } ?>
				</form>
                <?php } ?>
				
			</div>
		</div>
	</nav>
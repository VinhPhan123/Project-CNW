<?php 
    include './laytouts/header.php';
?>

<?php 
    if(isset($_POST['submit'])) {
        $taiKhoan = $_POST['taiKhoan'];
        $matKhau = $_POST['matKhau'];
        $matKhau_hashed = md5($matKhau);

        $sql = "SELECT * FROM user WHERE taiKhoan='$taiKhoan' AND matKhau='$matKhau_hashed'";

        $result = mysqli_query($connect, $sql);

        if(mysqli_num_rows($result) == 1){
            $_SESSION['taiKhoan'] = $taiKhoan;
            header("location: index.php");
        }
    }

?>


<main class="form-signin w-50 m-auto">
    <form class="text-center" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <img src="<%=url %>/img/logo/logo.png" alt="" height="70" style="margin: 0px">
    <h1 class="h3 mb-3 fw-normal">Đăng nhập</h1>
    <div class="text-center"><span class="red"><?php $baoLoi ?></span></div>

    <div class="form-floating">
        <input type="text" class="form-control" id="taiKhoan" placeholder="Tên đăng nhập" name="taiKhoan">
        <label for="taiKhoan">Tên đăng nhập</label>
    </div>
    <div class="form-floating">
        <input type="password" class="form-control" id="matKhau" placeholder="Password" name="matKhau">
        <label for="matKhau">Mật khẩu</label>
    </div>

    <div class="form-check text-start my-3">
        <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
        <label class="form-check-label" for="flexCheckDefault">
        Remember me
        </label>
    </div>
    <button name="submit" class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
    <a href="dangky.php">Đăng ký tài khoản mới</a>
    
    <p class="mt-5 mb-3 text-body-secondary">&copy; 2017–2024</p>
    </form>
</main>


<?php 
    include './laytouts/footer.php'
?>
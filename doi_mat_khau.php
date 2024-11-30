<?php
    include './functions.php';
    include './database/connect.php';
    include './layouts/header.php';
    include './XuLyPhien/all.php';
?>

<div style="display: flex; justify-content: center; flex-direction: column;">

<?php 
    if(isset($_SESSION['role'])) {
		include './layouts/menu.php';
	}
    // echo $_SESSION['role'];
    // echo '<br>';
    // echo $_SESSION['taiKhoan'];
    $token = md5(uniqid());
?>

<?php 
    if(isset($_POST['submit']) && $_SESSION['token'] == $_POST['_token']) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $new_password_rewrite = $_POST['new_password_rewrite'];
        if($new_password !== $new_password_rewrite){
            ?>
            <script>
                alert("Mật khẩu nhập lại không khớp!");
            </script>
            <?php
        } else {
            $current_pass_hash = md5($current_password);
            $new_pass_hash = md5($new_password);
            $role = $_SESSION['role'];
            if($role === 'student') {
                $query = select('students', '*', ['username' => $_SESSION['taiKhoan']]);
                $password_from_db = mysqli_fetch_array($query)['password'];

                if($current_pass_hash === $password_from_db){
                    if($password_from_db === $new_pass_hash){
                        ?>
                            <script>
                                alert("Mật khẩu mới không được trùng với mật khẩu cũ!");
                            </script>
                        <?php
                    } else {
                        update(
                            'students',
                            ['password' => $new_pass_hash],
                            ['username' => $_SESSION['taiKhoan']]
                        );
                        ?>
                            <script>
                                alert("Mật khẩu đã được cập nhật, hãy đăng nhập lại!")
                                window.location = 'index.php';
                            </script>
                        <?php
                    }
                } else {
                    ?>
                    <script>
                        alert("Mật khẩu không chính xác!");
                    </script>
                    <?php
                }

            } else if($role === 'teacher') {
                $query = select('teachers', '*', ['username' => $_SESSION['taiKhoan']]);
                $password_from_db = mysqli_fetch_array($query)['password'];

                if($current_pass_hash === $password_from_db){
                    if($password_from_db === $new_pass_hash){
                        ?>
                            <script>
                                alert("Mật khẩu mới không được trùng với mật khẩu cũ!");
                            </script>
                        <?php
                    } else {
                        update(
                            'teachers',
                            ['password' => $new_pass_hash],
                            ['username' => $_SESSION['taiKhoan']]
                        );
                        ?>
                            <script>
                                alert("Mật khẩu đã được cập nhật, hãy đăng nhập lại!")
                                window.location = 'index.php';
                            </script>
                        <?php
                    }
                } else {
                    ?>
                    <script>
                        alert("Mật khẩu không chính xác!");
                    </script>
                    <?php
                }
            } else if($role === 'admin') {
                $query = select('admins', '*', ['username' => $_SESSION['taiKhoan']]);
                $password_from_db = mysqli_fetch_array($query)['password'];

                if($current_pass_hash === $password_from_db){
                    if($password_from_db === $new_pass_hash){
                        ?>
                            <script>
                                alert("Mật khẩu mới không được trùng với mật khẩu cũ!");
                            </script>
                        <?php
                    } else {
                        update(
                            'admins',
                            ['password' => $new_pass_hash],
                            ['username' => $_SESSION['taiKhoan']]
                        );
                        ?>
                            <script>
                                alert("Mật khẩu đã được cập nhật, hãy đăng nhập lại!")
                                window.location = 'index.php';
                            </script>
                        <?php
                    }
                } else {
                    ?>
                    <script>
                        alert("Mật khẩu không chính xác!");
                    </script>
                    <?php
                }
            }
        }
    }
?>

<h2 style="text-align: center; margin: 8px 0px 30px 0;">Change Password</h2>
<div class="container" style="width: 600px;">
    <form method="post">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label" style="font-weight: 600;">Mật khẩu hiện tại</label>
            <input type="text" name="current_password" class="form-control" id="exampleInputEmail1 name" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label" style="font-weight: 600;">Mật khẩu mới</label>
            <input type="password" name="new_password" class="form-control" id="matKhau" required="required" onkeyup="kiemTraMatKhau()">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label" style="font-weight: 600;">Nhập lại mật khẩu</label>
            <input type="password" name="new_password_rewrite" class="form-control" id="matKhauNhapLai" required="required" onkeyup="kiemTraMatKhau()">
            <span class="red" id="msg"></span>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        <input type="hidden" name="_token" value="<?php echo $token ?>">
        <?php $_SESSION['token'] = $token; ?>
    </form>
</div>

<script type="text/javascript">
	function kiemTraMatKhau(){
		matKhau = document.getElementById("matKhau").value;
		matKhauNhapLai = document.getElementById("matKhauNhapLai").value;
		if(matKhau != matKhauNhapLai){
			document.getElementById("msg").innerHTML = "Mật khẩu không khớp!";
			return false;
		} else{
			document.getElementById("msg").innerHTML = "";
			return true;
		}
	}

</script>

</div>
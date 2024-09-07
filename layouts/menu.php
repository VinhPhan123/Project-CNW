<link rel="stylesheet" href="./assets/css/menu.css">

<button class="button-open" id="button-open">
    <div class="button-block">
        <div class="button-line"></div>
        <div class="button-line"></div>
        <div class="button-line"></div>
    </div>
</button>
<menu id="menu">
    <div class="menu">
        <div class="menu-tag">ĐIỀU HƯỚNG</div>
        <div class="button-close" id="button-close">X</div>
        <ul class="dropdown">
            <li class="dropdown-item"><a href="index.php?#">Trang chủ</a></li>
            <li class="dropdown-item"><a href="">test</a></li>
            <li class="dropdown-item"><a href="">test</a></li>
        </ul>
        <ul class="dropdown">
            <?php
                if($_SESSION['role'] == "admin") {
                    echo("<p>GIÀNH CHO ADMIN</p>");
                    echo('<li class="dropdown-item"><a href="">Nộp hồ sơ</a></li>');
                    echo('<li class="dropdown-item"><a href="">Tạo Hồ sơ</a></li>');
                    echo('<li class="dropdown-item"><a href="">Danh sách ngành</a></li>');
                    echo('<li class="dropdown-item"><a href="">Phân ngành GV</a></li>');
                } elseif($_SESSION['role'] == 'teacher') {
                    echo("<p>GIÀNH CHO TEACHER</p>");
                } else {
                    echo("<p>GIÀNH CHO STUDENT</p>");
                    echo('<li class="dropdown-item"><a href="">Học bạ</a></li>');
                    echo('<li class="dropdown-item"><a href="">Hồ sơ</a></li>');
                }
            ?>
        </ul>
    </div>
</menu>
<script>
    const btnOpen = document.getElementById("button-open");
    const btnClose = document.getElementById("button-close");
    const menu = document.getElementById("menu");
    btnOpen.onclick = function() {
        btnOpen.classList.remove("open");
        btnOpen.classList.add("close");
        menu.classList.remove("close");
        menu.classList.add("open");
    }
    btnClose.onclick = function() {
        menu.classList.remove("open");
        menu.classList.add("close");
        btnOpen.classList.remove("close");
        btnOpen.classList.add("open");
    }
</script>
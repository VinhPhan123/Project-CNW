<link rel="stylesheet" href="./assets/css/menu.css">
<div class="button-open" id="button-open">
    <div class="button-block">
        <div class="button-line"></div>
        <div class="button-line"></div>
        <div class="button-line"></div>
    </div>
</div>
<menu id="menu">
    <div class="menu" id="menu_item">
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
                    echo('<li class="dropdown-item"><a href="">Duyệt hồ sơ</a></li>');
                } else {
                    echo("<p>GIÀNH CHO STUDENT</p>");
                    echo('<li class="dropdown-item"><a href="">Học bạ</a></li>');
                    echo('<li class="dropdown-item"><a href="">Các ngành xét tuyển</a></li>');
                }
            ?>
        </ul>
    </div>
</menu>

<script>
    const btnOpen = document.getElementById("button-open");
    const btnClose = document.getElementById("button-close");
    const menu = document.getElementById("menu");
    const menu_item = document.getElementById("menu_item");
    console.log(btnOpen.style)
    btnOpen.onclick = function() {
        if(btnOpen.classList.contains("open")) {
            btnOpen.classList.remove("open");
        }
        if(!btnOpen.classList.contains("close")) {
            btnOpen.classList.add("close");
        }
        if(menu.classList.contains("close")) {
            menu.classList.remove("close");
        }
        if(!menu.classList.contains("open")) {
            menu.classList.add("open");
        }
        if(menu_item.classList.contains("close")) {
            menu_item.classList.remove("close");
        }
        if(!menu_item.classList.contains("open")) {
            menu_item.classList.add("open");
        }
    }
    btnClose.onclick = function() {
        if(menu.classList.contains("open")) {
            menu.classList.remove("open");
        }
        if(!menu.classList.contains("close")) {
            menu.classList.add("close");
        }
        if(menu_item.classList.contains("open")) {
            menu_item.classList.remove("open");
        }
        if(!menu_item.classList.contains("close")) {
            menu_item.classList.add("close");
        }
        if(btnOpen.classList.contains("close")) {
            btnOpen.classList.remove("close");
        }
        if(!btnOpen.classList.contains("open")) {
            btnOpen.classList.add("open");
        }
    }
</script>
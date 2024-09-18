
<select name="sel" id="sel">
    <option value=""></option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
</select>

<script>
    var sel = document.getElementById("sel");

    sel.addEventListener('change', function() {
        var val = this.value;
        // console.log(val);

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "test2_ajax_action.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function(){
            console.log(this.responseText);
        }      
        // Gửi dữ liệu với tên 'val'
        xhr.send("val=" + encodeURIComponent(val));
    });
</script>

<?php

?>
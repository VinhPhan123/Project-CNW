<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        body {
            cursor: url('assets/img/star.jpg'), auto;
        }
    </style>
</head>
<body>
    
<h1>h</h1>

</body>
</html>

<?php echo md5(12345);?>

<?php
    function generateRandomString() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        $maxIndex = strlen($characters) - 1;

        for ($i = 0; $i < 25; $i++) {
            $randomString .= $characters[random_int(0, $maxIndex)];
        }

        return $randomString;
    }

    $randomString = generateRandomString(); // Tạo chuỗi ngẫu nhiên gồm 25 kí tự

    echo '<br><a class="btn btn-primary" style="white-space: nowrap;" href="'?><?php echo 'admin.php">'?> ADMIN <?php echo '</a>'?><?php
?>

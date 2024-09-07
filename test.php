<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

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
    // echo $randomString;
?>

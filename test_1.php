<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload and Preview Image</title>
    <style>
        #preview {
            max-width: 100%;
            height: auto;
            display: none; /* Ảnh sẽ không hiển thị cho đến khi có ảnh được chọn */
        }
    </style>
</head>
<body>
    <h1>Upload and Preview Image</h1>
    <input type="file" id="fileInput" accept="image/*">
    <img id="preview" alt="Image Preview">
    
    <script>
        document.getElementById('fileInput').addEventListener('change', function(event) {
            const file = event.target.files[0]; // Lấy tệp ảnh đầu tiên từ danh sách tệp đã chọn
            
            if (file) {
                const reader = new FileReader(); // Tạo đối tượng FileReader
                
                reader.onload = function(e) {
                    const img = document.getElementById('preview');
                    img.src = e.target.result; // Đặt thuộc tính src của ảnh thành dữ liệu ảnh đã đọc
                    img.style.display = 'block'; // Hiển thị ảnh
                };
                
                reader.readAsDataURL(file); // Đọc tệp ảnh dưới dạng URL dữ liệu
            } else {
                // Nếu không có ảnh nào được chọn, ẩn ảnh xem trước
                document.getElementById('preview').style.display = 'none';
            }
        });
    </script>
</body>
</html>


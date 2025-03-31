<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Error'; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Slab&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/cdbcf8b89b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="resources/css/styles.css">
</head>
<body>
    <header class="header">
        <div class="nav"> 
            <ul>
                <li><a href="index.php">Logo</a></li>
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="#">Hãng xe <i class="fa-solid fa-angle-down"></i></a></li>
                <li><input style="width: 250px; height: 30px; border-radius: 10px; padding-left: 10px" type="text" placeholder="Tìm kiếm"></li>
                <li><a href="#">Dịch vụ</a></li>
                <li><a href="#">Liên hệ</a></li>
                <li><a href="about_us.php">Về chúng tôi</a></li>
                <li><a href="#">Đăng nhập / Đăng ký</a></li>
            </ul>
        </div>
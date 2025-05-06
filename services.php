<?php 
    $title = "Dịch Vụ";
    include 'header.php'; 
?>

<style>
    body {
        background: linear-gradient(to right, #eef2f3, #ffffff);
        font-family: 'Segoe UI', sans-serif;
        color: #222;
        margin: 0;
        padding: 0;
        background-image: url('original.mp4');
        
    }

    .main-content {
        max-width: 1000px;
        margin: 50px auto;
        padding: 50px;
        background-color: #ffffffd9;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .main-content h1 {
        font-size: 32px;
        font-weight: bold;
        color: #333;
    }

    .policy-section ul li {
        list-style: none;
        margin-bottom: 10px;
    }

    .main-content a {
        color: #0077cc;
        text-decoration: none;
    }

    .main-content a:hover {
        text-decoration: underline;
    }
    .bg-services {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        object-fit: cover;
        z-index: -1;
    }
</style>

<br><br>
<video class="bg-services" style="height: 100vh; width: 100%; object-fit: cover;" autoplay loop muted playsinline>
        <source src="resources/background-video/original.mp4" type="video/mp4">
        Trình duyệt không hỗ trợ Video.
    </video>
<div class="main-content">
    <h1>Dịch Vụ Của Chúng Tôi</h1>
    <br>
    <p>Chuyên cung cấp xe mới và xe đã qua sử dụng chất lượng cao.</p>
    <p>Dịch vụ bảo dưỡng, sửa chữa chuyên nghiệp và phụ tùng chính hãng.</p>
    <p>Đội ngũ nhân viên kỹ thuật nhiều năm kinh nghiệm, hỗ trợ tận tình 24/7.</p>
    <p>Chúng tôi cam kết mang đến cho bạn những trải nghiệm tốt nhất khi sử dụng dịch vụ của chúng tôi.</p>
    <p><a href="contact.php">Liên hệ với chúng tôi</a> để biết thêm thông tin chi tiết về các dịch vụ.</p>

    <br><br><br>

    <div class="policy-section">
        <h2>Chính Sách Của Chúng Tôi</h2>
        <br>
        <ul>
            <li><strong>Chính sách bảo mật:</strong> Bảo mật thông tin khách hàng tuyệt đối.</li>
            <li><strong>Điều khoản sử dụng:</strong> Sử dụng website đúng mục đích và tuân thủ quy định.</li>
            <li><strong>Chính sách bảo hành:</strong> Xe mới bảo hành 3 năm hoặc 100.000km, xe cũ bảo hành tùy tình trạng.</li>
            <li><strong>Chính sách đổi trả:</strong> Đổi trả trong 7 ngày nếu phát sinh lỗi kỹ thuật nghiêm trọng.</li>
        </ul>
    </div>
</div>

<?php include 'footer.php'; ?>

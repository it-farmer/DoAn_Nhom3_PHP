<?php
$title = "Lọc Xe Hơi";
include("header.php");
?>

<style>
    body {
        background-color: #000;
        color: #fff;
        font-family: Arial, sans-serif;
    }
    .container {
        max-width: 800px;
        margin: auto;
        padding: 20px;
        background-color: #222;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
    }
    h2 {
        text-align: center;
        color: #ff69b4;
    }
    .filter-option {
        margin: 10px 0;
    }
    .filter-option label {
        display: block;
        margin-bottom: 5px;
    }
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #333;
        color: #fff;
    }
    .btn {
        background-color: #ff69b4;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        width: 100%;
        margin-top: 15px;
    }
    .btn:hover {
        background-color: #ff1493;
    }
</style>

<div class="container">
    <h2>Lọc Xe Hơi</h2>
    <form method="POST" action="xulyLoc.php">
        <div class="filter-option">
            <label for="price">Lọc theo Giá:</label>
            <select name="price" id="price">
                <option value="">-- Chọn giá --</option>
                <option value="duoi_200">Dưới 200 triệu</option>
                <option value="200_500">200 - 500 triệu</option>
                <option value="500_1ty">500 triệu - 1 tỷ</option>
                <option value="1ty_3ty">1 tỷ - 3 tỷ</option>
                <option value="tren_3ty">Trên 3 tỷ</option>
            </select>
        </div>
        <div class="filter-option">
            <label for="color">Lọc theo Màu:</label>
            <select name="color" id="color">
                <option value="">-- Chọn màu --</option>
                <option value="den">Đen</option>
                <option value="trang">Trắng</option>
                <option value="bac">Bạc</option>
                <option value="xam">Xám</option>
                <option value="do">Đỏ</option>
                <option value="xanh">Xanh</option>
                <option value="vang">Vàng</option>
            </select>
        </div>
        <div class="filter-option">
            <label for="year">Lọc theo Năm Sản Xuất:</label>
            <select name="year" id="year">
                <option value="">-- Chọn năm --</option>
                <option value="duoi_2021">Dưới 2021</option>
                <option value="2022">Năm 2022</option>
                <option value="2023">Năm 2023</option>
            </select>
        </div>
        <div class="filter-option">
            <label for="speed">Lọc theo Tốc Độ:</label>
            <select name="speed" id="speed">
                <option value="">-- Chọn tốc độ --</option>
                <option value="duoi_250">Dưới 250 km/h</option>
                <option value="250_300">250 - 300 km/h</option>
                <option value="tren_300">Trên 300 km/h</option>
            </select>
        </div>
        <div class="filter-option">
            <label for="engine">Lọc theo Động Cơ:</label>
            <select name="engine" id="engine">
                <option value="">-- Chọn động cơ --</option>
                <option value="xang">Xăng</option>
                <option value="hybrid">Hybrid</option>
                <option value="khac">Khác</option>
            </select>
        </div>
        <div class="filter-option">
            <label for="transmission">Lọc theo Hộp Số:</label>
            <select name="transmission" id="transmission">
                <option value="">-- Chọn hộp số --</option>
                <option value="san">Sàn</option>
                <option value="tu_dong">Tự động</option>
                <option value="khac">Khác</option>
            </select>
        </div>
        <div class="filter-option">
            <label for="capacity">Lọc theo Dung Tích:</label>
            <select name="capacity" id="capacity">
                <option value="">-- Chọn dung tích --</option>
                <option value="duoi_2">Dưới 2L</option>
                <option value="2_4">Từ 2L đến 4L</option>
                <option value="tren_4">Trên 4L</option>
            </select>
        </div>
        <button type="submit" class="btn">Lọc Xe</button>
    </form>
</div>

<?php
include("footer.php");
?>
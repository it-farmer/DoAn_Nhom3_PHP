<?php
$title = "Thanh toán";
include("header.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $voucher = $_POST['voucher'] ?? '';
}
?>
<br><br>
<br>
<br>
<form class="checkout-form" method="post" action="process_checkout.php" onsubmit="return validateCheckout();">
    <h2>Thông tin giao hàng</h2>
    <input type="text" name="tenkh" placeholder="Họ tên người nhận" required>
    <input type="text" name="sdt" id="sdt" placeholder="Số điện thoại" required>
    <input type="text" name="diachi" placeholder="Địa chỉ giao hàng" required>
    <select name="pttt" id="pttt" required onchange="showBankImages()">
        <option value="">Chọn phương thức thanh toán</option>
        <option value="cod">Thanh toán khi nhận hàng</option>
        <option value="bank">Chuyển khoản ngân hàng</option>
    </select>
    <div id="bank-images" style="display:none; margin: 20px 0; text-align:center;">
        <img src="assets/img/anothers/mbbank.jpg" alt="MB Bank" style="height:200px; margin:0 10px;">
        <img src="assets/img/anothers/tpbank.jpg" alt="TP Bank" style="height:200px; margin:0 10px;">
        <img src="assets/img/anothers/techcombank.jpg" alt="Techcombank" style="height:200px; margin:0 10px;">
    </div>
    <input type="hidden" name="voucher" value="<?php echo htmlspecialchars($voucher); ?>">
    <button type="submit">Xác nhận đặt hàng</button>
</form>
<script>
function validateCheckout() {
    var sdt = document.getElementById('sdt').value.trim();
    if (sdt.length < 10 || sdt.length > 11) {
        alert('Số điện thoại phải từ 10 đến 11 số!');
        return false;
    }
    if (!/^\d+$/.test(sdt)) {
        alert('Số điện thoại chỉ được chứa số!');
        return false;
    }
    return true;
}

function showBankImages() {
    var pttt = document.getElementById('pttt').value;
    var bankDiv = document.getElementById('bank-images');
    if (pttt === 'bank') {
        bankDiv.style.display = 'block';
    } else {
        bankDiv.style.display = 'none';
    }
}
</script>
<?php include("footer.php"); ?>
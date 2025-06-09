<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Asia/Ho_Chi_Minh'); // Thiết lập múi giờ
require_once 'tcpdf/tcpdf.php'; // Điều chỉnh đường dẫn dựa trên nơi bạn đặt TCPDF
include('ConnectDatabase_PDO.php');

//Lấy dữ liệu
$sta = $pdo->prepare("SELECT * FROM xehoi ");
$sta->execute();
if ($sta->rowCount() > 0)
    $cars = $sta->fetchAll(PDO::FETCH_OBJ);

// Khởi tạo TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Thiết lập thông tin tài liệu
$pdf->SetCreator('Tình Trạng Tồn Kho');
$pdf->SetAuthor('Nhóm 3');
$pdf->SetTitle('Báo cáo Tình Trạng Tồn Kho');
$pdf->SetSubject('Báo cáo Tình Trạng Tồn Kho');

// Loại bỏ tiêu đề/chân trang mặc định
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(true);
$pdf->SetFooterFont(array('dejavusans', '', 10));
$pdf->SetFooterMargin(10);

// Thêm một trang
$pdf->AddPage();

// Thiết lập phông chữ (hỗ trợ ký tự tiếng Việt)
$pdf->SetFont('dejavusans', 'B', 16);

// Thêm logo
$logoPath = 'assets/img/icons/Logo_HUIT.png'; // Đường dẫn tới logo
if (file_exists($logoPath)) {
    $pdf->Image($logoPath, 8, 8, 20, 20, 'JPG', '', '', true, 300, '', false, false, 0, false, false, false);
}

// Thêm tiêu đề và căn giữa
$pdf->SetXY(8, 14); // Đặt vị trí bắt đầu
$pdf->Cell(0, 10, 'Trường Đại Học Công Thương', 0, 1, 'C', false, '', 0, false, 'T', 'M');


// Di chuyển xuống một khoảng để bắt đầu bảng
$pdf->Ln(15);

// Tạo nội dung HTML cho bảng
$html = '
<h2 style="text-align: center">Báo Cáo Tình Trạng Tồn Kho</h2>
<table style="font-weight: normal; font-size: 13px" border="1" cellpadding="5">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Mã Xe</th>
            <th>Mã Hãng Xe</th>
            <th>Tên Xe</th>
            <th>Màu Xe</th>
            <th>Giá</th>
            <th>Số Lượng Tồn Kho</th>
        </tr>
    </thead>
    <tbody>';
foreach ($cars as $car) {
    $html .= '
        <tr>
            <td>'.$car->MaXe.'</td>
            <td>'.$car->MaHX.'</td>
            <td>'.$car->TenXe.'</td>
            <td>'.$car->MauXe.'</td>
            <td>'.$car->Gia.'</td>
            <td>'.$car->SoLuongTonKho.'</td>
        </tr>';
}

$html .= '
    </tbody>
</table>';

// Ghi nội dung HTML vào PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Xuất PDF để tải xuống
$filename = 'Bao_Cao_Thiet_Bi_' . date('Ymd_His') . '.pdf';
$pdf->Output($filename, 'D');
exit();
?>
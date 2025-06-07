<?php
    include("../ConnectDatabase_PDO.php");

    try {
        for($i = 1; $i <= 76; $i++) {
            if($i < 10) {
                $maxe = "XE0".$i;
                $i = "0".$i;
            } else {
                $maxe = "XE".$i;
            }

            $randomNumber = mt_rand(1, 4);
            // Lấy tên xe
            $sta = $pdo->prepare("SELECT * FROM xehoi WHERE MaXe = ?");
            $sta->execute([$maxe]);

            if($sta->rowCount() > 0) {
                $row = $sta->fetch(PDO::FETCH_OBJ);
                $tenxe = $row->TenXe;
            } else {
                $tenxe = "Error";
                echo "<script>alert('Không tìm thấy mã Ô Tô này!');</script>";
            }

            //lấy hình ảnh phụ xe
            $sta = $pdo->prepare("SELECT TenHinh FROM hinhanhxe WHERE MaXe = ?");
            $sta->execute([$maxe]);

            if($sta->rowCount() > 0) {
                $hinhanhphu_list = $sta->fetchAll(PDO::FETCH_COLUMN, 0);
            } else {
                $hinhanhphu_list = [];
                echo "<script>alert('Không tìm hình ảnh phụ của mã Ô Tô này!');</script>";
            }

            // insert mô tả
            $sta = $pdo->prepare("UPDATE XeHoi SET MoTa = ?, ThoiGianBaoHanh = ? WHERE MaXe = ?");
            if($randomNumber == 1) {
                $sta->execute([
                    "<h2>". $tenxe ." : Cập Nhật Mới Nhất Về Giá Xe Và Chương Trình Khuyến Mãi</h2>
<p><strong>". $tenxe ."</strong> là phiên bản All New mới ra mắt của phân khúc C-Class tại thị trường Việt Nam. Mec C200 bứt phá về công nghệ thay đổi hoàn toàn từ bên ngoài ngoại thất, bên trong nội thất lẫn động cơ và an toàn</p>

<p><strong>". $tenxe ."</strong> hướng đến khách hàng trẻ tuổi, doanh nhân thành đạt và những người yêu thích công nghệ ". $tenxe ." đáp ứng nhu cầu này với thiết kế tinh tế và nội thất cao cấp thể hiện đẳng cấp, sang trọng và đẳng cấp.</p>
<img src='assets/img/Xe/".$row->AnhXe."' alt='". $tenxe ."'>
<ul>Ngoại thất: <li>Trắng Polar (149)</li> <li>Đen Obsidian (197)</li> <li>Xanh Cavansite (890)</li> <li>Đỏ Hyacinth (996)</li> <li>Xám Graphite (831)</li></ul>
<ul>Nội thất Da Artico: <li>Đen (101)</li>  <liNâu Sienna (104)</li> </ul>
<h3>Ngoại thất</h3>
<h4>1. Kiểu dáng & thiết kế</h4>
<ul>
<li>". $tenxe ." trang bị gói thiết kế ngoại thất AVANTGARDE là sự lựa chọn hoàn hảo cho những ai đam mê vẻ đẹp thể thao và sang trọng. Chính điều này giúp C200 sở hữu vẻ ngoài sang trọng và cuốn hút</li>
<li>". $tenxe ." sở hữu diện mạo sang trọng và cuốn hút</li>
</ul>
<h4>2. Đầu xe</h4>
<ul>
<li>". $tenxe ." hoàn toàn mới sở hữu diện mạo sang trọng, trẻ trung, cuốn hút với những đường nét thiết kế đậm chất thẩm mỹ. Cùng với đó là bạt ngàn công nghệ thông minh và khả năng vận hành ấn tượng, khiến nó trở thành chiếc sedan hạng sang cỡ nhỏ đáng khao khát hơn bao giờ hết.</li>
<li>". $tenxe ." sở hữu diện mạo sang trọng và cuốn hút</li>
</ul>
<div class='hinh_phu'>
    <img src='assets/img/Xe/".$hinhanhphu_list[0]."' alt='". $tenxe ."'>
    <img src='assets/img/Xe/".$hinhanhphu_list[1]."' alt='". $tenxe ."'>
</div>
<p>Lưới tản nhiệt thiết kế mới hoàn toàn gồm 31 thanh dọc sơn đen nhỏ với phong cách thể thao (AMG), phần viền crom mảnh hơn kéo dài tạo điểm nhấn cho phần logo sao ba cánh đặc trưng thương hiệu. Tạo hình này được đánh giá là sang trọng, thể thao, khỏe khoắn và thời thượng.</p>
<p>Vẻ sang trọng, thời thượng mang tính cấp tiến trên ". $tenxe ." C 200 Avantgarde Plus thế hệ mới thể hiện rõ ngay khu vực đầu xe với sự xuất hiện của các đường gân trang trí phía trên nắp ca-pô.</p>

<h3>Nội thất</h3>
<h4>1. Không gian nội thất</h4>
<ul>
<li>Không gian nội thất ". $tenxe ." là một hình thái mới của sự sang trọng. Ở đó, người dùng đang thực sự bước vào một không gian tràn ngập kỹ thuật số với những trải nghiệm mang tính tương lai.</li>
<li>". $tenxe ." ghế bọc da Artico với 2 màu nọi thất Đen (101) và Nâu Sienna (104) giúp khách hàng đang quan tâm xe sẽ nhanh chóng ra quyết định hơn.</li>
</ul>
<img src='assets/img/Xe/".$hinhanhphu_list[2]."' alt='". $tenxe ."'>
<h4>2. Vị trí hàng ghế thứ 1</h4>
<ul>
<li>Điển hình cho tính tương lai này chính là bảng đồng hồ kỹ thuật số hiện đại, thiết kế độc lập hoàn toàn màn hình giải trí trung tâm. Kích thước bảng đồng hồ cũng gia tăng, lên tới 12,3 inch với độ phân giải tối đa đạt 2400 x 900 pixels, hiển thị hình ảnh sắc nét, giúp gia tăng tính tiện nghi và dễ dàng cho người lái trong việc điều khiển xe.</li>
<li>". $tenxe ." trang bị Vô lăng 3 chấu bọc da thiết kế thể thao</li>
<li>Tiếp đến là màn hình cảm ứng trung tâm 11,9 inch tích hợp MBUX (". $tenxe ." User Experience) thế hệ thứ hai, Apple CarPlay, Android Auto, đáp ứng tốt mọi nhu cầu giải trí thông qua vài thao tác chạm nhẹ.</li>
</ul>
<img src='assets/img/Xe/".$hinhanhphu_list[3]."' alt='". $tenxe ."'>
<h4>3. Không gian hàng ghế thứ 2</h4>
Nhờ kích thước và trục cơ sở dài gia tăng nên không gian bên trong cũng thoáng rộng hơn hẳn. Đặc biệt là hàng ghế thứ 2 khi có thêm 2cm khoảng để chân, khoảng sáng đầu tăng 13 mm, không gian khuỷu tay và vai người ngồi sau cũng tăng 2-2,5 cm. Những thay đổi này giúp mỗi hành trình di chuyển trên xe thêm phần thư thái, hứng khởi.

<h3>1. Động cơ & Hiệu suất</h3>
Tính thông minh và tiện lợi trên xe thế hệ mới còn được thể hiện thông qua hệ thống hỗ trợ lái tiên tiến. Các hệ thống hỗ trợ có thể ứng phó với những va chạm sắp xảy ra tùy theo yêu cầu của tình huống, giúp tài xế thêm phần yên tâm, thoải mái và an toàn hơn trên mỗi cung đường lăn bánh xe.

<h3>2. Công nghệ động cơ</h3>
Sử dụng động cơ loại 4 xy-lanh, dung tích 1,5 lít tăng áp kết hợp mô-tơ điện Mild-Hybrid cho công suất cực đại lên tới 204 hp và Mô-men xoắn cực đại 300 Nm, trước khi đạt tốc độ tối đa 246 (km/h) nhờ hộp số tự động 9 cấp 9G-TRONIC.


<h3>3. Khả năng vận hành</h3>
Khả năng vận hành C200 Plus được đánh giá khá cao trong tầm giá Mercedes 5 chỗ dưới 2 tỷ , nhờ trang bị công nghệ bên dưới:

<h3>Tổng kết</h3>
Giá xe ". $tenxe ." đang khá cạnh tranh so với các đối thủ như Lexus IS, Audi A4, Volvo S60 hay hãng 3-Series trong khi xe sở hữu vẻ ngoài đậm chất thẩm mỹ cùng thay đổi mạnh mẽ về thiết kế, tiện nghi, khả năng vận hành. Đây chính là lý do khiến C-Class luôn trở thành lựa chọn hàng đầu của “những người có điều kiện” tại Việt Nam.",
                    "3 năm",
                    "XE".$i
                ]);
            }
            else if($randomNumber == 2) {
                $sta->execute([
                    "<h2>NGOẠI THẤT NỔI BẬT CỦA ". $tenxe ." MỚI</h2>
<h3>Thiết kế đầu xe</h3>
Thiết kế đầu xe đặc trưng của hãng với lưới tản nhiệt quả thận cỡ lớn kết hợp đèn định vị pha lê hãng ‘Iconic Glow’ được tạo nên từ chất liệu pha lê Swarovski sang trọng.
<img src='assets/img/Xe/".$hinhanhphu_list[0]."' alt='". $tenxe ."'>
<h3>Thiết kế thân xe</h3>
Thiết kế thân xe của ". $tenxe ." nổi bật với đường nét mượt mà và tinh tế. Đường viền cửa sổ mạ chrome, tay nắm cửa ẩn, và gương chiếu hậu hiện đại tạo nên vẻ đẹp thanh lịch và thượng lưu. Mọi chi tiết đều được tinh chỉnh hài hòa và tỉ mỉ mang lại cảm giác sang trọng và uyển chuyển, làm tăng thêm sự cuốn hút cho xe.
<h3>Thiết kế đuôi xe.</h3>
Với đèn hậu LED sắc nét, cản sau nhấn mạnh vào chiều rộng của đuôi xe tạo nên tỷ lệ tổng thể hoàn hảo cùng phong cách sang trọng đặc trưng của hãng. Đường viền chrome và logo hãng nổi bật làm tăng thêm vẻ cuốn hút và hiện đại cho mẫu xe hạng sang này.
​<img src='assets/img/Xe/".$hinhanhphu_list[1]."' alt='". $tenxe ."'>
<h2>NỘI THẤT TOÀN DIỆN CỦA ". $tenxe ." MỚI</h2>
<ul>
<li>Không gian nội thất hiện đại.</li>
<li>Thanh điều khiển đa chức năng hãng Interaction Bar kéo dài ngang qua toàn bộ buồng lái, tạo nên điểm nhấn cao cấp và xa hoa cho khu vực bảng điều khiển. Hoàn thiện trải nghiệm đỉnh cao ở khoang lái là cụm màn hình cong hãng Curved Display, mang đến sự kết hợp hoàn hảo giữa công nghệ tiên tiến và thiết kế sang trọng.</li>
<li>Cửa sổ trời toàn cảnh Panorama Sky Lounge.</li>
<li>Cửa sổ trời Panorama Sky Lounge mang ánh sáng tự nhiên vào không gian nội thất của xe. Vào ban đêm, hệ thống ánh sáng cho hiệu ứng sống động, mang lại trải nghiệm sang trọng và tinh tế.</li>
</ul>
<h2>". $tenxe ." – MẪU XE CỦA SỰ BỨT PHÁ MỌI GIỚI HẠN.</h2>
Những thiết kế nổi bật của mẫu xe ". $tenxe .":
<ul>
<li>Đường nét liền mạch và thiết kế thân xe nguyên khối kết hợp cùng đèn chào mừng Welcome Light.</li>
<li>Các chi tiết mạ chrome cao cấp kết hợp với đèn hậu tối giản ở đuôi xe.</li>
<li>Thiết kế đèn viền trang trí nội thất mới kết hợp cùng thanh điều khiển cảm ứng hãng Interaction Bar đầy cá tính.</li>
<li>Bảng điều khiển trung tâm thiết kế mới với núm xoay iDrive và lẫy chuyển số khảm pha lê Swarovski sang trọng.</li>
<li>Bệ tỳ tay bọc da hãng Individual Merino cao cấp cùng hệ thống điều hòa tự động hàng ghế sau.</li>
<li>Bảng điều khiển trung tâm thiết kế mới với núm xoay iDrive và lẫy chuyển số khảm pha lê Swarovski sang trọng.</li>
<li>Bệ tỳ tay bọc da hãng Individual Merino cao cấp cùng hệ thống điều hòa tự động hàng ghế sau.". $tenxe .".</li>
</ul>
<div class='hinh_phu'>
    <img src='assets/img/Xe/".$hinhanhphu_list[2]."' alt='". $tenxe ."'>
    <img src='assets/img/Xe/".$hinhanhphu_list[3]."' alt='". $tenxe ."'>
</div>
<h2>THÔNG SỐ KỸ THUẬT CỦA ". $tenxe ."</h2>
Phiên bản: hãng 735i M Sport.
<br>
Công suất động cơ kW (hp) tại vòng/ phút: 210 (286) tại 5000-6500.
<br>
Thời gian tăng tốc từ 0-100km/h (s): 6.7.
<br>
Lượng nhiên liệu tiêu thụ kết hợp (l/100km): 10.6-9.6.
<br>
Lượng khí thải CO2 kết hợp (g/km): 240-217.",
                    "4 năm",
                    "XE".$i
                ]);
            }
            else if($randomNumber == 3) {
                $sta->execute([
                    "<h2>Mẫu xe thể thao trong phân khúc saloon sang trọng </h2>
<p><strong>". $tenxe ."</strong> mới hòa hợp hai đặc điểm tương phản hơn bao giờ hết: vừa cung cấp hiệu suất vượt trội của một mẫu xe thể thao, vừa mang lại sự thoải mái của một chiếc saloon sang trọng. Đây là một mẫu xe Gran Turismo được cách tân và tái định hình. Thế hệ thứ hai của dòng xe ". $tenxe ." đang vươn lên trở thành một biểu tượng hiệu suất mạnh mẽ cho dòng xe sang. Trong lần đổi mới này, ". $tenxe ." đã cải tiến mẫu xe ý tưởng ". $tenxe ." một cách hệ thống – với một mẫu xe bốn cửa đã được tái phát triển và thiết kế toàn diện. Động cơ và bộ truyền động của mẫu xe này đã được thiết kế lại, khung gầm được hoàn thiện, ý tưởng hiển thị và điều khiển lấy cảm hứng từ tương lai. Mẫu ". $tenxe ." đồng thời cũng mở rộng ranh giới giữa thế giới xe thể thao đầy tham vọng và thế giới tiện nghi của xe sang với các tính năng như đánh lái trục sau, kiểm soát độ lắc chủ động và hệ thống treo khí nén ba buồng.</p>
<br><br>
<p>Ngôn ngữ thiết kế 911 kết hợp với đường cắt mui xe năng động hơn. Một cách trực quan, ý tưởng độc nhất của dòng xe ". $tenxe ." cỡ lớn này là sự tương phản của một thiết kế đầy biểu cảm mới: một chiếc ". $tenxe ." và một chiếc xe thể thao không thể nhầm lẫn – với hình dáng dài và nhanh nhẹn, đường gân dọc thân xe sắc cạnh, hông xe thể thao và đường cắt mui xe cực dốc đến mức thấp hơn 20 mm tại đuôi xe. Đường cắt mui xe điển hình của ". $tenxe ." tạo sự liên tưởng đến biểu tượng thiết kế của ". $tenxe .", huyền thoại 911. Nhiều tính năng và tương tác dễ dàng trong Buồng lái Tiên tiến của ". $tenxe ."</p>

<h3>Thiết kế nội thất điển hình của ". $tenxe ."</h3> 
<p>Được diễn giải theo xu hướng tương lai trong mẫu ". $tenxe ." mới. Bề mặt táp lô màu đen với màn hình hiển thị cảm ứng kết hợp giao diện người dùng rõ ràng và trực quan như trên điện thoại và máy tính bảng với những điều kiện cần thiết trong việc kiểm soát chiếc xe. Các nút bấm và cụm điều khiển thông thường được giảm đáng kể. Các chi tiết này được thay thế bởi bảng điều khiển cảm ứng và những màn hình tùy biến cá nhân nằm ngay giữa Buồng lái Tiên tiến của ". $tenxe ." – mang lại nhiều lợi ích cho người lái cũng như hành khách phía trước và phía sau. Dù được mở rộng một cách đáng kể, các chức năng liên lạc, tiện ích và hệ thống hỗ trợ giờ đây có thể được sử dụng và điều khiển một cách rõ ràng và trực quan hơn. Buồng lái Tiên tiến của ". $tenxe ." biến thế giới của những nút bấm trở thành kỹ thuật điện tử hiện đại của tính di động, dành nhiều chỗ hơn cho sự đam mê. Đồng hồ vòng tua, được đặt ngay giữa cụm đồng hồ, là một dụng cụ gợi nhắc đến chiếc ". $tenxe ." 356 A đời 1955.</p>
<div class='hinh_phu'>
    <img src='assets/img/Xe/".$hinhanhphu_list[2]."' alt='". $tenxe ."'>
    <img src='assets/img/Xe/".$hinhanhphu_list[3]."' alt='". $tenxe ."'>
</div>
<p>Một chiếc ". $tenxe ." luôn gây ấn tượng không chỉ về sức mạnh mà hiệu suất vận hành cũng quan trọng không kém. Nhằm đẩy công thức này lên một tầm cao mới, tất cả động cơ của mẫu xe ". $tenxe ." thế hệ thứ hai đã được tái thiết kế. Các động cơ này được tạo ra không chỉ với công suất lớn hơn mà còn cải thiện đáng kể mức tiêu thụ nhiên liệu và lượng khí thải. Ba loại động cơ phun nhiên liệu trực tiếp tăng áp kép được giới thiệu trong buổi ra mắt thị trường: thuộc các phiên bản ". $tenxe ." Turbo, ". $tenxe ." 4S và ". $tenxe ." 4S Diesel. Tất cả các động cơ này – và lần đầu tiên bao gồm cả động cơ diesel – đều có thể được trang bị với hệ thống dẫn động bốn bánh toàn thời gian và hộp số ly hợp kép tám cấp mới của ". $tenxe ." (PDK). Động cơ xăng V8 cung cấp 404 kW (550 mã lực) cho ". $tenxe ." Turbo và động cơ xăng V6 truyền 324 kW (440 mã lực) cho ". $tenxe ." 4S. Phiên bản ". $tenxe ." 4S Diesel sở hữu động cơ V8 với 310 kW (422 mã lực) cho công suất mạnh mẽ và mô men xoắn cực đại đạt 850 Nm.</p>

<h3>Thiết kế bên ngoài của ". $tenxe ."</h3> 
<p>Được gọt giũa thể hiện đường nét tinh tế của thế hệ thứ hai. Những chi tiết này đều dựa theo các tỷ lệ thiết kế làm tăng tính năng động của mẫu xe thế hệ mới. Kích thước của ". $tenxe ." mới với chiều dài 5.049 mm (tăng 34 mm), chiều rộng 1.937 mm (tăng 6 mm) và chiều cao 1.423 mm (tăng 5 mm). Mặc dù có sự tăng nhẹ về chiều cao, nhưng mẫu xe bốn cửa trông thấp và dài hơn nhiều. Điều này chủ yếu là do chiều cao giảm ở phía sau khoang hành khách – giảm 20 mm – trong khi vẫn giữ được khoảng không gian bên trong. Điều này làm thay đổi hoàn toàn hình ảnh tổng thể của mẫu xe. Chiều dài cơ sở được tăng lên 30 mm tương đương 2.950 mm; kéo dài tỷ lệ thiết kế của chiếc xe. Các bánh xe trước được thiết kế dịch về phía trước, làm giảm chiều dài ở phía trên đầu xe và làm cho kích thước trở nên hoàn hảo hơn – khoảng cách giữa trụ A và trục trước trở nên lớn hơn. Phía sau lại có cảm giác dài hơn tạo cho chiếc xe một vẻ ngoài mạnh mẽ hơn bao giờ hết.</p>
<div class='hinh_phu'>
    <img src='assets/img/Xe/".$hinhanhphu_list[0]."' alt='". $tenxe ."'>
    <img src='assets/img/Xe/".$hinhanhphu_list[1]."' alt='". $tenxe ."'>
</div>
<h3>Tổng kết</h3>
Giá xe ". $tenxe ." đang khá cạnh tranh so với các đối thủ như Lexus IS, Audi A4, Volvo S60 hay hãng 3-Series trong khi xe sở hữu vẻ ngoài đậm chất thẩm mỹ cùng thay đổi mạnh mẽ về thiết kế, tiện nghi, khả năng vận hành. Đây chính là lý do khiến C-Class luôn trở thành lựa chọn hàng đầu của “những người có điều kiện” tại Việt Nam.",

                    "2 năm",
                    "XE".$i
                ]);
            }
            else {
                $sta->execute([
                    "<h2>Chi tiết ". $tenxe .": Siêu xe độc nhất thế giới</h2>
<p>Chỉ có một chiếc duy nhất được sản xuất trên toàn cầu, <strong>". $tenxe ."</strong> trở thành siêu xe độc nhất thế giới. Không chỉ là một trong những siêu xe hiếm nhất, ". $tenxe ." còn là mẫu xe sở hữu thiết kế hoàn hảo, vận hành siêu mạnh và tất nhiên là siêu đắt với giá bán gần 3 triệu USD.</p>

". $tenxe ." được ra mắt lần đầu tại triển lãm Geneva Motor Show 2012, gây ấn tượng mạnh với giới chuyên môn và những người chơi xe. Tuy nhiên, không phải lúc nào siêu xe này cũng xuất hiện trên đường phố. Ước tính số lần nó “lộ diện” có thể đếm trên đầu ngón tay, khiến người hâm mộ luôn tò mò về siêu xe độc nhất. Dưới đây là bài viết đánh giá chi tiết về ". $tenxe .". 

<h3>1. Thông số kỹ thuật</h3>
THÔNG SỐ ĐỘNG CƠ/HỘP SỐ ". $tenxe ."
<br>
<ul style='margin-bottom: 1%;'>
<li>Động cơ	V12 6.5 L L539, hút khí tự nhiên</li>
<li>Hộp số Hộp số bán tự động 7 cấp ISR</li>
<li>Công suất cực đại 700 mã lực</li>
<li>Mô men xoắn tối đa 690 Nm</li>
<li>Tăng tốc từ 0-100 km/h 2,9 giây</li>
<li>Tốc độ tối đa 350 km/h</li>
<li>Lượng khí thải CO2	398 g/km</li>
<li>Mức tiêu thụ nhiên liệu kết hợp	17.9L/100km</li>
</ul>
THÔNG SỐ KÍCH THƯỚC/TRỌNG LƯỢNG ". $tenxe ."
<br>
<ul>
<li>Kích thước Dài x Rộng x Cao	4.890 mm x 2.030 mm x 1.110 mm</li>
<li>Chiều dài cơ sở	2.700 mm</li>
<li>Trọng lượng	1.575 kg</li>
<li>La-zăng	Trước 20 inch / Sau 21 inch</li>
</ul>
<h3>2. Thiết kế ngoại thất</h3>
<p><strong>". $tenxe ."</strong> là sản phẩm của sự sáng tạo toàn diện từ đội ngũ thiết kế của ". $tenxe ." khi không cần một bản thiết kế concept trước. Quá trình hoàn thiện chỉ mất sáu tuần để biến nó thành siêu xe thể thao độc nhất trên thế giới.</p>

<p><strong>". $tenxe ."</strong> là một chiếc speedster không mui và không kính chắn gió. Siêu xe này giữ nguyên kiểu dáng của ". $tenxe ." coupe với chỉ nắp ca pô, chắn bùn trước/sau và hệ thống đèn pha. Tất cả các chi tiết khác trên thân xe như hệ thống khuếch tán phía trước, bên sườn, phía sau và ống xả đều được tái thiết kế.</p>

<h4>Phần đầu xe</h4> 
Gây ấn tượng với cụm đèn pha hình kim cương sắc nét và dải đèn LED hiện đại. Hệ thống khuếch tán gió rộng lớn được lấy cảm hứng từ xe đua Công thức 1, được thiết kế để tạo luồng khí xuống mui xe. Kính chắn gió thấp của xe không chỉ giúp giảm tác động của gió trực tiếp lên người lái và hành khách, mà còn tăng cường hiệu suất của hệ thống.
<br><br>
Gương chiếu hậu độc đáo được tích hợp ngay trên khu vực nắp capo, giống như những chiếc kính tiềm vọng, là một điểm nhấn thú vị khác của chiếc xe.
<img src='assets/img/Xe/".$hinhanhphu_list[0]."' alt='". $tenxe ."'>
<h4>Phần đuôi xe</h4>
Thể hiện sự táo bạo và cá tính của <strong>". $tenxe ."</strong> với cụm đèn hậu hình xương cá, cản sau gồ ghề, hầm hố và các cánh lướt làm từ carbon sang trọng. Hệ thống ống xả cũng đã trải qua sự sửa đổi, với khoang động cơ phía sau thay thế bằng một tấm khung bằng sợi carbon đẹp mắt và tinh tế hơn.
<img src='assets/img/Xe/".$hinhanhphu_list[1]."' alt='". $tenxe ."'>
<h3>3. Thiết kế nội thất</h3>
<p>Nội thất của <strong>". $tenxe ."</strong> không chỉ thể hiện đẳng cấp mà còn vô cùng tinh tế với nhiều chi tiết cao cấp và sang trọng. Khu vực lái xe được thiết kế theo phong cách xe đua, với vô lăng 3 chấu có hình dạng độc đáo, đi kèm nhiều công tắc điều khiển hiện đại và tiện ích. Bố trí taplo được thực hiện hợp lý, liền mạch với tựa đầu để tay, giúp người lái có thể vận hành xe một cách dễ dàng và linh hoạt.</p>
<br><br>
<p>Ghế ngồi của <strong>". $tenxe ."</strong> được thiết kế bọc da alcantara cao cấp, mang đến cho chủ nhân sự thoải mái và an toàn. Thiết kế ôm sát không chỉ giữ cho người ngồi ổn định khi xe chuyển động mà còn tạo ra sự thoải mái. Đặc biệt, ghế còn có khả năng điều chỉnh góc nghiêng linh hoạt theo mong muốn của người lái, tạo ra một không gian nội thất đa dạng và hiện đại. Sự kết hợp này càng làm nổi bật phong cách thể thao độc đáo của ". $tenxe ." trong không gian nội thất.</p>
<div class='hinh_phu'>
    <img src='assets/img/Xe/".$hinhanhphu_list[2]."' alt='". $tenxe ."'>
    <img src='assets/img/Xe/".$hinhanhphu_list[3]."' alt='". $tenxe ."'>
</div>

<h3>4. Giá bán tham khảo</h3>
<strong>". $tenxe ."</strong> được bán với giá gần 3 triệu USD.
<br><br>
<strong>Fun fact:</strong> ". $tenxe ." “độc nhất vô nhị” khi được sản xuất duy nhất một chiếc và được bán với giá gần 3 triệu USD cho một nhà sưu tập xe kín tiếng. Theo nhiều nguồn tin, trong Garage của nhà sưu tập này còn đang sỡ hữu những tên tuổi đình đám nhất, có thể kể đến như ". $tenxe ." Reventon, Bugatti Veyron, Aston Martin One-77, ". $tenxe ." Reventon,…",
                    "5 năm",
                    "XE".$i
                ]);
            }
        }
    }
    catch (Exception $e) {
        echo "Lỗi: ". $e->getMessage() ."";
    }
?>
<?php
$xe1 = \App\Models\XeMay::find(1); // Honda Vision 2023
if($xe1) {
    $xe1->hinh_anh = 'https://muaban.net/blog/wp-content/uploads/2023/02/gia-xe-vision-2023.jpg';
    $xe1->save();
}

$xe2 = \App\Models\XeMay::find(2); // Honda AirBlade 150
if($xe2) {
    $xe2->hinh_anh = 'https://cdn.honda.com.vn/motorbikes/September2020/Wv1XwR2t3x8G8U8R9H7Z.jpg';
    $xe2->save();
}

$xe3 = \App\Models\XeMay::find(3); // Yamaha Exciter 155
if($xe3) {
    $xe3->hinh_anh = 'https://yamaha-motor.com.vn/wp/wp-content/uploads/2023/09/Exciter-155-VVA-Standard-Red.png';
    $xe3->save();
}

$xe4 = \App\Models\XeMay::find(4); // Honda Wave Alpha
if($xe4) {
    $xe4->hinh_anh = 'https://cdn.honda.com.vn/motorbikes/September2022/vK3k2x9L9a9K9w8L2t1Z.jpg';
    $xe4->save();
}

echo "Updated images successfully!\n";

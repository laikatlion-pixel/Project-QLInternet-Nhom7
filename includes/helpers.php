<?php

function tinhThoiGianChoi($balance, $price_per_hour) {
    if ($balance <= 0 || $price_per_hour <= 0) {
        return "0 phút";
    }

    // Tính tổng số phút khách chơi được (làm tròn xuống số phút nguyên)
    $total_minutes = floor(($balance / $price_per_hour) * 60);

    // Tách thành số giờ và số phút dư
    $hours = floor($total_minutes / 60);
    $minutes = $total_minutes % 60;

    // Trả về chuỗi kết quả thân thiện với người dùng
    if ($hours > 0) {
        return $hours . " giờ " . $minutes . " phút";
    }
    return $minutes . " phút";
}


function formatVND($amount) {
    return number_format($amount, 0, ',', '.') . ' đ';
}
?>

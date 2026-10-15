<?php
/**
 * File chứa các hàm tiện ích cho Hệ thống Quản lý Tiệm Net
 */

/**
 * Quy đổi số dư tài khoản ra thời gian chơi (Giờ & Phút) theo giá tiền khu vực
 * @param int $balance Số dư hiện tại của tài khoản (VNĐ)
 * @param int $price_per_hour Đơn giá 1 giờ chơi của máy/khu vực (VNĐ)
 * @return string Chuỗi định dạng thời gian (ví dụ: "1 giờ 20 phút" hoặc "40 phút")
 */
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

/**
 * Hàm định dạng tiền tệ VNĐ cho giao diện
 */
function formatVND($amount) {
    return number_format($amount, 0, ',', '.') . ' đ';
}
?>
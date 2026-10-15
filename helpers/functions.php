<?php
/**
 * Các hàm tiện ích dùng chung
 */

/**
 * Quy đổi số dư ra thời gian chơi (giờ & phút) theo đơn giá giờ
 */
function tinhThoiGianChoi($balance, $price_per_hour): string
{
    if ($balance <= 0 || $price_per_hour <= 0) {
        return "0 phút";
    }
    $total_minutes = floor(($balance / $price_per_hour) * 60);
    $hours   = floor($total_minutes / 60);
    $minutes = $total_minutes % 60;
    if ($hours > 0) {
        return $hours . " giờ " . $minutes . " phút";
    }
    return $minutes . " phút";
}

/**
 * Định dạng tiền tệ VNĐ
 */
function formatVND($amount): string
{
    return number_format((int)$amount, 0, ',', '.') . ' đ';
}

/**
 * Viết tắt htmlspecialchars
 */
function e($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

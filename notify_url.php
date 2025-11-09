<?php
/**
 * 支付异步通知处理
 */

// 加载支付API
require_once('lib/epayapi.php');

// 获取通知数据
$data = $_POST;

// 记录日志
file_put_contents('logs/notify_' . date('Ymd') . '.log', json_encode($data) . "\n", FILE_APPEND);

// 验证签名
if (epay_notify_verify($data)) {
    // 签名验证成功
    $out_trade_no = $data['out_trade_no']; // 订单号
    $trade_no = $data['trade_no']; // 支付平台订单号
    $type = $data['type']; // 支付方式
    $money = $data['money']; // 支付金额
    $status = $data['trade_status']; // 支付状态
    
    if ($status == 'TRADE_SUCCESS') {
        // 支付成功，处理订单
        // 这里需要根据实际业务逻辑进行处理，例如更新订单状态、记录交易信息等
        
        // 模拟订单处理
        $order_info = array(
            'out_trade_no' => $out_trade_no,
            'trade_no' => $trade_no,
            'type' => $type,
            'money' => $money,
            'status' => 'success',
            'pay_time' => date('Y-m-d H:i:s')
        );
        
        // 保存订单信息到文件（实际应用中应保存到数据库）
        file_put_contents('orders/' . $out_trade_no . '.txt', json_encode($order_info));
        
        // 记录处理日志
        file_put_contents('logs/order_' . date('Ymd') . '.log', "订单 " . $out_trade_no . " 支付成功，金额：" . $money . "\n", FILE_APPEND);
        
        // 输出成功响应，告诉支付平台已收到通知
        echo 'success';
    } else {
        // 支付失败
        file_put_contents('logs/error_' . date('Ymd') . '.log', "订单 " . $out_trade_no . " 支付失败，状态：" . $status . "\n", FILE_APPEND);
        echo 'fail';
    }
} else {
    // 签名验证失败
    file_put_contents('logs/error_' . date('Ymd') . '.log', "通知签名验证失败：" . json_encode($data) . "\n", FILE_APPEND);
    echo 'sign_error';
}
?>
<?php
/**
 * 支付同步返回处理
 */

// 加载支付API
require_once('lib/epayapi.php');

// 获取返回数据
$data = $_GET;

// 验证签名
if (epay_notify_verify($data)) {
    $out_trade_no = $data['out_trade_no']; // 订单号
    $trade_no = $data['trade_no']; // 支付平台订单号
    $type = $data['type']; // 支付方式
    $money = $data['money']; // 支付金额
    $status = $data['trade_status']; // 支付状态
    
    if ($status == 'TRADE_SUCCESS') {
        // 支付成功
        $message = "恭喜您，支付成功！\n订单号：{$out_trade_no}\n支付金额：¥{$money}\n支付方式：" . ($type == 'alipay' ? '支付宝' : ($type == 'wechat' ? '微信支付' : $type));
        $message .= "\n\n请联系客服获取微信群聊邀请码。";
        $success = true;
    } else {
        // 支付失败
        $message = "支付失败，请重试！\n订单号：{$out_trade_no}\n支付状态：{$status}";
        $success = false;
    }
} else {
    // 签名验证失败
    $message = "支付结果验证失败，请联系客服！";
    $success = false;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>支付结果</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>微信城市群聊会员</h1>
        </div>
        
        <div class="content">
            <div class="result-box <?php echo $success ? 'success' : 'error'; ?>">
                <h2><?php echo $success ? '支付成功' : '支付失败'; ?></h2>
                <p><?php echo nl2br($message); ?></p>
                
                <?php if ($success): ?>
                <div class="group-info">
                    <h3>加入微信群步骤：</h3>
                    <ol>
                        <li>保存下方客服微信二维码</li>
                        <li>添加客服微信</li>
                        <li>发送订单号：<?php echo $out_trade_no; ?></li>
                        <li>客服将邀请您加入相应城市的群聊</li>
                    </ol>
                </div>
                <?php endif; ?>
                
                <div class="actions">
                    <a href="index.php" class="btn">返回首页</a>
                    <?php if (!$success): ?>
                    <a href="pay.php?order_id=<?php echo $out_trade_no; ?>
" class="btn btn-primary">重新支付</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>&copy; 2024 微信城市群聊会员系统. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
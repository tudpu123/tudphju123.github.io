<?php
/**
 * 支付页面
 */

// 生成订单号
function generate_order_no() {
    return date('YmdHis') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}

// 检查是否有订单ID传入，如果没有则生成新的
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : generate_order_no();

// 获取城市信息
$city = isset($_POST['city']) ? $_POST['city'] : (isset($_GET['city']) ? $_GET['city'] : '全国');

// 获取金额信息
$amount = isset($_POST['amount']) ? $_POST['amount'] : (isset($_GET['amount']) ? $_GET['amount'] : '99.00');

// 处理支付请求
if (isset($_POST['submit'])) {
    $pay_type = $_POST['pay_type'];
    $subject = "{$city}微信群聊会员 - " . date('Y-m-d');
    $body = "加入{$city}微信群聊，获取本地最新资讯和资源";
    
    // 加载支付API
    require_once('lib/epayapi.php');
    
    // 发起支付
    echo epay_submit($pay_type, $order_id, $amount, $subject, $body);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>支付 - 微信城市群聊会员</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>微信城市群聊会员</h1>
            <p>加入我们的会员，获取本地最新资讯和优质资源</p>
        </div>
        
        <div class="content">
            <h2>支付订单</h2>
            
            <div class="pay-form">
                <form action="pay.php" method="post">
                    <input type="hidden" name="city" value="<?php echo $city; ?>">
                    <input type="hidden" name="amount" value="<?php echo $amount; ?>">
                    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                    
                    <div class="form-group">
                        <label for="order_id_display">订单号</label>
                        <input type="text" id="order_id_display" value="<?php echo $order_id; ?>" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="city_display">选择城市</label>
                        <input type="text" id="city_display" value="<?php echo $city; ?>" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="amount_display">支付金额</label>
                        <input type="text" id="amount_display" value="¥<?php echo $amount; ?>" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="pay_type">支付方式</label>
                        <select name="pay_type" id="pay_type" required>
                            <option value="alipay">支付宝</option>
                            <option value="wechat">微信支付</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <input type="submit" name="submit" value="立即支付" class="btn btn-primary">
                    </div>
                </form>
            </div>
            
            <div style="margin-top: 40px; text-align: center;">
                <a href="index.php" class="btn btn-secondary">返回首页</a>
            </div>
        </div>
        
        <div class="footer">
            <p>&copy; 2024 微信城市群聊会员系统. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
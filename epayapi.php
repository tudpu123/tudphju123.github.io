<?php
/**
 * 支付API接口文件
 */

// 加载配置文件
$alipay_config = require_once('epay.config.php');

// 加载核心类
require_once('EpayCore.class.php');

/**
 * 发起支付
 * @param string $pay_type 支付方式 (alipay, wechat, etc)
 * @param string $out_trade_no 订单号
 * @param float $total_fee 订单金额
 * @param string $subject 商品名称
 * @param string $body 商品描述
 * @return string 支付HTML或跳转链接
 */
function epay_submit($pay_type, $out_trade_no, $total_fee, $subject, $body = '') {
    global $alipay_config;
    
    // 创建支付核心类实例
    $epayCore = new EpayCore($alipay_config);
    
    // 构造请求参数
    $params = array(
        'pid' => $alipay_config['partner'],
        'type' => $pay_type,
        'out_trade_no' => $out_trade_no,
        'notify_url' => $alipay_config['notify_url'],
        'return_url' => $alipay_config['return_url'],
        'name' => $subject,
        'money' => $total_fee,
        'sitename' => '微信城市群聊会员',
        'sign_type' => $alipay_config['sign_type'],
        'sign' => ''
    );
    
    if (!empty($body)) {
        $params['body'] = $body;
    }
    
    // 生成支付表单
    return $epayCore->createPayForm($params);
}

/**
 * 验证支付通知
 * @param array $data 通知数据
 * @return bool 验证结果
 */
function epay_notify_verify($data) {
    global $alipay_config;
    
    // 创建支付核心类实例
    $epayCore = new EpayCore($alipay_config);
    
    // 验证签名
    return $epayCore->verifySign($data);
}

/**
 * 查询订单
 * @param string $out_trade_no 订单号
 * @return array 查询结果
 */
function epay_query($out_trade_no) {
    global $alipay_config;
    
    // 创建支付核心类实例
    $epayCore = new EpayCore($alipay_config);
    
    // 构造请求参数
    $params = array(
        'pid' => $alipay_config['partner'],
        'out_trade_no' => $out_trade_no,
        'sign_type' => $alipay_config['sign_type'],
        'sign' => ''
    );
    
    // 生成签名
    $params['sign'] = $epayCore->createSign($params);
    
    // 发送查询请求
    $url = $alipay_config['apiurl'] . 'api.php';
    $response = $epayCore->httpRequest($url, $params);
    
    // 解析响应
    parse_str($response, $result);
    
    return $result;
}
?>
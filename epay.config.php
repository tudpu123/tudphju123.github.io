<?php
/**
 * 支付配置文件
 */

// 商户ID
$alipay_config['partner'] = '131517535';

// 商户KEY
$alipay_config['key'] = '6K1yVk6M16BK72Ms2ZB8wEyM020bZxK2';

// 支付接口地址
$alipay_config['apiurl'] = 'https://2a.mazhifupay.com/';

// 签名方式 不需修改
$alipay_config['sign_type'] = strtoupper('MD5');

// 字符编码格式 目前支持 gbk 或 utf-8
$alipay_config['input_charset'] = strtolower('utf-8');

// 访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$alipay_config['transport'] = 'https';

// 支付成功后的回调地址（需要是外网可访问的地址）
$alipay_config['notify_url'] = 'http://你的域名/pay-website/notify_url.php';

// 支付完成后跳转的页面（需要是外网可访问的地址）
$alipay_config['return_url'] = 'http://你的域名/pay-website/return_url.php';

// 超时时间，单位：秒
$alipay_config['timeout'] = 300;

return $alipay_config;
?>
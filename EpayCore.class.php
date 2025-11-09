<?php
/**
 * 支付核心类
 */
class EpayCore {
    // 配置参数
    protected $config = array();
    
    /**
     * 构造函数
     */
    public function __construct($config = array()) {
        $this->config = $config;
    }
    
    /**
     * 生成签名
     * @param array $data 要签名的数据
     * @return string 签名结果
     */
    public function createSign($data) {
        // 去除sign参数
        if (isset($data['sign'])) {
            unset($data['sign']);
        }
        
        // 按键名排序
        ksort($data);
        
        // 生成字符串
        $arg = '';
        foreach ($data as $key => $value) {
            if ($value !== '' && $value !== null) {
                $arg .= $key . '=' . $value . '&';
            }
        }
        
        // 添加商户密钥
        $arg .= 'key=' . $this->config['key'];
        
        // 生成签名
        if ($this->config['sign_type'] == 'MD5') {
            $sign = md5($arg);
        } else {
            $sign = '';
        }
        
        return $sign;
    }
    
    /**
     * 验证签名
     * @param array $data 要验证的数据
     * @return bool 验证结果
     */
    public function verifySign($data) {
        $sign = $data['sign'];
        unset($data['sign']);
        
        $mysign = $this->createSign($data);
        
        return strtolower($sign) == strtolower($mysign);
    }
    
    /**
     * 发送HTTP请求
     * @param string $url 请求地址
     * @param array $data 请求数据
     * @return string 响应结果
     */
    public function httpRequest($url, $data = null) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        
        return $output;
    }
    
    /**
     * 生成支付链接
     * @param array $params 支付参数
     * @return string 支付URL
     */
    public function createPayUrl($params) {
        // 生成签名
        $params['sign'] = $this->createSign($params);
        
        // 构造URL
        $url = $this->config['apiurl'] . 'submit.php';
        $queryString = http_build_query($params);
        
        return $url . '?' . $queryString;
    }
    
    /**
     * 生成支付表单
     * @param array $params 支付参数
     * @return string HTML表单
     */
    public function createPayForm($params) {
        // 生成签名
        $params['sign'] = $this->createSign($params);
        
        // 构造表单
        $html = '<form action="' . $this->config['apiurl'] . 'submit.php" method="post" id="pay_form">';
        foreach ($params as $key => $value) {
            $html .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
        }
        $html .= '</form>';
        $html .= '<script>document.getElementById("pay_form").submit();</script>';
        
        return $html;
    }
}
?>
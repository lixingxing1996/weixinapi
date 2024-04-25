<?php

namespace Lixingxing\WeixinApi;

abstract class WeixinApiBase
{
    protected $apiBaseUrl;

    public function __construct($apiBaseUrl)
    {
        $this->apiBaseUrl = $apiBaseUrl;
    }

    protected function sendRequest($endpoint, $data)
    {
        $url = $this->apiBaseUrl . $endpoint;
        
        // 使用 cURL 发送 HTTP POST 请求
        $postData = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($postData)
        ]);
        
        $response = curl_exec($ch);
       
        if (!$response) {
            curl_close($ch);
            throw new \Exception('Curl error: ' . curl_error($ch));
        }
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpStatusCode != 200) {
            throw new \Exception('HTTP request failed with status code ' . $httpStatusCode);
        }
        
        // 解析返回的 JSON 数据
        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Error decoding JSON response: ' . json_last_error_msg());
        }
        // if (isset($data['error_code']) && $data['error_code'] !== 0) {
        //     throw new \Exception('API error: ' . $data['description']);
        // }
        
        return $data['data'];
    }
    

}
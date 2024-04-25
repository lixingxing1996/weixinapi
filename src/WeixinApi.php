<?php

namespace Lixingxing\WeixinApi;

class WeixinApi
{
   
    const TYPE_USER_INFO = 35;
    const TYPE_USER_QRCODE = 0;
    const TYPE_SHAKE_RESULT = 35;
    const TYPE_SHAKE = 34;
    const TYPE_NEARBY_PEOPLE = 29;
    const TYPE_LOGOUT = 81;
    const TYPE_LOCATION_INFO = 63;
    const TYPE_LOCATION_IMAGE = 27;
    const TYPE_NEARBY_LOCATION = 25;
    const TYPE_LOCATION_SEARCH = 26;
    const TYPE_DATABASE_BACKUP = 10059;

    private $apiBaseUrl;

    public function __construct($apiBaseUrl)
    {
        $this->apiBaseUrl = $apiBaseUrl;
    }

    public function getUserInfo()
    {
        return $this->sendRequest('/api/', ['type' => self::TYPE_USER_INFO]);
    }

    public function getUserQrCode()
    {
        return $this->sendRequest('/api/', ['type' => self::TYPE_USER_QRCODE]);
    }

    public function getShakeResult($reportData)
    {
        return $this->sendRequest('/api/', ['type' => self::TYPE_SHAKE_RESULT, 'reportData' => $reportData]);
    }

    public function initiateShake($longitude, $latitude)
    {
        return $this->sendRequest('/api/', ['type' => self::TYPE_SHAKE, 'longitude' => $longitude, 'latitude' => $latitude]);
    }

    public function getNearbyPeople($longitude, $latitude, $userType = 1)
    {
        return $this->sendRequest('/api/', ['type' => self::TYPE_NEARBY_PEOPLE, 'longitude' => $longitude, 'latitude' => $latitude, 'userType' => $userType]);
    }

    public function logout()
    {
        return $this->sendRequest('/api/', ['type' => self::TYPE_LOGOUT]);
    }

    public function getLocationInfo($longitude, $latitude)
    {
        return $this->sendRequest('/api/', ['type' => self::TYPE_LOCATION_INFO, 'longitude' => $longitude, 'latitude' => $latitude]);
    }

    public function getLocationImage($longitude, $latitude, $width = null, $height = null)
    {
        $postData = ['type' => self::TYPE_LOCATION_IMAGE, 'longitude' => $longitude, 'latitude' => $latitude];
        if ($width !== null) $postData['width'] = $width;
        if ($height !== null) $postData['height'] = $height;
        return $this->sendRequest('/api/', $postData);
    }

    public function getNearbyLocation($longitude, $latitude)
    {
        return $this->sendRequest('/api/', ['type' => self::TYPE_NEARBY_LOCATION, 'longitude' => $longitude, 'latitude' => $latitude]);
    }

    public function locationSearch($keyword, $pageInfo = '', $longitude = null, $latitude = null)
    {
        $postData = ['type' => self::TYPE_LOCATION_SEARCH, 'keyword' => $keyword, 'pageInfo' => $pageInfo];
        if ($longitude !== null) $postData['longitude'] = $longitude;
        if ($latitude !== null) $postData['latitude'] = $latitude;
        return $this->sendRequest('/api/', $postData);
    }

    public function backupDatabase($dbName, $outPath, $dbHandle = null)
    {
        $postData = ['type' => self::TYPE_DATABASE_BACKUP, 'dbName' => $dbName, 'outPath' => $outPath];
        if ($dbHandle !== null) $postData['dbHandle'] = $dbHandle;
        return $this->sendRequest('/api/', $postData);
    }


    private function sendRequest($endpoint, $data)
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
        if (isset($data['error_code']) && $data['error_code'] !== 0) {
            throw new \Exception('API error: ' . $data['description']);
        }
        
        return $data['data'];
    }
    


}
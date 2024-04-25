<?php

namespace Lixingxing\WeixinApi;

class PersonalInfoApi extends WeixinApiBase
{
    const TYPE_USER_INFO = 28;
    const TYPE_LOGOUT = 81;
    const TYPE_LOCATION_INFO = 63;
    const TYPE_LOCATION_IMAGE = 27;
    const TYPE_NEARBY_LOCATION = 25;
    const TYPE_LOCATION_SEARCH = 26;

    public function getUserInfo()
    {
        return $this->sendRequest('/api/', ['type' => self::TYPE_USER_INFO]);
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
}
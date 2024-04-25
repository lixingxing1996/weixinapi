<?php

namespace Lixingxing\WeixinApi;

class ContactManagementApi extends WeixinApiBase
{
   
    /**
     * 获取通讯录
     *
     * @return array 获取通讯录列表，包含好友、关注的公众号、已保存到通讯录的群聊
     * @throws \Exception If the request fails or the API returns an error.
     */
    public function getContactList()
    {
        // Construct the data array for the request
        $data = [
            'type' => 29
        ];

        // Send the request using the sendRequest method from the parent class
        return $this->sendRequest('/api/', $data);
    }





}
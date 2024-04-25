<?php

namespace Lixingxing\WeixinApi;

class MessageSendingApi extends WeixinApiBase
{
   

   /**
     * 发送文本消息
     *
     * @param string $userName 接收人wxid
     * @param string $msgContent 文本内容
     * @param array|null $atUserList (optional) 被@wxid列表
     * @return array The response data from the API.
     * @throws \Exception If the request fails or the API returns an error.
     */
    public function sendTextMessage($userName, $msgContent, array $atUserList = null)
    {
        // Construct the data array for the request
        $data = [
            'type' => 10009,
            'userName' => $userName,
            'msgContent' => $msgContent,
        ];


        
        // Include the atUserList if provided
        if ($atUserList !== null) {
            $data['atUserList'] = $atUserList;
        }

        // Send the request using the sendRequest method from the parent class
        return $this->sendRequest('/api/', $data);

    }




}
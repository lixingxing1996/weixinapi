<?php

namespace Lixingxing\WeixinApi;

class CdnApi extends WeixinApiBase
{
    // CDN下载接口类型常量
    const TYPE_CDN_DOWNLOAD = 66;
    
    // CDN上传接口类型常量
    const TYPE_CDN_UPLOAD = 7;

    // 从CDN下载文件
    public function downloadFromCdn($fileId, $aesKey, $fileType, $savePath)
    {
        return $this->sendRequest('/api/', [
            'type' => self::TYPE_CDN_DOWNLOAD,
            'fileid' => $fileId,
            'aeskey' => $aesKey,
            'fileType' => $fileType,
            'savePath' => $savePath
        ]);
    }

    // 上传文件到CDN
    public function uploadToCdn($filePath, $aesKey, $fileType)
    {
        return $this->sendRequest('/api/', [
            'type' => self::TYPE_CDN_UPLOAD,
            'filePath' => $filePath,
            'aeskey' => $aesKey,
            'fileType' => $fileType
        ]);
    }

   
}
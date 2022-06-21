<?php
namespace serviceAssistant\extraServices;

use serviceAssistant\helper\serviceAssistantApiHelper;

trait serviceAssistantApiFile
{
    protected $urlUploadFileByUrl = 'file/upload-file-by-url';

    /**
     * Function for create item
     *
     * @param string $url
     * @param string $path
     * @return array|false|mixed
     */
    public function uploadFileByUrl(
        string $url,
        string $path
    )
    {
        return $this->serviceAssistant->sendRequest($this->urlUploadFileByUrl, [
            'url' => $url,
            'path' => $path,
        ], serviceAssistantApiHelper::API_METHOD_POST);
    }
}

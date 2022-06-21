<?php
namespace serviceAssistant;

use serviceAssistant\Helper\serviceAssistantApiHelper;

class serviceAssistantApiFile extends serviceAssistantApi
{
    const URL_UPLOAD_FILE_BY_URL = 'file/upload-file-by-url';

    /**
     * Function for create item
     *
     * @param string $url
     * @param string $path
     * @return array|false|mixed
     */
    public function upload_file_by_url(
        string $url,
        string $path
    )
    {
        return $this->serviceAssistant->sendRequest(self::URL_UPLOAD_FILE_BY_URL, [
            'url' => $url,
            'path' => $path,
        ], serviceAssistantApiHelper::API_METHOD_POST);
    }
}

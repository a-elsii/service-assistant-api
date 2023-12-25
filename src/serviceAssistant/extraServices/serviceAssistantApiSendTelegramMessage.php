<?php
namespace serviceAssistant\extraServices;

use serviceAssistant\helper\serviceAssistantApiHelper;

trait serviceAssistantApiSendTelegramMessage
{
    protected $urlSendMessage = 'send-info-message';

    /**
     * Function for send message to telegram
     *
     * @return array|false|mixed
     */
    public function sendTelegramMessage($data = [], $id_project = false, $text_info = 'text default')
    {
        $params = [
            'data' => $data,
            'id_project' => $id_project,
            'text_info' => $text_info,
        ];
        return $this->serviceAssistant->sendRequest($this->urlSendMessage, $params, serviceAssistantApiHelper::API_METHOD_POST);
    }
}

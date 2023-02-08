<?php
namespace serviceAssistant\extraServices;

use serviceAssistant\helper\serviceAssistantApiHelper;

trait serviceAssistantApiIpInfo
{
    protected $urlIpInfo = 'ip-info';

    /**
     * Function for getting info by ip
     *
     * @param string $ip
     * @return array|false|mixed
     */
    public function ipInfo(string $ip)
    {
        return $this->serviceAssistant->sendRequest($this->urlIpInfo, [
            'ip' => $ip,
        ],serviceAssistantApiHelper::API_METHOD_POST);
    }
}

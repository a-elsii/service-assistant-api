<?php
namespace serviceAssistant;

use serviceAssistant\helper\serviceAssistantApiHelper;
use serviceAssistant\extraServices\serviceAssistantApiCurrency;
use serviceAssistant\extraServices\serviceAssistantApiFile;
use serviceAssistant\extraServices\serviceAssistantApiTodo;
use serviceAssistant\extraServices\serviceAssistantApiIpInfo;
use serviceAssistant\extraServices\serviceAssistantApiSendTelegramMessage;

class serviceAssistantApi
{
    use serviceAssistantApiFile;
    use serviceAssistantApiCurrency;
    use serviceAssistantApiTodo;
    use serviceAssistantApiIpInfo;
    use serviceAssistantApiSendTelegramMessage;

    const URL_GET_API_HASH = 'auth/get-api-key';
    const URL_TRANSLATE = 'translate';
    const URL_WEATHER = 'weather';
    const URL_SEARCH = 'search';

    const DEFAULT_FROM_LANGUAGE = 'ru';
    const DEFAULT_TO_LANGUAGE = 'en';

    /** @var serviceAssistantApiHelper $serviceAssistant */
    protected $serviceAssistant;
    public function __construct(
        string $serverApi,
        string $apiKey,
        string $cipherAlgo,
        string $salt
    )
    {
        $this->serviceAssistant = new serviceAssistantApiHelper($serverApi, $apiKey, $cipherAlgo, $salt);
    }

    /**
     * Function for get correct api key
     *
     * @return string|array
     */
    public function getApiKey()
    {
        $api_hash = $this->serviceAssistant->sendRequest(self::URL_GET_API_HASH);
        if(isset($api_hash['error']))
            return $api_hash;

        $api_decrypt = $this->serviceAssistant->decrypt($api_hash);
        if(isset($api_decrypt['error']))
            return $api_hash;

        // Changed api key when we get request
        $this->serviceAssistant->apiKey = $api_decrypt;
        return $api_decrypt;
    }

    /**
     * Function for get translate
     *
     * @param string $text
     * @param string $fromLanguage
     * @param string $toLanguage
     * @return array|false|mixed
     */
    public function translate(
        string $text,
        string $fromLanguage = self::DEFAULT_FROM_LANGUAGE,
        string $toLanguage = self::DEFAULT_TO_LANGUAGE
    )
    {
        return $this->serviceAssistant->sendRequest(self::URL_TRANSLATE, [
            'text' => $text,
            'source' => strtolower($fromLanguage),
            'target' => strtolower($toLanguage),
        ]);
    }

    /**
     * Function for get correct weather
     *
     * @param float $lat
     * @param float $lon
     * @return array|false|mixed
     */
    public function getWeather(
        float $lat,
        float $lon
    )
    {
        return $this->serviceAssistant->sendRequest(self::URL_WEATHER, [
            'lat' => $lat,
            'lon' => $lon,
        ]);
    }

    /**
     * Function for search request in Google
     *
     * @param string $search
     * @return array|false|mixed
     */
    public function googleSearch(string $search)
    {
        return $this->serviceAssistant->sendRequest(self::URL_SEARCH, [
            'search' => $search,
        ]);
    }

    /**
     * @param $text
     * @return array|false|mixed
     */
    /**
     * Function for create send request
     *
     * @param string $url
     * @param array $params
     * @param string $method
     * @param array $headers
     * @return array|false|mixed
     */
    public function sendRequest(
        string $url,
        array  $params = [],
        string $method = 'GET',
        array  $headers = []
    )
    {
        return $this->serviceAssistant->sendRequest($url, $params, $method, $headers);
    }

}

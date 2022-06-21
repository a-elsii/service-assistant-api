<?php
namespace serviceAssistant;

use serviceAssistant\Helper\serviceAssistantApiHelper;

class serviceAssistantApiCurrency extends serviceAssistantApi
{
    const URL_GET_ALL = 'currency-rate';
    const URL_CRYPTO = 'currency-rate/crypto';

    /**
     * Function for get all items
     *
     * @return array|false|mixed
     */
    public function getAll()
    {
        return $this->serviceAssistant->sendRequest(self::URL_GET_ALL);
    }

    /**
     * Function for create item
     *
     * @param string $crypto
     * @param string $fiat
     * @return array|false|mixed
     */
    public function getCrypto(
        string $crypto,
        string $fiat
    )
    {
        return $this->serviceAssistant->sendRequest(self::URL_CRYPTO, [
            'crypto' => $crypto,
            'fiat' => $fiat,
        ], serviceAssistantApiHelper::API_METHOD_POST);
    }
}

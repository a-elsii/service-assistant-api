<?php
namespace serviceAssistant\extraServices;

use serviceAssistant\helper\serviceAssistantApiHelper;

trait serviceAssistantApiCurrency
{
    protected $urlGetAllCurrencyRate = 'currency-rate';
    protected $urlCrypto = 'currency-rate/crypto';

    /**
     * Function for get all items
     *
     * @return array|false|mixed
     */
    public function getAllCurrencyRate()
    {
        return $this->serviceAssistant->sendRequest($this->urlGetAllCurrencyRate);
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
        return $this->serviceAssistant->sendRequest($this->urlCrypto, [
            'crypto' => $crypto,
            'fiat' => $fiat,
        ], serviceAssistantApiHelper::API_METHOD_POST);
    }
}

<?php
namespace serviceAssistant\helper;

class serviceAssistantApiHelper
{
    const STATUS_SUCCESS = 200;

    const API_METHOD_GET = "GET";
    const API_METHOD_POST = "POST";

    public $apiKey;
    private $serverApi;
    private $cipher_algo;
    private $salt;

    /**
     * @param string $serverApi
     * @param string $apiKey
     * @param string $cipherAlgo
     * @param string $salt
     */
    public function __construct(
        string $serverApi,
        string $apiKey,
        string $cipherAlgo,
        string $salt
    )
    {
        $this->serverApi = $serverApi;
        $this->apiKey = $apiKey;
        $this->cipher_algo = $cipherAlgo;
        $this->salt = $salt;
    }

    /**
     * Function for send request
     *
     * @param string $url
     * @param array $params
     * @param string $method
     * @param array $headers
     * @return array|mixed|false
     */
    public function sendRequest(
        string $url,
        array  $params = [],
        string $method = 'GET',
        array  $headers = []
    )
    {
        $path = $this->serverApi.$url;
        $params = array_merge($params, [
            'api_hash' => md5($this->apiKey)
        ]);

        // If we have method get we use it
        if($method == self::API_METHOD_GET)
            $path .= "?" . http_build_query($params, '', '&');

        if(!$headers)
            $headers[] = 'Accepts: application/json';

        $curl_data = [
            CURLOPT_URL => $path,            // set the request URL
            CURLOPT_HTTPHEADER => $headers,     // set the headers
            CURLOPT_RETURNTRANSFER => 1,         // ask for raw response instead of bool
            CURLOPT_COOKIESESSION => 1,         // ask for raw response instead of bool
            CURLOPT_CONNECTTIMEOUT => 15,         // ask for raw response instead of bool
            CURLOPT_TIMEOUT => 15,         // ask for raw response instead of bool
        ];

        // If we have method post we use it
        if($method == self::API_METHOD_POST)
        {
            $curl_data[CURLOPT_POST] = true;
            $curl_data[CURLOPT_POSTFIELDS] = http_build_query($params, '', '&');
        }

        $curl = curl_init();
        curl_setopt_array($curl, $curl_data);
        $response = curl_exec($curl);

        // Send the request, save the response
        curl_close($curl); // Close request

        if (!$response)
            return [
                'error' => 'response empty',
                'params' => $params
            ];

        $data = json_decode($response, true);

        // If we have an error returned from the request, then we record it
        if(!self::isRequestSuccess($data))
            return [
                'error' => $data,
                'params' => $params
            ];

        return $data['result'] ?? [];
    }

    /**
     * Logic for decrypt
     *
     * @param $data
     * @return string|array
     */
    public function decrypt($data)
    {
        $baseDecode = base64_decode($data);
        $ivlen = openssl_cipher_iv_length($this->cipher_algo);
        $iv = substr($baseDecode, 0, $ivlen);
        $sha2len = 32;
        $hmac = substr($baseDecode, $ivlen, $sha2len);
        $ciphertext_raw = substr($baseDecode, $ivlen + $sha2len);
        $plaintext = openssl_decrypt($ciphertext_raw, $this->cipher_algo, $this->salt, OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $this->salt, true);
        if(!hash_equals($hmac, $calcmac))
            return [
                'error' => $data,
                'msg' => 'serviceAssistantApi decrypt is brake'
            ];

        return $plaintext;
    }

    /**
     * Function for check correct request
     *
     * @param $request
     * @return bool
     */
    public static function isRequestSuccess($request): bool
    {
        return isset($request['status']) && $request['status'] == self::STATUS_SUCCESS;
    }

}
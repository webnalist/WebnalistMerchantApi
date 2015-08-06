<?php

namespace Webnalist;

use Webnalist\Exception\WebnalistMerchantApiException;
use Webnalist\Security\AuthToken;

/**
 * Created by PhpStorm.
 * User: mateuszdolega
 * Date: 06.08.2015
 * Time: 13:58
 */
class WebnalistMerchantApi
{
    const API_URI = 'https://webnalist.com/api/v1';

    private $token;

    /**
     * @param AuthToken $token
     */
    public function __construct(AuthToken $token)
    {
        $this->setToken($token);
    }

    public function setToken(AuthToken $token)
    {
        $this->token = (string)$token;
    }

    /**
     * @param \stdClass $params
     * @param $url
     * @return mixed
     * @throws WebnalistMerchantApiException
     */
    private function curlPostRequest(\stdClass $params, $url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "content-type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        $error = curl_error($curl);
        $code = curl_errno($curl);
        curl_close($curl);
        if ($error) {
            throw new WebnalistMerchantApiException($error, $code);
        } else {
            return json_decode($response);
        }
    }

    /**
     * @param \stdClass $article
     * @return mixed
     * @throws WebnalistMerchantApiException
     */
    public function createArticle(\stdClass $article)
    {
        $url = self::API_URI . '/api/v1/article';
        return $this->curlPostRequest($article, $url);
    }

    /**
     * @param \stdClass $article
     * @return mixed
     * @throws WebnalistMerchantApiException
     */
    public function updateArticle(\stdClass $article)
    {
        if (!$article->id) {
            throw new WebnalistMerchantApiException('Article id is not defined.');
        }
        $url = self::API_URI . '/api/v1/article/' . $article->id;
        return $this->curlPostRequest($article, $url);
    }
}
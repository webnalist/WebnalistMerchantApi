<?php

namespace Webnalist\Security\Token;

use Webnalist\Security\AuthToken;
use Webnalist\Security\SecurityException;
use Webnalist\Security\SecurityExceptions;

/**
 * Class OAuth2PasswordToken
 * @package Webnalist\Security\Token
 */
class OAuth2PasswordToken extends AuthToken
{

    const AUTH_PATH = '/oauth/v2/token';

    private $apiUri;
    private $publicKey;
    private $privateKey;
    private $username;
    private $password;
    private $tokenLifetime;
    private $refreshToken;
    protected $token;

    /**
     * @param $apiUri
     * @param $publicKey
     * @param $privateKey
     * @param $username
     * @param $password
     */
    public function __construct($apiUri, $publicKey, $privateKey, $username, $password)
    {
        $this->apiUri = $apiUri;
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @param $params
     * @param $url
     * @return mixed
     * @throws SecurityException
     */
    private function curlPostRequest(Array $params, $url)
    {
        $ch = curl_init($url);
        $postString = http_build_query($params);
        curl_setopt($ch, CURLOPT_USERAGENT, 'WEBNALIST MERCHANT API');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
        $error = curl_error($ch);
        $code = curl_errno($ch);
        if ($code == 22) {
            $result = curl_exec($ch);
            curl_close($ch);
        } else {
            throw new SecurityException($error, $code);
        }

        return $result;
    }

    /**
     * @return bool
     * @throws SecurityException
     */
    public function authorize()
    {
        $url = $this->apiUri . self::AUTH_PATH;
        $params = [
            'publicKey' => $this->publicKey,
            'privateKey' => $this->privateKey,
            'username' => $this->username,
            'password' => $this->password,
            'grant_type' => 'password',
            'scope' => 'brand',
        ];

        $result = $this->curlPostRequest($params, $url);

        if ($result) {
            $result = json_decode($result);
            $this->token = $result['token'];
            $this->tokenLifetime = $result['lifetime'];
            $this->refreshToken = $result['refresh_token'];
            return true;
        } else {
            $this->token = null;
            $this->tokenLifetime = 0;
            $this->refreshToken = null;
        }

        throw new SecurityException('Unable to get a token.');
    }


}
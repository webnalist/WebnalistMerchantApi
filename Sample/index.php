<?php

require_once('config/config.php');
require_once('../WebnalistMerchantApi.php');
require_once('../Security/Token/OAuth2PasswordToken.php');
require_once('../Exception/SecurityException.php');

try {
    $token = new \Webnalist\Security\Token\OAuth2PasswordToken(
        $wnMerchantApiUri,
        $wnMerchantAppPublicKey,
        $wnMerchantAppPrivateKey,
        $wnMerchantUsername,
        $wnMerchantPassword
    );
} catch (\Webnalist\Exception\SecurityException $e) {
    echo 'Authorization error: #' . $e->getCode() . ' ' . $e->getMessage();
}

//create an article
if ($token) {
    $wnMerchantApi = new Webnalist\WebnalistMerchantApi($token);
    $article = new stdClass();
    $article->title = 'Lorem ipsum';
    $article->description = 'Lorem ipsum dolor sit amet';
    $article->originImageUri = 'http://....jpg';
    $article->price = 100; //1zł
    $article->brand = $wnBrandId;
    $article->categories = [1, 2];
    $response = $wnMerchantApi->createArticle($article);

    echo '<pre>';
    if (isset($response['type']) && $response['type'] == 'success') {
        print_r($response['code']);
        print_r($response['message']);
        print_r($response['object']);
        print_r($response['object']['id']);//article id
    } else {
        print_r($response['code']);
        print_r($response['message']);
        print_r($response['errors']);
    }
    echo '</pre>';

}

//update an article price
if ($token) {
    $wnMerchantApi = new Webnalist\WebnalistMerchantApi($token);
    $article = new stdClass();
    $article->id = 1;
    $article->price = 100; //1zł
    $wnMerchantApi->updateArticle($article);

    echo '<pre>';
    if (isset($response['type']) && $response['type'] == 'success') {
        print_r($response['code']);
        print_r($response['message']);
        print_r($response['object']);
    } else {
        print_r($response['code']);
        print_r($response['message']);
        print_r($response['errors']);
    }
    echo '</pre>';
}


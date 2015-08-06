<?php

require_once('config/config.php');
require_once('../WebnalistMerchantApi.php');
require_once('../Security/Token/OAuth2PasswordToken.php');
require_once('../Security/SecurityException.php');

try {
    $token = new \Webnalist\Security\Token\OAuth2PasswordToken(
        $wnMerchantApiUri,
        '0_xxxxx',
        'xxxxxxx',
        'user@example.com',
        'user_password'
    );
} catch (\Webnalist\Security\SecurityException $e) {
    echo 'Authorization error: #' . $e->getCode() . ' ' . $e->getMessage();
}

//create an article
if ($token) {
    $wnMerchantApi = new Webnalist\WebnalistMerchantApi($token);
    $article = new stdClass();
    $article->title = 'Lorem ipsum'; //1zł
    $article->description = 'Lorem ipsum dolor sit amet'; //1zł
    $article->originImageUri = 'http://....jpg'; //1zł
    $article->price = 100; //1zł
    $article->categories = [1, 2];
    $wnMerchantApi->createArticle($article);
}

//update an article price
if ($token) {
    $wnMerchantApi = new Webnalist\WebnalistMerchantApi($token);
    $article = new stdClass();
    $article->id = 1;
    $article->price = 100; //1zł
    $wnMerchantApi->updateArticle($article);
}


<?php

namespace Webnalist\Security;

/**
 * AuthToken abstraction
 * @package Webnalist\Security
 */
abstract class AuthToken
{

    /**
     * @var string Token
     */
    protected $token;

    /**
     * @return string|null
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Get and Set token variable
     * @return void
     */
    abstract function authorize();

    /**
     * The __toString method allows a class to decide how it will react when it is converted to a string.
     *
     * @return string
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring
     */
    function __toString()
    {
        return $this->token;
    }


}
<?php

namespace Webnalist\Security;

/**
 * Interface AuthToken
 * @package Webnalist\Security
 */
abstract class AuthToken
{

    protected $token;

    public function getToken()
    {
        return $this->token;
    }


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
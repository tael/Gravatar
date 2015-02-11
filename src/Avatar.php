<?php

namespace Gravatar;


class Avatar
{
    protected $size = 80;
    protected $defaultImage = "";
    protected $rating = "g";

    const SERVER = 'http://www.gravatar.com/avatar/';
    protected $email;
    protected $queries = [];

    private function __construct()
    {

    }

    public static function create()
    {
        return new self;
    }

    public function setEmail($email)
    {
        $this->validateEmail($email);
        $this->email = $email;

        return $this;
    }

    public function getUrl()
    {
        if (empty($this->email)) {
            return "";
        }
        $this->validateEmail($this->email);

        return self::SERVER . $this->getHash($this->email) . $this->queryString();
    }

    private function getHash($email)
    {
        return md5(strtolower(trim($email)));
    }

    private function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("email address is not valid.");
        }
    }

    public function addParam($key, $value)
    {
        $this->queries[] = $key . "=" . $value;

        return $this;
    }

    public function addParams(array $pairs)
    {
        foreach ($pairs as $k => $v) {
            $this->addParam($k, $v);
        }
        return $this;
    }

    private function queryString()
    {
        if (empty($this->queries)) {
            return "";
        }

        return "?" . implode('&', $this->queries);
    }
}
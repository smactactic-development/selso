<?php

namespace Smactactic\Selso\Guards;

use Illuminate\Contracts\Auth\Authenticatable;

class User implements Authenticatable
{
    public function __construct(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->{$key} = is_array($value) ? $this->arrayToObject($value) : $value;
        }
    }

    protected function arrayToObject($array)
    {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                $array[$k] = $this->arrayToObject($v);
            }
        }
        return (object) $array;
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->{'id'};
    }

    public function getAuthPassword() {}
    public function getRememberToken() {}
    public function setRememberToken($value) {}
    public function getRememberTokenName() {}
    public function getAuthPasswordName() {}
}

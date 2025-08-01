<?php

namespace Smactactic\Selso\Guards;

use Illuminate\Contracts\Auth\Authenticatable;

/**
 * @property int $id
 * @property string $name
 * @property array $roles
 * @property array $permissions
 */
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

    public function hasRole(string|array $role): bool
    {
        if (!isset($this->roles)) return false;

        $roles = is_array($role) ? $role : [$role];
        return !empty(array_intersect($roles, (array) $this->roles));
    }

    public function hasAllRoles(array $roles): bool
    {
        return empty(array_diff($roles, (array) $this->roles));
    }

    public function getPermissionNames()
    {
        return collect($this->permissions)->pluck('name')->toArray();
    }

    public function getPermissionLabel($permission)
    {
        return collect($this->permissions)->where('name', $permission)->first()?->label ?? null;
    }

    public function can(string $permission)
    {
        if (!isset($this->permissions)) return false;
        return in_array($permission, $this->getPermissionNames());
    }
}

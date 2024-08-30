<?php

namespace App\Traits;

trait RoleCanAccess
{
    protected array $allowedRoles = [];

    public function bootedRoleCanAccess()
    {
        if (count($this->allowedRoles) > 0 && !auth()->user()->hasAnyRole($this->allowedRoles)) {
            abort(403);
        }
    }

    protected function setAllowedRoles(array $roles): void
    {
        $this->allowedRoles = $roles;
    }
}

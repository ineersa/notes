<?php

namespace App\Contracts;

interface IsActiveUserContract
{
    /**
     * Flag if user is active or not (inactive users shouldn't access auth area)
     * @return bool
     */
    public function isActiveUser(): bool;

    public function redirectRoute(): string;
}

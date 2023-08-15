<?php

namespace App\Services;

interface UserSevice
{
    function login(string $user, string $password): bool;
}

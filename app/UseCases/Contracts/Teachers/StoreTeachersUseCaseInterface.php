<?php

namespace App\UseCases\Contracts\Teachers;

interface StoreTeachersUseCaseInterface
{
    public function handle(string $name, string $email, string $phone, string $password, bool $is_enable): bool;
}

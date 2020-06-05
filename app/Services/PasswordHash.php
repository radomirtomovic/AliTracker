<?php


namespace App\Services;


class PasswordHash
{
    public function hash(string $password): string {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function verify(string $password, string $hash) {
        return password_verify($password, $hash);
    }

    public function needRehash(string $password): bool {
        return password_needs_rehash($password, PASSWORD_BCRYPT, ['cost' => 10]);
    }
}
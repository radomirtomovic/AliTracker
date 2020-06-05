<?php


namespace App\Rules;


use Rakit\Validation\Rule;

class PasswordRule extends Rule
{

    public function check($value): bool
    {
        return true;
    }
}
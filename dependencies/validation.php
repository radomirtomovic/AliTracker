<?php

use App\Rules\PasswordRule;
use App\Rules\UniqueRule;
use Psr\Container\ContainerInterface;
use Rakit\Validation\Validator;

return [
    'rules' => [
        'unique' => UniqueRule::class,
        'password' => PasswordRule::class,
    ],
    Validator::class => static function (ContainerInterface $container) {
        $validator = new Validator();

        foreach ($container->get('rules') as $ruleName => $rule) {
            $validator->addValidator($ruleName, $container->get($rule));
        }

        return $validator;
    }
];
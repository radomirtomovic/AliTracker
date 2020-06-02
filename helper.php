<?php

function env(string $key, $default = null) {
    if(isset($_ENV[$key])) {
        return $_ENV[$key];
    }

    return $default;
}
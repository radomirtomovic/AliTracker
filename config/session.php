<?php

return [
    'name' => 'ali_tracker_session',
    'handler' => 'files',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'lax',
    'domain' => '.alitracker.test',
    'length' => 64,
    'bits_per_char' => 6,
];

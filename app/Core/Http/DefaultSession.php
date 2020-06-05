<?php


namespace App\Core\Http;


use App\Core\Config\Config;

class DefaultSession implements SessionStarter, Session
{
    /**
     * @var Config
     */
    private Config $config;

    private static bool $hasStarted = false;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }


    public function start()
    {
        if (static::$hasStarted) {
            return;
        }
        session_start([
            'name' => $this->config->get('session.name'),
            'save_handler' => $this->config->get('session.handler'),
            'cookie_httponly' => $this->config->get('session.httponly'),
            'cookie_secure' => $this->config->get('session.secure'),
            'sid_length' => $this->config->get('session.length'),
            'sid_bits_per_character' => $this->config->get('session.bits_per_char'),
            'cookie_domain' => $this->config->get('session.domain'),
            'cookie_samesite' => $this->config->get('session.samesite'),
        ]);
    }

    public function regenerate()
    {
        session_regenerate_id();
    }

    public function get(string $key, $default = null)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return $default;
    }

    public function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function __get($name)
    {
        return $this->get($name, null);
    }

    public function __set($name, $value)
    {
        $this->set($name, $value);
    }
}
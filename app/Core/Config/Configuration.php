<?php

namespace App\Core\Config;


class Configuration implements Config
{
    private array $config;

    public function __construct(Loader $loader)
    {
        $this->config = $loader->load();
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        $keys = explode('.', $key);
        $value = null;
        foreach ($keys as $k) {
            if (!isset($value) && isset($this->config[$k])) {
                $value = $this->config[$k];
            } elseif (isset($value[$k])) {
                $value = $value[$k];
            } else {
                return $value;
            }
        }
        return $value;
    }

}
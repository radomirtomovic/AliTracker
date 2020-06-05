<?php


namespace App;


use App\Core\Config\Config;
use App\Core\Http\SessionStarter;
use App\Core\Init;

class Initializer implements Init
{
    /**
     * @var Config
     */
    private Config $config;
    /**
     * @var SessionStarter
     */
    private SessionStarter $sessionStarter;

    public function __construct(Config $config, SessionStarter $sessionStarter)
    {
        $this->config = $config;
        $this->sessionStarter = $sessionStarter;
    }

    public function init()
    {
        ini_set('display_errors', $this->config->get('app.debug'));
        date_default_timezone_set($this->config->get('app.timezone'));
        $this->sessionStarter->start();
    }

}
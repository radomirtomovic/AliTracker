<?php


namespace App\Http\Controllers;


use App\Core\Config\Config;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{

    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var Config
     */
    private Config $config;

    public function __construct(Request $request, Config $config)
    {
        $this->request = $request;
        $this->config = $config;
    }

    public function show()
    {
         return $this->view('index.twig', ['key' => $this->config->get('app.key')]);
    }

}
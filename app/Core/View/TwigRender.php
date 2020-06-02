<?php


namespace App\Core\View;


use Twig\Environment as TwigEnvironment;

class TwigRender implements Renderable
{
    /**
     * @var TwigEnvironment
     */
    private TwigEnvironment $environment;

    public function __construct(TwigEnvironment $environment)
    {
        $this->environment = $environment;
    }

    public function render(string $view, array $data = []): string
    {
        return $this->environment->render($view, $data);
    }
}
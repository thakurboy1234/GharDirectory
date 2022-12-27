<?php

namespace Botble\Base\Supports;

use Twig\Environment;

class TwigCompiler
{
    protected TwigLoader $loader;

    protected Environment $env;

    public function __construct(array $options = [])
    {
        $this->loader = new TwigLoader();
        $this->env = new Environment($this->loader, $options);
    }

    public function compile(string $content, array $data = []): string
    {
        $this->loader->setContent($content);

        return $this->env->render($this->loader->hashedContent(), $data);
    }
}

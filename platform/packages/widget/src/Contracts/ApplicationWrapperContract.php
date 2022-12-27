<?php

namespace Botble\Widget\Contracts;

interface ApplicationWrapperContract
{
    /**
     * Wrapper around app()->call().
     *
     * @param array $params
     * @return mixed
     */
    public function call(string|array $method, array $params = []);

    /**
     * Get the specified configuration value.
     *
     * @param mixed $default
     * @return mixed
     */
    public function config(string $key, $default = null);

    /**
     * Wrapper around app()->getNamespace().
     */
    public function getNamespace(): string;

    /**
     * Wrapper around app()->make().
     *
     * @return mixed
     */
    public function make(string $abstract, array $parameters = []);
}

<?php

namespace Botble\Optimize\Http\Middleware;

class CollapseWhitespace extends PageSpeed
{
    public function apply(string $buffer): string
    {
        $replace = [
            "/\n([\S])/" => '$1',
            "/\r/" => '',
            "/\n/" => '',
            "/\t/" => '',
            '/ +/' => ' ',
            '/> +</' => '><',
        ];

        return $this->replace($replace, $buffer);
    }
}

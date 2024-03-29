<?php

namespace App\Controllers;

use App\Core\Request;

abstract class AbstractController
{
    protected $request;
    protected $view;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function render(string $template, array $params): string
    {
        extract($params);

        ob_start();
        include $template;
        $renderedView = ob_get_clean();

        return $renderedView;
    }

    protected function redirect($url)
    {
        return header("Location: " . $url);
        exit;
    }

}
<?php 

namespace App\Core;

class Router {

    private $routeMap;
    private static $regexPatterns = [
        'number' => '\d+',
        'string' => '\w'
    ];

    public function __construct() {
        $json = file_get_contents(__DIR__ . '/../../config/routes.json');
        $this->routeMap = json_decode($json, true);
    }

    public function getRoute(Request $request): string {
        $path = $request->getPath();
        var_dump($path);
        foreach ($this->routeMap as $route => $routeDetails) {
            $regexRoute = $this->getRegexRoute($route, $routeDetails);
            if (preg_match("@^/$regexRoute$@", $path)) {
                return $this->executeController($route, $path, $routeDetails, $request);
            }
        }

        /* $errorController = new ErrorController($request);
        return $errorController->notFound(); */
    }

    private function getRegexRoute(string $route, array $routeDetails): string {
        if (isset($routeDetails['params'])) {
            foreach ($routeDetails['params'] as $name => $type) {
                $route = str_replace(':' . $name, self::$regexPatterns[$type], $route);
            }
        }

        return $route;
    }

    private function executeController(
        string $route,
        string $path,
        array $routeDetails,
        Request $request
    ): string {
        $controllerName = '\App\Controllers\\' . $routeDetails['controller'] . 'Controller';
        $controller = new $controllerName($request);

        if (isset($routeDetails['login']) && $routeDetails['login']) {
            if ($request->getCookies()->has('user')) {
                $userId = $request->getCookies()->get('user');
                $controller->setUserId($userId);
            } else {
                $errorController = new UserController($request);
                return $errorController->login();
            }
        }

        $params = $this->extractParams($route, $path);
        return call_user_func_array([$controller, $routeDetails['methodToCall']], $params);
    }

    private function extractParams(string $route, string $path): array {
        $params = [];

        $pathParts = explode('/', $path);
        $routeParts = explode('/', $route);

        foreach ($routeParts as $key => $routePart) {
            if (strpos($routePart, ':') === 0) {
                $name = substr($routePart, 1);
                $params[$name] = $pathParts[$key+1];
            }
        }

        return $params;
    }
}
<?php

require __DIR__ . '/../vendor/autoload.php';

try {
    $route = $_GET['route'] ?? '';
    $routes = require __DIR__ . '/../src/routes.php';
    $isRoutFound = false;
    foreach ($routes as $pattern => $contollerAndAction) {
        preg_match($pattern, $route, $matches);
        if (!empty($matches)) {
            $isRoutFound = true;
            break;
        }
    }
    if (!$isRoutFound) {
        throw new \MyProject\Exceptions\NotFoundException();
        return;
    }

    unset($matches[0]);

    $controllerName = $contollerAndAction[0];
    $actionName = $contollerAndAction[1];

    $controller = new $controllerName();
    $controller->$actionName(...$matches);
} catch (\MyProject\Exceptions\DbException $e) {
    $view = new \MyProject\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('500.php', ['error' => $e->getMessage()], 500);
} catch (\MyProject\Exceptions\NotFoundException $e) {
    $view = new \MyProject\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('404.php', ['error' => $e->getMessage()], 404);
} catch (\MyProject\Exceptions\UnauthorizedException $e) {
    $view = new \MyProject\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('401.php', [], 401);
} catch (\MyProject\Exceptions\Forbidden $e) {
    $view = new \MyProject\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('403.php', ['error' => $e->getMessage()], 401);
}
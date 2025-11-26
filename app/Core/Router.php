<?php

namespace App\Core;

class Router
{
  private static array $routes = [];

  public static function get(string $uri, $callback)
  {
    self::$routes['GET'][$uri] = $callback;
  }

  public static function post(string $uri, $callback)
  {
    self::$routes['POST'][$uri] = $callback;
  }

  // Match route with request path and extract parameters
  private static function mathRoute(string $requestPath, string $route, array &$params = []): bool
  {
    $requestPath = trim($requestPath, "/");
    $route = trim($route, "/");

    $reqParts = $requestPath === "" ? [] : explode("/", $requestPath);
    $routeParts = $route === "" ? [] : explode("/", $route);

    if (count($reqParts) !== count($routeParts)) return false;

    $params = [];

    foreach ($routeParts as $i => $part) {
      if (preg_match("/^\{(.+)\}$/", $part, $m)) {
        $params[$m[1]] = $reqParts[$i];
      } else {
        if ($part !== $reqParts[$i]) return false;
      }
    }

    return true;
  }

  public static function dispatch()
  {
    $method = $_SERVER['REQUEST_METHOD'];
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // remove script directory (if using /absensq/public as base)
    $base = str_replace("\\", "/", dirname($_SERVER["SCRIPT_NAME"]));
    if ($base !== "/" && str_starts_with($uri, $base)) {
      $uri = substr($uri, strlen($base));
    }

    $uri = "/" . trim($uri, "/");

    if (!isset(self::$routes[$method])) {
      http_response_code(404);
      echo "404";
      return;
    }

    foreach (self::$routes[$method] as $route => $callback) {
      $params = [];
      if (self::mathRoute($uri, $route, $params)) {
        if (is_array($callback) && is_string($callback[0])) {
          $controllerClass = $callback[0];
          $methodName = $callback[1];
          $controller = new $controllerClass();
          return call_user_func_array([$controller, $methodName], $params);
        } elseif (is_callable($callback)) {
          return call_user_func_array($callback, $params);
        }
      }
    }

    http_response_code(404);
    echo "404 Not Found";
  }
}

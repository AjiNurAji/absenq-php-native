<?php

namespace App\Core;

class Router
{
  private static array $routes = [];
  private static array $middlewares = [];

  public static function get(string $uri, $callback, array $middlewares = []): void
  {
    self::$routes["GET"][$uri] = $callback;

    if (!empty($middlewares)) {
      self::$middlewares["GET"][$uri] = $middlewares;
    }
  }

  public static function post(string $uri, $callback, array $middlewares = []): void
  {
    self::$routes["POST"][$uri] = $callback;

    if (!empty($middlewares)) {
      self::$middlewares["POST"][$uri] = $middlewares;
    }
  }

  // Match route with request path and extract parameters
  private static function mathRoute(string $requestPath, string $route, array &$params = []): bool
  {
    $requestPath = trim($requestPath, "/");
    $route = trim($route, "/");

    $reqParts = $requestPath === "" ? [] : explode("/", $requestPath);
    $routeParts = $route === "" ? [] : explode("/", $route);

    if (count($reqParts) !== count($routeParts))
      return false;

    $params = [];

    foreach ($routeParts as $i => $part) {
      if (preg_match("/^\{(.+)\}$/", $part, $m)) {
        $params[$m[1]] = $reqParts[$i];
      } else {
        if ($part !== $reqParts[$i])
          return false;
      }
    }

    return true;
  }

  public static function dispatch()
  {
    $method = $_SERVER["REQUEST_METHOD"];
    $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

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
      if (!self::mathRoute($uri, $route, $params))
        continue;

      // Handle middlewares
      $middlewares = self::$middlewares[$method][$route] ?? [];

      foreach ($middlewares as $mw) {
        if (is_array($mw)) {
          $mwClass = $mw[0];
          $mwMethod = $mw[1];
          $class = new $mwClass();
          $class::handle();
          $class::$mwMethod();
        } else {
          $mwClass = $mw;
          (new $mwClass())::handle();
        }
      }

      // Call the controller method or callback function
      if (is_array($callback) && is_string($callback[0])) {
        $controllerClass = $callback[0];
        $methodName = $callback[1];
        $controller = new $controllerClass();
        return call_user_func_array([$controller, $methodName], $params);
      } elseif (is_callable($callback)) {
        return call_user_func_array($callback, $params);
      }

    }

    http_response_code(404);
    echo "404 Not Found";
  }
}

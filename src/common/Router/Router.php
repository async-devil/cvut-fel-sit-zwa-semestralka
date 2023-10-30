<?php

declare(strict_types=1);

namespace App;

enum Methods: string
{
  case POST = "POST";
  case GET = "GET";
  case PUT = "PUT";
  case DELETE = "DELETE";
}

class Router
{
  private array $handlers;

  const PREFIX = "";

  private function removePathPrefix(string $path)
  {
    return str_replace(self::PREFIX, "", $path);
  }

  private function parsePath(string $path)
  {
    $trimmedPath = preg_replace("/^\/+|\/$/gm", "", $path);

    return explode("/", $trimmedPath);
  }

  private function registerRoute(Methods $method, string $path, callable $handler)
  {
    $this->handlers[$method->value . $path] = [
      "method" => $method,
      "path" => $this->parsePath($path),
      "handler" => $handler
    ];
  }

  public function post(string $path, callable $handler)
  {
    return $this->registerRoute(Methods::POST, $path, $handler);
  }

  public function get(string $path, callable $handler)
  {
    return $this->registerRoute(Methods::GET, $path, $handler);
  }

  public function start(): void
  {
    $requestMethod = $_SERVER["REQUEST_METHOD"];
    $requestPath = parse_url($_SERVER["REQUEST_URI"])["path"];

    $parsedRequestPath = $this->parsePath($this->removePathPrefix(($requestPath)));

    $callback = null;

    foreach ($this->handlers as $handler) {
      global $callback;

      if ($requestMethod !== $handler["method"]) continue;

      $handlerPath = $handler["path"];
      $handlerSubPathsCount = count($handlerPath);

      if (count($parsedRequestPath) !== $handlerSubPathsCount) continue;

      for ($i = 0; $i < $handlerSubPathsCount; $i += 1) {
        $handlerSubPath = $handlerPath[$i];
        $requestSubPath = $parsedRequestPath[$i];

        if (!str_starts_with($handlerSubPath, ":") && $handlerSubPath !== $requestSubPath) break;

        if ($i === $handlerSubPathsCount - 1) $callback = $handler["route"];
      }
    }
  }
}

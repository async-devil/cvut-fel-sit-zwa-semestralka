<?php

declare(strict_types=1);

namespace App;

require_once __DIR__ . "/Request.php";
require_once __DIR__ . "/Response.php";

use App\Request;
use App\Response;

enum Methods: string
{
  case POST = "POST";
  case GET = "GET";
  case PUT = "PUT";
  case DELETE = "DELETE";
}

class Router
{
  private string $PREFIX;
  private const TRIM_REGEXP = "/^\/+|\/$/m";

  private array $requestURISubPaths = [];
  private Methods $requestMethod;

  private $notFoundHandler;

  private $callback;
  private bool $isMatched = false;

  private Request $request;
  private Response $response;

  public function __construct()
  {
    $this->response = new Response();
    $this->request = new Request();

    $this->PREFIX = getenv("PREFIX") ? getenv("PREFIX") : "";

    $this->requestMethod = Methods::from($_SERVER['REQUEST_METHOD']);
    $this->request->method = $this->requestMethod;

    $parsedURI = $this->trimURI(str_replace($this->PREFIX, "", $_SERVER["REQUEST_URI"]));
    $this->request->URI = $parsedURI;

    $this->requestURISubPaths = explode("/", $parsedURI);
  }

  public function post(string $path, callable $handler)
  {
    return $this->registerRoute(Methods::POST, $path, $handler);
  }

  public function get(string $path, callable $handler)
  {
    return $this->registerRoute(Methods::GET, $path, $handler);
  }

  public function put(string $path, callable $handler)
  {
    return $this->registerRoute(Methods::PUT, $path, $handler);
  }

  public function delete(string $path, callable $handler)
  {
    return $this->registerRoute(Methods::DELETE, $path, $handler);
  }

  public function notFound(callable $handler)
  {
    $this->notFoundHandler = $handler;
  }

  private function trimURI(string $uri): string
  {
    return preg_replace(self::TRIM_REGEXP, "", $uri);
  }

  private function getParameterValuesFromURI(array $patternURISubPaths, array $requestURISubPaths): object
  {
    $parametersDictionary = array();

    for ($i = 0; $i < count($patternURISubPaths); $i += 1) {
      $patternSubPath = $patternURISubPaths[$i];
      $requestSubPath = $requestURISubPaths[$i];

      if (str_starts_with($patternSubPath, ":")) $parametersDictionary[substr($patternSubPath, 1)] = $requestSubPath;
    }

    return (object)$parametersDictionary;
  }

  private function registerRoute(Methods $method, string $path, callable $handler): void
  {
    if ($this->isMatched) return;

    $handlerSubPaths = explode("/", $this->trimURI($path));
    $handlersSubPathsCount = count($handlerSubPaths);

    if ($method !== $this->requestMethod) return;
    if ($handlersSubPathsCount !== count($this->requestURISubPaths)) return;

    for ($i = 0; $i < $handlersSubPathsCount; $i += 1) {
      $handlerSubPath = $handlerSubPaths[$i];
      $requestSubPath = $this->requestURISubPaths[$i];

      if (!str_starts_with($handlerSubPath, ":") && $handlerSubPath !== $requestSubPath) break;

      if ($i === $handlersSubPathsCount - 1) {
        $this->callback = $handler;
        $this->isMatched = true;

        $this->request->parameters = $this->getParameterValuesFromURI($handlerSubPaths, $this->requestURISubPaths);
      }
    }
  }

  public function start()
  {
    if (!$this->isMatched) {
      header("HTTP/1.1 404 Not Found");

      return call_user_func($this->notFoundHandler, $this->request, $this->response);
    }

    return call_user_func($this->callback, $this->request, $this->response);
  }
}

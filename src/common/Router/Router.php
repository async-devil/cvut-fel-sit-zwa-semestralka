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
  private array $env;
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
    $this->PREFIX = $GLOBALS["env"]["PREFIX"] or "";

    $this->response = new Response();
    $this->request = new Request();

    $this->requestMethod = Methods::from($_SERVER['REQUEST_METHOD']);
    $this->request->method = $this->requestMethod;

    $parsedURI = $this->trimURI(str_replace($this->PREFIX, "", $_SERVER["REQUEST_URI"]));
    $this->request->URI = $parsedURI;

    $this->requestURISubPaths = explode("/", $parsedURI);
  }

  /**
   * handle POST request
   * @param string $path path on which request must be handled
   * @param callable<Request, Response> $handler function which will be executed
   */
  public function post(string $path, callable $handler)
  {
    return $this->registerRoute(Methods::POST, $path, $handler);
  }

  /**
   * handle GET request
   * @param string $path path on which request must be handled
   * @param callable<Request, Response> $handler function which will be executed
   */
  public function get(string $path, callable $handler)
  {
    return $this->registerRoute(Methods::GET, $path, $handler);
  }

  /**
   * handle PUT request
   * @param string $path path on which request must be handled
   * @param callable<Request, Response> $handler function which will be executed
   */
  public function put(string $path, callable $handler)
  {
    return $this->registerRoute(Methods::PUT, $path, $handler);
  }

  /**
   * handle DELETE request
   * @param string $path path on which request must be handled
   * @param callable<Request, Response> $handler function which will be executed
   */
  public function delete(string $path, callable $handler)
  {
    return $this->registerRoute(Methods::DELETE, $path, $handler);
  }

  /**
   * handle not found page
   */
  public function notFound(callable $handler)
  {
    $this->notFoundHandler = $handler;
  }

  /**
   * trim URI from /
   */
  private function trimURI(string $uri): string
  {
    return preg_replace(self::TRIM_REGEXP, "", $uri);
  }

  /**
   * match pattern parameter sub paths to request sub paths
   * @param array<string> $patternURISubPaths ["users", ":id", "update"]
   * @param array<string> $requestURISubPaths ["users", "a2e-a65-2ab", "update"]
   * @return object {id: "a2e-a65-2ab"}
   */
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

  /**
   * @param Methods $method HTTP request method
   * @param string $path path on which request must be handled
   * @param callable<Request, Response> $handler function which will be executed
   */
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

  /**
   * start listening handled routes
   */
  public function start()
  {
    if (!$this->isMatched) {
      http_response_code(404);

      return call_user_func($this->notFoundHandler, $this->request, $this->response);
    }

    return call_user_func($this->callback, $this->request, $this->response);
  }
}

<?php

declare(strict_types=1);

require_once __DIR__ . "/common/Router/Router.php";

use App\Request;
use App\Response;
use App\Router;

$router = new Router();

$router->notFound(function (Request $request, Response $response) {
  $response->renderPage("404", ["uri" => $request->URI]);
});

$router->get("/", function (Request $request, Response $response) {
  $response->renderPage("home");
});

$router->get("/about/:parameter", function (Request $request, Response $response) {
  $response->renderPage("about", ["parameter" => $request->parameters->parameter]);
});

$router->start();

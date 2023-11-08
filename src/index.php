<?php

declare(strict_types=1);

require_once __DIR__ . "/common/Router/Router.php";
use App\Router;

$router = new Router();

$router->notFound(function() {
  echo "Actually not found";
});

$router->get("/", function () {
  echo "Home Page";
});

$router->get("/about/:param", function (object $parameters) {
  echo "About Page";
  echo $parameters->param;
});

$router->start();
<?php

declare(strict_types=1);

require_once __DIR__ . "/common/Router/Router.php";
require_once __DIR__ . "/common/Database/Database.php";

use App\Request;
use App\Response;
use App\Router;
use App\Database;

$env = parse_ini_file(__DIR__ . "/.env");
$PREFIX = $env["PREFIX"] or "";

$database = new Database();
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

$router->get("/recipes/:id", function (Request $request, Response $response) {
  global $database;

  try {
    $recipe = $database->getRecipeById($request->parameters->id);
    $response->renderPage("recipe", ["recipe" => $recipe]);
  } catch (Exception $exception) {
    $response->renderPage("404", ["uri" => $request->URI]);
  }
});

$router->post("/recipes", function (Request $request, Response $response) {
  global $database;

  $recipe = $database->createRecipe($request->body);

  http_response_code(201);
  header("Content-type: application/json; charset=utf-8");

  echo json_encode($recipe);
});

$router->start();

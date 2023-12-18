<?php

declare(strict_types=1);

require_once __DIR__ . "/common/Router/Router.php";
require_once __DIR__ . "/common/Database/Database.php";
require_once __DIR__ . "/common/Database/Recipe.php";
require_once __DIR__ . "/common/Authentication/Authentication.php";
require_once __DIR__ . "/common/Validator/Validator.php";
require_once __DIR__ . "/common/Router/urlBuilder.php";
require_once __DIR__ . "/common/Router/HTTPException.php";

use App\Authentication;
use App\Request;
use App\Response;
use App\Router;
use App\Database;
use App\Validator;
use App\HTTPException;
use App\Recipe;

use function App\urlBuilder;

$env = parse_ini_file(__DIR__ . "/.env");
$PREFIX = $env["PREFIX"] or "";

$database = new Database();
$router = new Router();
$authenticator = new Authentication();

$router->notFound(function (Request $request, Response $response) {
  $response->renderPage("404", ["uri" => $request->URI]);
});

$router->get("/", function (Request $request, Response $response) {
  $response->renderPage("home");
});

function adminPageGuard(Response $response)
{
  global $authenticator;

  if ($authenticator->isNeedInit()) die($response->renderPage("register", []));
  else if (!$authenticator->isLoggedIn()) die($response->renderPage("login", []));
}

function adminRouteGuard()
{
  global $authenticator;

  if (!$authenticator->isLoggedIn()) HTTPException::sendException(401, "Unauthorized");
}

$router->get("/admin", function (Request $request, Response $response) {
  adminPageGuard($response);

  return $response->renderPage("admin", []);
});

$router->post("/admin/login", function (Request $request, Response $response) {
  global $authenticator;

  $password = $request->body["password"] ?? "";
  Validator::isPassword($password, "password");

  $authenticator->logIn($password);

  HTTPException::sendException(200, "Success");
});

$router->post("/admin/register", function (Request $request, Response $response) {
  global $authenticator;

  if (!$authenticator->isNeedInit()) HTTPException::sendException(403, "Registration has already been completed");

  $password = $request->body["password"] ?? "";
  Validator::isPassword($password, "password");

  $authenticator->register($password);

  HTTPException::sendException(200, "Success");
});

$router->get("/admin/recipes/:id", function (Request $request, Response $response) {
  adminPageGuard($response);

  global $database;

  $id = $request->parameters->id;

  if ($id === "new") {
    return $response->renderPage("operate-recipe", ["operation" => "create", "recipe" => new Recipe(Recipe::$sampleData, true)]);
  }

  try {
    $recipe = $database->getRecipeById($id);

    return $response->renderPage("operate-recipe", ["operation" => "update", "recipe" => $recipe]);
  } catch (Exception $exception) {
    return $response->renderPage("404", ["uri" => $request->URI]);
  }
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

$router->get("/recipes/catalog/:tag", function (Request $request, Response $response) {
  global $database;

  $tag = $request->parameters->tag;

  if ($tag === "all") {
    return $response->renderPage("recipes", ["recipes" => $database->data, "tag" => $tag]);
  }

  return $response->renderPage("recipes", ["recipes" => $database->getRecipesByTag($tag, 5), "tag" => $tag]);
});

$router->post("/recipes", function (Request $request, Response $response) {
  adminRouteGuard();

  global $database;

  $recipe = $database->createRecipe($request->body);

  http_response_code(201);
  header("Content-type: application/json; charset=utf-8");

  echo json_encode($recipe);
});

$router->put("/recipes/:id", function (Request $request, Response $response) {
  adminRouteGuard();

  global $database;

  try {
    $database->updateRecipe($request->parameters->id, $request->body);

    return HTTPException::sendException(200, "Success");
  } catch (Exception $exception) {
    HTTPException::sendException(404, "Recipe not found");
  }
});

$router->start();

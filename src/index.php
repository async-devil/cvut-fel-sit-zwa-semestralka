<?php

declare(strict_types=1);

require_once __DIR__ . "/common/Router.php";
use App\Router;

function console_log($output, $with_script_tags = true)
{
  $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
    ');';
  if ($with_script_tags) {
    $js_code = '<script>' . $js_code . '</script>';
  }
  echo $js_code;
}

$router = new Router();

$router->get("/", function () {
  echo "Home Page";
});

$router->get("/about", function () {
  echo "About Page";
});

$router->start();
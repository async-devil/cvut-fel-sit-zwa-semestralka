<?php

declare(strict_types=1);

namespace App;

class Request
{
  public Methods $method;
  public string $URI;
  public object $parameters;
  public array $body;

  public function __construct()
  {
    $body = json_decode(file_get_contents('php://input'), true);
    if (is_null($body)) $body = array();

    $this->body = $body;
  }
}

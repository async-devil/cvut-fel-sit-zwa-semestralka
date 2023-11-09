<?php

declare(strict_types=1);

namespace App;

class Request
{
  public Methods $method;
  public string $URI;
  public object $parameters;
  public object $body;

  public function __construct()
  {
    $this->body = (object)json_decode(file_get_contents('php://input'), true);
  }
}

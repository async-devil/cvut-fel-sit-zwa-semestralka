<?php

declare(strict_types=1);

namespace App;

use Exception;

class HTTPException extends Exception
{
  public function __construct(int $code, string $message)
  {
    parent::__construct($message, $code);

    $this->code = $code;
    $this->message = $message;
  }

  /**
   * return json string of object with fields code and message
   */
  public function toJSON(): string
  {
    return json_encode(array("code" => $this->code, "message" => $this->message));
  }

  /**
   * die sending json error response
   */
  public static function sendException(int $code = 500, string $message = ""): void
  {
    $exception = new HTTPException($code, $message);

    http_response_code($code);
    header("Content-type: application/json; charset=utf-8");

    die($exception->toJSON());
  }
}

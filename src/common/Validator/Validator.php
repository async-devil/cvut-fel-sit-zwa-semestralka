<?php

declare(strict_types=1);

namespace App;

class Validator
{
  public static function throwException(int $code, string $message)
  {
    http_response_code($code);
    header("Content-type: application/json; charset=utf-8");

    die(json_encode(array("code" => $code, "message" => $message)));
  }

  public static function isString(mixed $value, string $fieldName, $message = "is not a string value")
  {
    if (!is_string($value)) Validator::throwException(404, "{$fieldName} {$message}");
  }

  public static function isStringArray(mixed $value, string $fieldName, $message = "is not a string array")
  {
    if (!is_array($value)) Validator::throwException(404, "{$fieldName} {$message}");

    foreach ($value as $element) {
      Validator::isString($element, $fieldName, $message);
    }
  }
}

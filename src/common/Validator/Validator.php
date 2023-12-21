<?php

declare(strict_types=1);

namespace App;

require_once __DIR__ . "/../Router/HTTPException.php";

use App\HTTPException;

class Validator
{
  /**
   * check if value is string, if not die with HTTP code 400
   */
  public static function isString(mixed $value, string $fieldName, $message = "is not a string value")
  {
    if (!is_string($value)) HTTPException::sendException(400, "{$fieldName} {$message}");
  }

  /**
   * check if value is password, if not die with HTTP code 400
   */
  public static function isPassword(mixed $value, string $fieldName, $message = "is not a valid password value, must contain minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character")
  {
    Validator::isString($value, $fieldName);

    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $value)) HTTPException::sendException(400, "{$fieldName} {$message}");
  }

  /**
   * check if value is string array, if not die with HTTP code 400
   */
  public static function isStringArray(mixed $value, string $fieldName, $message = "is not a string array")
  {
    if (!is_array($value)) HTTPException::sendException(400, "{$fieldName} {$message}");

    foreach ($value as $element) {
      Validator::isString($element, $fieldName, $message);
    }
  }
}

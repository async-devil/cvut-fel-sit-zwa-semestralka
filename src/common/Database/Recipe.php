<?php

declare(strict_types=1);

namespace App;

require_once __DIR__ . "/Database.php";
require_once __DIR__ . "/../Validator/Validator.php";

use App\Database;
use App\Validator;

class Recipe
{

  public string $id;
  public string $name;
  public string $description;
  public string $previewImage;
  public string $source;
  public string $tag;
  public array $sections;


  public function __construct(bool | array $data = false, $setId = false)
  {
    if ($setId) $data["id"] = Database::uuidv4();
    if ($data) return $this->set($data);

    $this->id = Database::uuidv4();
  }

  private function set(array $data)
  {
    foreach ($data as $key => $value) $this->{$key} = $value;
  }

  public static function validateSchema(Recipe $schema)
  {
    Validator::isString($schema->name, "name");
    Validator::isString($schema->description, "description");
    Validator::isString($schema->previewImage, "previewImage");
    Validator::isString($schema->source, "source");
    Validator::isString($schema->tag, "tag");
  }
}

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
  public string $content;


  public function __construct(bool | array $data = false, $setId = false)
  {
    if ($setId) $data["id"] = Database::uuidv4();
    if ($data) $this->set($data);
  }

  public function set(array $data)
  {
    Recipe::validateSchema($data);

    $this->id = $data["id"];
    $this->name = $data["name"];
    $this->description = $data["description"];
    $this->previewImage = $data["previewImage"];
    $this->source = $data["source"];
    $this->tag = $data["tag"];
    $this->content = $data["content"];
  }

  public static function validateSchema(array $schema)
  {
    Validator::isString($schema["name"] ?? null, "name");
    Validator::isString($schema["description"] ?? null, "description");
    Validator::isString($schema["previewImage"] ?? null, "previewImage");
    Validator::isString($schema["source"] ?? null, "source");
    Validator::isString($schema["tag"] ?? null, "tag");
    Validator::isString($schema["content"] ?? null, "content");
  }

  public static $sampleData = ["name" => "Sample recipe", "description" => "This is sample recipe", "previewImage" => "https://placehold.co/600x400", "source" => "https://google.com", "tag" => "none", "content" => "<h2>Ingredients</h2><p>None</p><h2>Instructions</h2><p>None</p>"];
}

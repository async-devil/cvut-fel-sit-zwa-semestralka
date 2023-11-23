<?php

declare(strict_types=1);

namespace App;

require_once __DIR__ . "/Recipe.php";

use Exception;
use App\Recipe;

class Database
{

  private const DB_FILE = __DIR__ . "/database.json";
  public array $data;

  public function __construct()
  {
    $this->createDatabaseFileIfAbsent();
    $this->readData();
  }

  static public function uuidv4(): string
  {

    $data = random_bytes(16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
  }

  private function createDatabaseFileIfAbsent()
  {
    if (!file_exists(Database::DB_FILE)) {
      file_put_contents(Database::DB_FILE, "[]");
    }
  }

  private function readData(): void
  {
    $this->data = json_decode(file_get_contents(Database::DB_FILE), true);
  }

  private function putData(): void
  {
    file_put_contents(Database::DB_FILE, json_encode($this->data));
  }

  public function getRecipeById(string $id): Recipe
  {
    $this->readData();

    foreach ($this->data as $recipe) {
      if ($recipe["id"] == $id) {
        return new Recipe($recipe);
      }
    }

    throw new Exception("Not found");
  }

  public function createRecipe(array $data): Recipe
  {
    $recipe = new Recipe($data, true);

    array_push($this->data, new Recipe($data, true));
    $this->putData();

    return $recipe;
  }
}

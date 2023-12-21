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

  /**
   * generate uuid-v4
   */
  static public function uuidv4(): string
  {

    $data = random_bytes(16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
  }

  private function createDatabaseFileIfAbsent(): void
  {
    if (!file_exists(Database::DB_FILE)) {
      file_put_contents(Database::DB_FILE, "[]");
    }
  }

  /**
   * decode database.json and set data field
   */
  private function readData(): void
  {
    $this->data = json_decode(file_get_contents(Database::DB_FILE), true);
  }

  /**
   * reset database.json with data field value
   */
  private function putData(): void
  {
    file_put_contents(Database::DB_FILE, json_encode($this->data));
  }

  /**
   * @throws Exception if recipe not found
   */
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

  /**
   * filter recipes by tag
   */
  public function getRecipesByTag(string $tag)
  {
    $this->readData();

    return array_filter($this->data, function ($recipe) use ($tag) {
      return $recipe["tag"] === $tag;
    });
  }

  /**
   * return $count values with offset of $offset from $data
   * @param int|null $count if null return all values
   */
  public function paginateData(array $data, int $offset, int $count = null): array
  {
    $copy = $data;
    array_splice($copy, 0, $offset);

    return array_splice($copy, 0, is_null($count) ? count($copy) : $count);
  }

  /**
   * create recipe, push to data field and return
   */
  public function createRecipe(array $data): Recipe
  {
    $recipe = new Recipe($data, true);

    array_push($this->data, $recipe);
    $this->putData();

    return $recipe;
  }

  /**
   * update recipe, update it in data field and return updated
   */
  public function updateRecipe(string $id, array $data): Recipe
  {
    $recipe = $this->getRecipeById($id);

    $data["id"] = $recipe->id;
    $recipe->set($data);

    for ($i = 0; $i < count($this->data); $i += 1) {
      if ($this->data[$i]["id"] == $id) {
        $this->data[$i] = $recipe;
      }
    }

    $this->putData();

    return $recipe;
  }
}

<!DOCTYPE html>
<html lang="en">

<?php

require_once __DIR__ . "/../common/Router/urlBuilder.php";

use function App\urlBuilder;

require_once __DIR__ . '/components/head.php';
?>

<title><?= ucfirst($tag) ?> recipes</title>
<link rel="stylesheet" href="<?= urlBuilder($GLOBALS["PREFIX"], "public/styles/recipes-page.css") ?>">
</head>

<body>
  <?php require_once __DIR__ . "/components/header.php"; ?>
  <main>
    <h1><?= ucfirst($tag) ?> recipes</h1>
    <nav class="body-nav tags">
      <p>Tags:</p>
      <ul>
        <li><a href="<?= urlBuilder($GLOBALS["PREFIX"], "recipes/catalog/all") ?>">All</a></li>
        <li><a href="<?= urlBuilder($GLOBALS["PREFIX"], "recipes/catalog/pizza") ?>">Pizza</a></li>
        <li><a href="<?= urlBuilder($GLOBALS["PREFIX"], "recipes/catalog/pasta") ?>">Pasta</a></li>
        <li><a href="<?= urlBuilder($GLOBALS["PREFIX"], "recipes/catalog/meat") ?>">Meat</a></li>
        <li><a href="<?= urlBuilder($GLOBALS["PREFIX"], "recipes/catalog/soup") ?>">Soup</a></li>
        <li><a href="<?= urlBuilder($GLOBALS["PREFIX"], "recipes/catalog/dessert") ?>">Dessert</a></li>
      </ul>
    </nav>
    <nav class="body-nav pages">
      <p>Pages:</p>
      <ul>
        <?php for ($i = 1; $i <= $pagesCount; $i += 1) : ?>
          <li><a href="<?= urlBuilder($GLOBALS["PREFIX"], "recipes/catalog/{$tag}/pages/{$i}") ?>"><?= $i ?></a></li>
        <?php endfor ?>
      </ul>
    </nav>
    <section class="recipes">
      <?php foreach ($recipes as $recipe) : ?>
        <article class="recipe">
          <a href="<?= urlBuilder($GLOBALS["PREFIX"], "recipes/{$recipe["id"]}") ?>"></a>
          <div class="wrapper">
            <h2><?= $recipe["name"] ?></h2>
            <p><?= $recipe["description"] ?></p>
          </div>
        </article>
      <?php endforeach ?>
    </section>
  </main>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<?php

require_once __DIR__ . "/../common/Router/urlBuilder.php";

use function App\urlBuilder;

require_once __DIR__ . '/components/head.php';
?>

<title><?= ucfirst($operation) ?> recipe</title>

<link rel="stylesheet" href="<?= urlBuilder($GLOBALS["PREFIX"], "public/styles/operate-recipe-page.css") ?>">
<link rel="stylesheet" href="<?= urlBuilder($GLOBALS["PREFIX"], "public/styles/form-component.css") ?>">
</head>

<body>
  <?php require_once __DIR__ . "/components/header.php"; ?>
  <script>
    console.log(<?= json_encode($recipe) ?>)
  </script>
  <main>
    <section>
      <form id="recipe">
        <input type="hidden" id="prefix" name="prefix" value="<?= $GLOBALS["PREFIX"] ?>">
        <input type="hidden" id="operation" name="operation" value="<?= $operation ?>">
        <input type="hidden" id="id" name="id" value="<?= $recipe->id ?? "none" ?>">

        <label for="name">Enter recipe name:</label>
        <input type="text" id="name" name="name" value="<?= $recipe->name ?>">

        <label for="description">Enter recipe description:</label>
        <textarea name="description" id="description" cols="30" rows="10"><?= $recipe->description ?></textarea>

        <label for="source">Enter recipe source link:</label>
        <input type="url" id="source" name="source" value="<?= $recipe->source ?>">

        <label for="previewImage">Enter recipe preview image link:</label>
        <input type="url" id="previewImage" name="previewImage" value="<?= $recipe->previewImage ?>">

        <label for="tag">Enter recipe tag:</label>
        <input type="text" id="tag" name="tag" value="<?= $recipe->tag ?>">

        <label for="content">Enter recipe content:</label>
        <textarea name="content" id="content" cols="30" rows="10"><?= htmlspecialchars_decode($recipe->content) ?></textarea>

        <input type="submit" value="Submit">
        <p id="errorField"></p>
      </form>
    </section>
  </main>
  <script type="module" src="<?= urlBuilder($GLOBALS["PREFIX"], "public/scripts/operate-recipe-page.js") ?>"></script>
</body>

</html>
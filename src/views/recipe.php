<!DOCTYPE html>
<html lang="en">

<?php

require_once __DIR__ . "/../common/Router/urlBuilder.php";

use function App\urlBuilder;

require_once __DIR__ . '/components/head.php';
?>

<title><?= htmlspecialchars($recipe->name) ?></title>
<link rel="stylesheet" href="<?= urlBuilder($GLOBALS["PREFIX"], "public/styles/recipe-page.css") ?>">
</head>

<body>
  <?php require_once __DIR__ . "/components/header.php"; ?>
  <main>
    <section class="preview">
      <div class="preview__text">
        <div class="preview__text_wrapper">
          <h1><?= htmlspecialchars($recipe->name) ?></h1>
          <p><?= htmlspecialchars($recipe->description) ?></p>
        </div>
      </div>
      <div class="preview__image"><img src="<?= htmlspecialchars($recipe->previewImage) ?>" alt="Recipe preview image"></div>
    </section>
    <section class="recipe">
      <a href="<?= htmlspecialchars($recipe->source) ?>">Original recipe</a>
      <?= $recipe->content ?>
    </section>
  </main>
</body>

</html>
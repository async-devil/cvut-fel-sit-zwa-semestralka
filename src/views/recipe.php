<?php require_once __DIR__ . '/components/header.php'; ?>
<h1><?= $recipe->name ?></h1>
<?php
foreach ($recipe->sections as $section) {
  echo "<section>";
  echo "<h2>{$section["name"]}</h2>";
  echo $section["content"];
  echo "</section>";
}
?>
<?php require_once __DIR__ . '/components/footer.php'; ?>
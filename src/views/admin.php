<!DOCTYPE html>
<html lang="en">

<?php

require_once __DIR__ . "/../common/Router/urlBuilder.php";

use function App\urlBuilder;

require_once __DIR__ . '/components/head.php';
?>

<title>Admin page</title>
<link rel="stylesheet" href="<?= urlBuilder($GLOBALS["PREFIX"], "public/styles/admin-page.css") ?>">
</head>

<body>
  <?php require_once __DIR__ . "/components/header.php"; ?>
  <main>
    <section>
      <div class="panel">
        <a href="<?= urlBuilder($GLOBALS["PREFIX"], "admin/recipes/new") ?>">Create new recipe</a>
      </div>
      <div class="panel">
        <form action="<?= urlBuilder($GLOBALS["PREFIX"], "admin/upload-file") ?>" method="post" enctype="multipart/form-data">
          <label for="file">Select file to upload:</label>
          <input type="file" name="file" id="file" required>
          <input type="submit" value="Upload file" name="submit">
        </form>
      </div>
    </section>
  </main>
</body>

</html>
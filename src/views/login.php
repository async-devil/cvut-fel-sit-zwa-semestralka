<!DOCTYPE html>
<html lang="en">

<?php

require_once __DIR__ . "/../common/Router/urlBuilder.php";

use function App\urlBuilder;

require_once __DIR__ . '/components/head.php';
?>

<title>Login</title>

<link rel="stylesheet" href="<?= urlBuilder($GLOBALS["PREFIX"], "public/styles/entry-page.css") ?>">
<link rel="stylesheet" href="<?= urlBuilder($GLOBALS["PREFIX"], "public/styles/form-component.css") ?>">
</head>

<body>
  <?php require_once __DIR__ . "/components/header.php"; ?>
  <main>
    <section>
      <h1>Login to admin dashboard</h1>
      <form id="login">
        <input type="hidden" id="prefix" name="prefix" value="<?= $GLOBALS["PREFIX"] ?>">
        <label for="password">Enter your password:</label>
        <input type="password" id="password" name="password" placeholder="Required" required>
        <input type="submit" value="Submit">
        <p id="errorField"></p>
      </form>
    </section>
  </main>
  <script type="module" src="<?= urlBuilder($GLOBALS["PREFIX"], "public/scripts/login-page.js") ?>"></script>
</body>

</html>
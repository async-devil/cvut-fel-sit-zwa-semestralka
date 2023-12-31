<!DOCTYPE html>
<html lang="en">

<?php

require_once __DIR__ . "/../common/Router/urlBuilder.php";

use function App\urlBuilder;

require_once __DIR__ . '/components/head.php';
?>

<title>Register</title>

<link rel="stylesheet" href="<?= urlBuilder($GLOBALS["PREFIX"], "public/styles/entry-page.css") ?>">
<link rel="stylesheet" href="<?= urlBuilder($GLOBALS["PREFIX"], "public/styles/form-component.css") ?>">
</head>

<body>
  <?php require_once __DIR__ . "/components/header.php"; ?>
  <main>
    <section>
      <h1>Register to admin dashboard</h1>
      <form id="register">
        <input type="hidden" id="prefix" name="prefix" value="<?= $GLOBALS["PREFIX"] ?>">
        <label for="password">Enter new password:</label>
        <input type="password" id="password" name="password" placeholder="Required" required>
        <label for="password2">Repeat new password:</label>
        <input type="password" id="password2" name="password2" placeholder="Required" required>
        <input type="submit" value="Submit">
        <p id="errorField"></p>
      </form>
    </section>
  </main>
  <script type="module" src="<?= urlBuilder($GLOBALS["PREFIX"], "public/scripts/register-page.js") ?>"></script>
</body>

</html>
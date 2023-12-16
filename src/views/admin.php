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
    Admin
  </main>
</body>

</html>
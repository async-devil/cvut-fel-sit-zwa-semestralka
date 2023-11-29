<?php
require_once __DIR__ . "/../../common/Router/urlBuilder.php";

use function App\urlBuilder;
?>

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="index" />
  <meta property="og:type" content="website" />
  <link rel="icon" type="image/png" sizes="32x32" href="<?= urlBuilder($GLOBALS["PREFIX"], "public/assets/favicon/favicon-32x32.png") ?>" />
  <link rel="icon" type="image/png" sizes="16x16" href="<?= urlBuilder($GLOBALS["PREFIX"], "public/assets/favicon/favicon-16x16.png") ?>" />
  <link rel="icon" type="image/x-icon" href="<?= urlBuilder($GLOBALS["PREFIX"], "public/assets/favicon/favicon.ico") ?>">

  <link rel="stylesheet" href="<?= urlBuilder($GLOBALS["PREFIX"], "public/styles/normalize.css") ?>">
  <link rel="stylesheet" href="<?= urlBuilder($GLOBALS["PREFIX"], "public/styles/index.css") ?>">
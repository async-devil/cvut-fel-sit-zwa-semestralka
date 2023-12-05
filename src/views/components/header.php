<?php
require_once __DIR__ . "/../../common/Router/urlBuilder.php";

use function App\urlBuilder;
?>
<header>
  <div class="wrapper">
    <div class="logo">
      <b>ZWA</b> Recipes
    </div>
    <nav>
      <ul>
        <li><a href="<?= urlBuilder($GLOBALS["PREFIX"], "recipes/catalog/all") ?>">Recipes</a></li>
        <li><a href="<?= urlBuilder($GLOBALS["PREFIX"], "admin") ?>">Admin</a></li>
      </ul>
    </nav>
  </div>
</header>
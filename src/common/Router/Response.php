<?php

declare(strict_types=1);

namespace App;

use Exception;

class Response
{
  private string $viewsDir = __DIR__ . "/../../views";

  /**
   * @param string $name page name
   * @return string page path
   */
  public function getPage(string $name): string
  {
    return $this->viewsDir . '/' . $name . '.php';
  }

  /**
   * include selected page pass parameters to it
   * @param string $name page name
   * @param array $exportParameters parameters, that will be passed to rendered page
   */
  public function renderPage(string $name, array $exportParameters = array()): void
  {
    $pageToRender = $this->getPage($name);

    if (empty($pageToRender)) throw new Exception("Page not found");

    ob_start();

    extract($exportParameters, EXTR_SKIP);
    include $pageToRender;

    echo ob_get_clean();
  }
}

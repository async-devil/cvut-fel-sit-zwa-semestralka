<?php

declare(strict_types=1);

namespace Invoice;

class Response
{
  private string $page;

  public function __construct(private readonly string $templateDir)
  {
  }

  public function page(string $name): void
  {
    $this->page = $this->templateDir . '/' . $name . '.php';
  }

  public function render(): void
  {
    if (empty($this->page)) {
      return;
    }
    ob_start();
    include $this->page;
    $output = ob_get_clean();
    echo $output;
  }
}

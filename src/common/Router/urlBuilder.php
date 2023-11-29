<?php

declare(strict_types=1);

namespace App;

function urlBuilder(...$paths): string
{
  return "/" . join("/", array_filter($paths, function ($path) {
    return $path != "";
  }));
}

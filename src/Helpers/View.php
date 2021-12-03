<?php

namespace App\Helpers;

class View
{
  /**
   * Render a view file
   *
   * @param string $view The view file
   * @param array $args Associative array of data to display in the view (optional)
   * @param string $pageTitle The Title of the Page (optional)
   *
   * @return void
   */
  public static function render($view, $args = [], $pageTitle = 'Page')
  {
    extract($args, EXTR_SKIP);
    $pageTitle = $pageTitle;

    $file = __DIR__ . "/../Views/$view.php";

    if (is_readable($file)) {
      require $file;
    } else {
      throw new \Exception("$file not found");
    }
  }
}

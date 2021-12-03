<?php

namespace App\Controllers;

use App\Helpers\View;
use App\Services\MALService;

class IndexController
{
  private $MALService;

  public function __construct()
  {
    $this->MALService = new MALService();
  }

  public function index()
  {
    $args['data'] = $this->MALService->getCurrentAnimeSeason();
    // header('Content-Type: application/json');
    // echo json_encode($args['data'], JSON_PRETTY_PRINT);
    // die();
    return View::render('index', $args);
  }

  public function notFound()
  {
    return View::render('404');
  }

}

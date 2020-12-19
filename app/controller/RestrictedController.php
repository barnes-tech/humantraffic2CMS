<?php

namespace App\Controller;
use Core\Controller;

class RestrictedController extends Controller {
    public function __construct($control_name, $action_name) {
    parent::__construct($control_name, $action_name);
  }

  public function index_action() {
    $this->view->render('restricted/index');
  }

  public function broken_action() {
    $this->view->render('restricted/broken');
  }
}

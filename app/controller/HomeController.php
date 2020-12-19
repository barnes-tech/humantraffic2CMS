<?php

namespace App\Controller;
use Core\Controller;
use Core\Router;
use App\model\Users;


class HomeController extends Controller {
  public function __construct($control_name, $action_name) {
    parent::__construct($control_name, $action_name);
  }
// call index action on home page visit
  public function index_action(){
    $this->view->set_layout('default');
    $this->view->render('home/index');
  }

  public function ajax_test_action() {
    $resp = ['success'=>true,'data'=>['id'=>13,'first_name'=>'Sean','last_name'=>'Barnes']];
    $this->json_response($resp);
  }
}

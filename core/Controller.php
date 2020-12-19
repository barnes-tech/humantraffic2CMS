<?php

namespace Core;
use Core\Application;
use Core\Input;
use Core\View;

  class Controller extends Application {
    protected $_controller, $_action;
    public $view, $request;

    public function __construct($control_name, $action_name) {
      parent::__construct();
      $this->_controller = $control_name;
      $this->_action = $action_name;
      $this->request = new Input();
      $this->view = new View();
      $this->on_construct();
    }

    public function on_construct() {

    }

    protected function load_model($model) {
      $model_path = 'App\Model\\'.$model;
      if(class_exists($model_path)) {
        $this->{$model.'Model'} = new $model_path();
      }
    }

    public function json_response($response) {
      header("Access-Control-Allow-Origin: * ");
      header("Content-Type: application/json; charset=UTF-8");
      http_response_code(200);
      echo json_encode($response);
      exit;
    }
  }

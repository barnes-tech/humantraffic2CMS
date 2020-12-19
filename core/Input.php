<?php

namespace Core;
use Core\Tools;
use Core\FormHelpers;
use Core\Router;

class Input {

  public function is_post() {
    return $this->get_request_method() === 'POST';
  }

  public function is_put() {
    return $this->get_request_method() === 'PUT';
  }

  public function is_get() {
    return $this->get_request_method() === 'GET';
  }

  public function get_request_method() {
    return strtoupper($_SERVER['REQUEST_METHOD']);
  }
  //function to return sanitized inputs
  public function get($input=false) {
    if(!$input) {
      //return entire request array and santize
      $data = [];
      foreach($_REQUEST as $field => $value) {
        $data[$field] = Tools::sanitize($value);
      }
      return $data;
    }
    return (array_key_exists($input, $_REQUEST))? trim(Tools::sanitize($_REQUEST[$input])) : '';
  }

  public function csrf_check() {
    if(!FormHelpers::check_token($this->get('csrf_token'))) Router::redirect('restricted/broken');
    return true;
  }
}

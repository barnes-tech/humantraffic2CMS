<?php

namespace Core\validators;
use Core\validators\CustomValidator;

class HttpsValidator extends CustomValidator {

  public function run_validation() {
    $https_check = $this->_model->{$this->field};
    $pass = true;
    if(!empty($https_check)) {
      if(!preg_match('/https?:\/\//', $https_check)) {
        $pass = false;
      }
    }
    return $pass;
  }
}

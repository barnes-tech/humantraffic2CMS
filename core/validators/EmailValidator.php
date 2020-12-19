<?php

namespace Core\validators;
use Core\validators\CustomValidator;

class EmailValidator extends CustomValidator {
  public function run_validation() {
    $email = $this->_model->{$this->field};
    $pass = true;
    if(!empty($email)) {
      $pass = filter_var($email,FILTER_VALIDATE_EMAIL);
    }
    return $pass;
  }
}

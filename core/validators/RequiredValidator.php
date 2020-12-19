<?php

namespace Core\validators;
use Core\validators\CustomValidator;

class RequiredValidator extends CustomValidator {
  public function run_validation() {
    $value = $this->_model->{$this->field};
    $pass = (!empty($value));
    return $pass;
  }
}

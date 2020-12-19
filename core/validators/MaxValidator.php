<?php

namespace Core\validators;
use Core\validators\CustomValidator;
use Core\Tools;

class MaxValidator extends CustomValidator {

  public function run_validation(){
    $value = $this->_model->{$this->field};
    $pass = (strlen($value) <= $this->rule);
    return $pass;
  }

}

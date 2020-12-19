<?php

namespace Core\validators;
use Core\validators\CustomValidator;

class MatchesValidator extends CustomValidator {

  public function run_validation() {
    $value = $this->_model->{$this->field};
    return $value == $this->rule;
  }

}

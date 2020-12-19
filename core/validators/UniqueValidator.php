<?php

namespace Core\validators;
use Core\validators\CustomValidator;
use Core\Tools;

class UniqueValidator extends CustomValidator {

  public function run_validation() {
    $field = (is_array($this->field)) ? $this->field[0] : $this->field;
    $value = $this->_model->{$field};


    if($value ==''|| !isset($value)) {
      return true;
    }

    $conditions = ["{$field} = ?"];
    $bind = [$value];

    //check record
    if(!empty($this->_model->id)) {
      $conditions[] = "id != ?";
      $bind[] = $this->_model->id;
    }
    //check mulitple records
    if(is_array($this->field)) {
      Tools::dnd($value);
      array_unshift($this->field);
      foreach($this->field as $adds) {
        $condititons[] = "{$adds} = ?";
        $bind[] = $this->_model->{$adds};
      }
    }
    $query_params = ['conditions'=>$conditions,'bind'=>$bind];
    $other = $this->_model->find_first($query_params);
    return (!$other);
  }
}

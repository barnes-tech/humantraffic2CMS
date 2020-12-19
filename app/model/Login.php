<?php

namespace App\Model;
use Core\Model;
use Core\Validators\RequiredValidator;

class Login extends Model {
  public $username, $password, $remember_me;

  public function __construct() {
    parent::__construct('tmp_fake');
  }

  public function validator() {
    $this->run_validation(new RequiredValidator($this,['field'=>'username','msg'=>'Username is required']));
    $this->run_validation(new RequiredValidator($this,['field'=>'password','msg'=>'Password is required']));
  }

  public function get_remember_me_checked() {
    return $this->remember_me == 'on';
  }
}

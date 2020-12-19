<?php

namespace Core;

class Application {
  public function __construct() {
    $this->_set_reporting();
    $this->_unregister_globals();
  }

  private function _set_reporting() {
    //'Debug' declared in config.php
    //if set to true in config report and dispaly all errors else log erros in errors.log file
    if(DEBUG) {
      error_reporting(E_ALL);
      ini_set('display_errors', 1);
    } else {
      error_reporting(0);
      ini_set('display_errors', 0)  ;
      ini_set('log_errors', 1);
      ini_set('error_log', ROOT . DS . 'tmp' . DS . 'logs' . DS . 'errors.log');
    }
  }

  private function _unregister_globals() {
    if(ini_get('register_globals')){
      $globals_array = ['_SESSION','_COOKIE','_POST','_GET','_REQUEST','_SERVER','_ENV','_FILES'];
      foreach($globals_array as $g) {
        foreach($GLOBALS[$g] as $key => $v) {
          if($GLOBALS[$key] === $v) {
            unset($GLOBALS[$key]);
          }
        }
      }
    }
  }
}

<?php

use Core\Session;
use Core\Cookie;
use Core\Router;
use Core\Tools;
use App\Model\Users;
  /*
  define directroy seperator
  root defined by dirname magic constant file
  */
  define('DS',DIRECTORY_SEPARATOR);
  define('ROOT',dirname(__FILE__));
  /*
  autoload classes
  */
  require_once(ROOT.DS.'config'.DS.'config.php');

  //Autoload classes
  function autoload($class_name) {
    $class_array = explode('\\',$class_name);
    $class = array_pop($class_array);
    $sub_path = strtolower(implode(DS,$class_array));
    $path = ROOT.DS.$sub_path.DS.$class.'.php';
    if(file_exists($path)) {
      require_once($path);
    }
  }

  spl_autoload_register('autoload');
  /*
  enable session variable
  */
  session_start();
  /*
  if path info is set store in array else create empty array
  */
  $url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : [];

  if(!Session::exists(CURRENT_USER_SESSION_NAME) && Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
    Users::user_login_cookie();
  }




  Router::route($url);

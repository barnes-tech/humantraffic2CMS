<?php

namespace Core;
use Core\Session;
use App\Model\Users;
use Core\Tools;


class Router {

  public static function route($url){

    //controller - check index 0 of url array for controller and then shift the first valye out of the url array
    $controller = (isset($url[0]) && $url[0] != '')? ucwords($url[0]).'Controller':DEFAULT_CONTROLLER.'Controller';
    $control_name = str_replace('Controller','',$controller);
    array_shift($url);
    //action -
    $action = (isset($url[0]) && $url[0] != '')? $url[0] . '_action' : 'index_action';
    $action_name = (isset($url[0]) && $url[0] != '')? $url[0] . '_action' : 'index_action';
    array_shift($url);

    //check permissions
    $grant_access = self::has_access($control_name, $action_name);



    if(!$grant_access) {
      $controller = ACCESS_RESTRICTED.'Controller';
      $control_name = ACCESS_RESTRICTED;
      $action_name = 'index_action';
    }

    //parameters that we can pass to our methods at end of url
    $query_params = $url;
    $controller = 'App\Controller\\'.$controller;
    $dispatch = new $controller($control_name, $action_name);

    if(method_exists($controller, $action_name)){
      //calls the declared controller and acxtion (dispatch) and passes it the query parameters
      call_user_func_array([$dispatch, $action_name], $query_params);
    } else {
      die('The method "' . $action_name . '" does not exist in the '.$control_name.' controller.');
    }
  }

  public static function redirect($location) {
    if(!headers_sent()){
      header('Location: '.SROOT.$location);
      exit();
    } else {
      echo '<script type="text/javascript>"';
      echo 'window.location.href="'.SROOT.$location.'";';
      echo '</script>';
      echo '<noscript>';
      echo '<meta http-ueqiv="refresh" content="0;url='.$location.'"/>';
      echo '</noscript>';
      exit;
    }
  }

  public static function has_access($control_name, $action_name='index') {

    //get acl file from server directory
    $acl_file = file_get_contents(ROOT.DS.'app'.DS.'acl.json');
    //decode json file to php array
    $acl = json_decode($acl_file, true);
    $current_user_acls= ["Guest"];
    $grant_access = false;



    if(Session::exists(CURRENT_USER_SESSION_NAME)) {
      $current_user_acls = ["LoggedIn"];
      foreach(Users::current_user()->acls() as $a) {
        //add acls from user objectecho  to array for use in program
        $current_user_acls[] = $a;
      }
    }
    foreach($current_user_acls as $level) {

        if(array_key_exists($level, $acl) && array_key_exists($control_name, $acl[$level])) {
          $action = Tools::get_action($action_name);
          if(in_array($action, $acl[$level][$control_name]) || in_array("*", $acl[$level][$control_name])){
              $grant_access = true;
              break;
        }
      }
    }

    foreach($current_user_acls as $level) {
      $denied = $acl[$level]["denied"];
      $action = Tools::get_action($action_name);
      if(!empty($denied) && array_key_exists($control_name, $denied) && in_array($action_name, $denied[$control_name])){
        $grant_access = false;
        break;
      }
    }
    return $grant_access;
  }

  public static function get_menu($menu) {
    $menu_array = [];
    $menu_file = file_get_contents(ROOT.DS.'app'.DS.$menu.'.json');
    $menu_json = json_decode($menu_file, true);
    foreach($menu_json as $key => $val) {

      if(is_array($val)) {

        $sub = [];
        foreach($val as $k => $v) {
          if($k == 'seperator' && !empty($sub)) {
            $sub[$k] = '';
            continue;
          } else if($final_val = self::get_link($v)) {
            $sub[$k] = $final_val;
          }
        }
        if(!empty($sub)) {
          $menu_array[$key] = $sub;
        }
      } else {
        if($final_val = self::get_link($val)) {
          $menu_array[$key] = $final_val;
        }
      }
    }
    return $menu_array;
  }

  private static function get_link($val) {
    //check for external link
    if(preg_match('/https?:\/\//', $val) == 1) {
      return $val;
    } else {
      $url_array = explode('/' ,$val);
      $control_name = ucwords($url_array[0]);
      $action_name = (isset($url_array[1])) ? $url_array[1]:'';
      if(self::has_access($control_name, $action_name)) {
        return SROOT.$val;
      }
      return false;
    }
  }
}

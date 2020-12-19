<?php

namespace Core;
use App\Model\Users;

class Tools {

  public static function dnd($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
  }
//escape special characters
  public static function sanitize($dirty) {
    return htmlentities($dirty, ENT_QUOTES, 'UTF-8');
  }



  public static function get_action($action_name) {
    $a = explode('_',$action_name);
    $action = $a[0];
    return $action;
  }

  public static function current_page() {
    $current_page = $_SERVER['REQUEST_URI'];
    if($current_page == SROOT || $current_page == SROOT.'home/index'){
      $current_page = SROOT.'home';
    }
    return $current_page;
  }

public static function external_link($value) {
  //check for external link
  if(preg_match('/https?:\/\//', $value) == 1) {
    return $value;
  } else {
    return false;
  }
}

public static function get_object_props($obj) {
  return get_object_vars($obj);
}

public static function build_menu_list($menu,$dropdown_class="") {
  ob_start();
  $current_page = self::current_page();
  foreach($menu as $key => $value) :
    $active = '';
    if($key == '%USERNAME%'){
      $key = (Users::current_user())?"Hello ".Users::current_user()->fname : $key;
    }
    if(is_array($value)): ?>
    <li class="nav-item dropdown">
      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=$key?></a>
      <div class="dropdown-menu <?=$dropdown_class?>">
        <?php foreach($value as $k => $v):
          $active = ($v == $current_page)? 'active' : ''; ?>
          <?php if(substr($k,0,9)=='separator'): ?>
            <div role="separator" class="dropdown-divider"></div>
          <?php else: ?>
            <a class="dropdown-item <?=$active?>" href="<?=$v?>"><?=$k?></a>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </li>
    <?php else:
      $active = ($value == $current_page)? 'active' : ''; ?>
      <li class="nav-item"><a class="nav-link <?=$active?>" href="<?=$value?>"><?=$key?></a></li>
    <?php endif; ?>
    <?php endforeach;
    return ob_get_clean();
  }

}

<?php

  use Core\Tools;
  use Core\Router;
  use App\Model\Users;

  //call get menu functon in Router to decode acl_menu_json
  $menu = Router::get_menu('admin_acl');
  $user_menu = Router::get_menu('user_menu');
?>
<nav class="navbar navbar-expand-lg navbar-dark navbar-rogue">
  <a class="navbar-brand" href="#">Dashboard</a>
  <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#main_menu" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="main_menu">
    <ul class="navbar-nav mr-auto">
      <?=Tools::build_menu_list($menu);?>
    </ul>
    <ul clas="navbar-nav mr-2">
      <?=Tools::build_menu_list($user_menu,"dropdown-menu-right");?>
    </ul>
  </div>
</nav>

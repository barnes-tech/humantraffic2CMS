<?php
  use Core\FormHelpers;
  //html for regiser/login form rendered in view through default view upon request, see content public function
  $this->start('head');
  ?>
<?php
  $this->end();
  $this->start('body');
?>

   <form class="form" action="<?=SROOT?>register/login" method="post">
      <?=FormHelpers::csrf_input()?>
      <?=FormHelpers::display_errors($this->display_errors);?>
      <?=FormHelpers::input_block('text','Username:','username',$this->loginModel->username,['class'=>'flex-item m-2'],['class'=>'row justify-content-end loginForm'])?>
      <?=FormHelpers::input_block('password','Password:','password',$this->loginModel->password,['class'=>'flex-item m-2'],['class'=>'row justify-content-end loginForm'])?>
      <?=FormHelpers::checkbox_block('Remember me:','remember_me', $this->loginModel->get_remember_me_checked(),['class'=>'flex-item m-2'],['class'=>'row justify-content-center loginForm'])?>
        <?=FormHelpers::submit_block('Login',['class'=>'form-control'],['class'=>'form-group form-inline'])?>

    </form>


<?php $this->end(); ?>

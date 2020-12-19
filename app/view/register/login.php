<?php
  use Core\FormHelpers;
  //html for regiser/login form rendered in view through default view upon request, see content public function
  $this->start('head');
  ?>
<?php
  $this->end();
  $this->start('body');
?>

<section class="row h-450">
  <article class="col-lg-4 offset-md-4 sb-form mx-auto">
    <form class="form" action="<?=SROOT?>register/login" method="post">
      <?=FormHelpers::csrf_input()?>
      <?=FormHelpers::display_errors($this->display_errors);?>
      <h3>Welcome to</h3>
      <h4><span class="impact">Strawberry&nbsp;</span>Bubblegum</h4>
      <h6>Lightweight Dynamic Web-framework</h6>
      <p>Don't have an account? Click <a href="<?=SROOT?>register/register" class="txt-link">here</a> to sign up.</p>
      <?=FormHelpers::input_block('text','Username','username',$this->loginModel->username,['class'=>'form-control'],['class'=>'form-group'])?>
      <?=FormHelpers::input_block('password','Password','password','',['class'=>'form-control'],['class'=>'form-group'])?>
      <?=FormHelpers::checkbox_block('Remember me:','remember_me', $this->loginModel->get_remember_me_checked(),['class'=>'form-control'],['form-group'])?>
      <?=FormHelpers::submit_block('Login',['class'=>'form-control'],['class'=>'form-group'])?>
    </form>
  </article>
</section>
<?php $this->end(); ?>

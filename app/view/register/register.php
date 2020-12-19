<?php
  use Core\FormHelpers;

  $this->start('head');
?>
<?php
  $this->end();
  $this->start('body');
?>
  <section class"row h-450">
    <article class="col-lg-4 offset-md-4 sb-form mx-auto">
      <form class="form" action="" method="post">
        <?=FormHelpers::csrf_input()?>
        <h4><span class="impact">Account&nbsp;</span>Creation</h4>
        <?= FormHelpers::display_errors($this->display_errors)?>
        <?= FormHelpers::input_block('text','First name','fname',$this->new_user->fname,['class'=>'form-control input-sm'],['class'=>'form-group'])?>
        <?= FormHelpers::input_block('text','Last name','lname',$this->new_user->lname,['class'=>'form-control input-sm'],['class'=>'form-group'])?>
        <?= FormHelpers::input_block('text','Username','username',$this->new_user->username,['class'=>'form-control input-sm'],['class'=>'form-group'])?>
        <?= FormHelpers::input_block('text','Email address','email',$this->new_user->email,['class'=>'form-control input-sm'],['class'=>'form-group'])?>
        <?= FormHelpers::input_block('password','Password','password',$this->new_user->password,['class'=>'form-control input-sm'],['class'=>'form-group'])?>
        <?= FormHelpers::input_block('password','Confirm password','password_match',$this->new_user->confirm,['class'=>'form-control input-sm'],['class'=>'form-group'])?>
        <?= FormHelpers::submit_block('Register',['class'=>'btn btn-primary'],['class'=>'text-right'])?>
      </form>
    </article>
  </section>
<?php $this->end();?>

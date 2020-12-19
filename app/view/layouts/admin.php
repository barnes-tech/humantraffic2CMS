<?php

  use Core\Session;

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X_UA_Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$this->sitle();?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    <link rel="stylesheet" href="<?=SROOT?>css/main.css">
    <link rel="stylesheet" href="<?=SROOT?>css/alertMsg.css">
    <script src="<?=SROOT?>js/jQuery-3.3.1.min.js"></script>
    <script src="<?=SROOT?>js/alertMsg.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js" integrity="sha256-0YPKAwZP7Mp3ALMRVB2i8GXeEndvCq3eSl/WsAl1Ryk=" crossorigin="anonymous"></script>
    <script src="https://cdn.tiny.cloud/1/a0xjfh1t6ocz9hr6hyzhvuxy5u4jft3f2q41j204jfei00qd/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <?=$this->content('head');?>
  </head>
  <body>
    <?php include 'admin_menu.php' ?>
    <div class="container-fluid frame">
      <div class="col-lg-10 offset-lg-1">
        <?= Session::session_msgs()?>
      </div>
    <?=$this->content('body')?>
  </div>
  </body>
</html>

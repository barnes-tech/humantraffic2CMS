<?php
  use Core\Session;
 ?>
 <!doctype html>
 <html lang="en">
   <head>
     <title><?=$this->sitle();?></title>
     <link rel="stylesheet" href="<?=SROOT?>css/bootstrap.min.css" type="text/css">
     <link rel="stylesheet" href="<?=SROOT?>css/humanTraffic.css" type="text/css">
     <link rel="stylesheet" href="<?=SROOT?>css/main.css">
     <?=$this->content('head');?>
   </head>
   <body="container-fluid">
     <section class="row justify-content-center">
       <nav class id="trafficSign">
         <div id="signContent">
           <h1 class="text-center"><a id="trafficHead" href="home">Site Manager</a></h1>
           <div class="signDivideX"></div>
           <section id="contentFrame">
            <!--start of graphics frame-->
            <?=$this->content('body')?>
          <!--End of graphics frame-->

          <!--Get Involved section-->

          <!--Returning castsection-->


        </section>
        <div class="signDivideX"></div>
          <section class="row justify-content-around linkBox text-center">
            <a href="<?=SROOT?>home" class="signLink" onclick="getInvolved()">Back to Site</a>
            <a href="#" class="signLink" onclick="showCast()">The<br>Humans</a>
            <a href="#" class="signLink">Indie<br>GoGo</a>
          </section>
        </div>
        </nav>
      </section>
     <script src="<?=SROOT?>js/jQuery-3.3.1.min.js"></script>
     <script src="<?=SROOT?>js/alertMsg.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
   </body>
 </html>

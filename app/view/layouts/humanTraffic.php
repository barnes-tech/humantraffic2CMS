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
           <h1 class="text-center"><a id="trafficHead" href="index">Human&nbsp;&nbsp;&nbsp;Traffic<span class="sqrd">2</span></a></h1>
           <div class="signDivideX"></div>
           <section id="contentFrame">
            <!--start of graphics frame-->
            <?=$this->content('body')?>
          <!--End of graphics frame-->

          <!--Get Involved section-->
          <div id="getInvolved">
            <h1 class="text-center m-1">Become an extra</h1>
            <div class='record-container'>
              <div class='record'></div>
            </div>
            <p class="m-1">"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."</p>
          </div>
          <!--Returning castsection-->
          <div id="returningCast">
            <h1 class="text-center">Meet the Humans</h1>
            <p class="m-1">"  Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
          </div>


        </section>
        <div class="signDivideX"></div>
          <section class="row justify-content-around linkBox text-center">
            <a href="#" class="signLink" onclick="getInvolved()">Get<br>Involved</a>
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

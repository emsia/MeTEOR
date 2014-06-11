
<!DOCTYPE HTML>
<html lang = "en">
<head>
 <title><?php echo $title ?></title>
 <meta charset = "UTF-8" />
 <link rel="stylesheet" href="<?php echo base_url('css/bootstrap.css'); ?>" type="text/css">
  <script src="<?php echo base_url('js/bootstrap.js'); ?>"></script>
  <script src="<?php echo base_url('js/jquery.js'); ?>"></script>
  <script src="<?php echo base_url('js/bootstrap-carousel.js'); ?>"></script>
  <script src="<?php echo base_url('js/bootstrap-tooltip.js'); ?>"></script>
  <script>
  $(document).ready(function() 
    { 
    $('.tool').tooltip();
    } );
  </script>
</head>

<body >

<div style="height: 597px; width: 100%; background-color: #141414" id="myCarousel" class="carousel slide">
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>
  <!-- Carousel items -->
  <div class="carousel-inner">
    <div class="active item" >
       <div class="container">
         <div style="padding-top: 15px;" class="span20">
          <div class="alert" style="background-color: #141414; border: 0px">
              <h2><b style="font-family: NegotiateFree; color: white">About</b> <b style="font-family: Harabara; color: #ffe35f">m<b style="font-size: 40px; color: green;text-shadow: none">e</b>teor</b></h2>
                <p style="color: white; font-size: 15px; letter-spacing: 1px;  text-align: justify !important;">This <b style="font-family: NegotiateFree; color: #ffe35f;"><i>My eUP Training and Events On-Line Registration</i></b> handles easy track of participants who wants to enroll in different courses offered by the <b style="font-family: NegotiateFree" rel="tooltip" title="University of the Philippines Information Technology Development Center" class="tool" ><i style="color: #ffe35f">UP ITDC</i></b>.
                <br/><br/>          
          It has three(3) different kind of users namely: <i>(1) the admin, (2) the managers and (3) participants</i>. The admin checks the over all work of the system, the managers work, particularly, for validation and assessment of the participants. And lastly, the participants, who enrolled in different courses offered by the UP ITDC.
          <br/><br/>
          <b style="font-family: Harabara; font-size: 20px; color: #ffe35f">m<b style="color: green; text-shadow: none; font-size: 22px">e</b>teor</b> has been developed by Christopher Rosario, Efren Ver Sia, Maria Erika Santos and Kent Tristan Yves Sarmiento.
          On the process of developing the web application, it is supervised by our Project Manager, Rommel Feria, and it is the first project that is made by the team.
              <br/><br/>
              It is continued by Efren Ver Sia with Sheleen San Antonio and Jumira Marleth Serrano, from University of the Philippines Los Baños, for the fulfillment of their internship here at UPITDC. 
              For Participants' account, they added features such as certificate generator, email verification of accounts, and email notification through <b style="font-family:NegotiateFree; color: #ffe35f"><i>gmail</i></b>, once the details of courses they enrolled changed. For Admin account, they added reports generator exported as pdf, upload signature file for the certificates and evaluate survey form.
              </p>
            </div>
         </div>   
      </div>   
        
      <form style="padding-top: 1%" class="inline-form" ><center>
        <img rel='tooltip' title='University of the Philippines Information Technology Development Center' src="<?php echo base_url('css/images/little.png'); ?>" style="width: 150px; height: 150px;" class="img-circle tool" alt="">
        <img rel='tooltip' title='Department of Computer Science &nbsp;&nbsp;&nbsp;&nbsp;(UP Diliman)' src="<?php echo base_url('css/images/DCS.png'); ?>" style="width: 150px; height: 150px" class="img-circle tool" alt="">
        <img rel='tooltip' title='University of the Philippines' src="<?php echo base_url('css/images/UPLittle.png'); ?>" style="width: 150px; height: 150px" class="img-circle tool" alt="">
        <img rel='tooltip' title='Institute of Computer Science &nbsp;&nbsp;&nbsp;&nbsp;(UP Los Baños)' src="<?php echo base_url('css/images/UPLBCS.png'); ?>" style="width: 150px; height: 150px" class="img-circle tool" alt="">
        <img rel='tooltip' title='Efficiency. Synergy. One UP.' src="<?php echo base_url('css/images/eupLittle.png'); ?>" style="width: 150px; height: 150px" class="img-circle tool" alt="">
        </center>
      </form>
    </div>
    <div class="item">
      <div class="container">
        <ul class="team-list" style="list-style: none;"><center>
          <li class="">
              <a href="#">
                <h3 sty>Chris</h3>
                <img src="<?php echo base_url('css/images/chris.png'); ?>" style="width: 250px; height: 250px;" class="img-rounded" alt="">
              <div class="alert" style="margin: 10px; padding: 10px; width: 252px; height: 130px">
          </div>  
              </a>
            </li>
            <li class="">
              <a href="#">
                <h3 sty>Erika</h3>
                <img src="<?php echo base_url('css/images/erika2.png'); ?>" style="width: 250px; height: 250px;" class="img-rounded" alt="">
              <div class="alert" style="margin: 10px; padding: 10px; width: 252px; height: 130px">
          </div>  
              </a>
            </li>
            <li class="">
              <a href="#">
                <h3 sty>Kent</h3>
                <img src="<?php echo base_url('css/images/kent1.jpg'); ?>" style="width: 250px; height: 250px;" class="img-rounded" alt="">
                <div class="alert" style="margin: 10px; padding: 10px; width: 252px; height: 130px">
          </div>  
              </a>
            </li></center>
        </ul>
      </div>
    </div>
    <div class="item">
      <div class="container">
        <ul class="team-list" style="list-style: none; color: white; font-size: 15px; text-align: center !important;"><center>
          <li class="">
              <a href="#">
                <h3 sty>Efren</h3>
                <img src="<?php echo base_url('css/images/efren.png'); ?>" style="width: 250px; height: 250px;" class="img-rounded" alt="">
              <div class="alert" style="margin: 10px; padding: 10px; width: 252px; height: 130px">
            UPD BSCS '10<br/>
            October 29, 1992<br/>
            City of San Jose Del Monte<br/>Bulacan<br/>
            <i>Living LIFE to the MAX! :D</i><br>
                </div>  
              </a>
            </li>
            <li class="">
              <a href="#">
                <h3 sty>Shen</h3>
                <img src="<?php echo base_url('css/images/shen1.png'); ?>" style="width: 250px; height: 250px;" class="img-rounded" alt="">
                <div class="alert" style="margin: 10px; padding: 10px; width: 252px; height: 130px">
            UPLB BSCS '10<br/>
            November 20, 1993<br/>
            Antipolo City<br/>
            <i>Frustrated fashion Stylist<br>
            Used to be table tennis player</i><br/>
                </div>  
              </a>
            </li>
            <li class="">
              <a href="#">
                <h3 sty>Jums</h3>
                <img src="<?php echo base_url('css/images/jums.png'); ?>" style="width: 250px; height: 250px;" class="img-rounded" alt="">
                <div class="alert" style="margin: 10px; padding: 10px; width: 252px; height: 130px">
            UPLB BSCS '10<br/>
            January 9, 1994<br/>
            Bacoor, Cavite<br/>
            <i>Loves to sing</i><br/>
                </div>  
              </a>
            </li></center>
        </ul>
      </div>
    </div>
  </div>
  <!-- Carousel nav -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
</div
</body>
</html> 
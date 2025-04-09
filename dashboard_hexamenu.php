<?php 
      session_start();
     
      include "includes/dbconnect.php";
      include "includes/functions.php";

  ?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS</title>
    <!--<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>-->
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">  
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <style>
        .hexagrid {
            
            }

        ul {
             display: flex;
              flex-wrap: wrap;
              width: 90%;
              margin: 0 auto;
              overflow: hidden;
              font-family: sans-serif;
            list-style: none;
        }

        .hex {
          width: 20%;      
          position: relative;
          visibility:hidden;
          outline:1px solid transparent; /* fix for jagged edges in FF on hover transition */
          transition: all 0.5s;
          backface-visibility: hidden;
          will-change: transform;
          transition: all 0.5s;
        }
        .hex::after{
          content:'';
          display:block;
          padding-bottom: 86.602%;  /* =  100 / tan(60) * 1.5 */
        }

        .hexIn{
          position: absolute;
          width:96%;
          padding-bottom: 110.851%; /* =  width / sin(60) */
          margin: 2%;
          overflow: hidden;
          visibility: hidden;
          outline:1px solid transparent; /* fix for jagged edges in FF on hover transition */
          -webkit-transform: rotate3d(0,0,1,-60deg) skewY(30deg);
              -ms-transform: rotate3d(0,0,1,-60deg) skewY(30deg);
                  transform: rotate3d(0,0,1,-60deg) skewY(30deg);
            transition: all 0.5s;
        }
        .hexIn * {
          position: absolute;
          visibility: visible;
          outline:1px solid transparent; /* fix for jagged edges in FF on hover transition */
        }    

        .img {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background-position: center center;
  background-size: cover;
  overflow: hidden;
-webkit-clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
}

.img:before, .img:after {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  content: '';
  opacity: 0;
  transition: opacity 0.5s;
}
.img:before {
  background: rgba(22, 103, 137, 0.3)
}
.img:after {
  background: linear-gradient(to top, transparent, rgba(0, 0, 0, 0.5), transparent);
}

    </style>
  </head>
  
  <body>
  <?php
    echo "<script>sessionStorage.setItem('current_module','dashboard')</script>";
   include("includes/header.php") ?>
      <div class="main_wrap">
         <div class="content">
        
         <div class="dashboard_wrap">   
            <div class="dashboard">  
                <div class="dashboard_header">Chose where you want to go:</div>
                 <div class="hexagrid">
                    <ul>
                     <li class="hex">
                          <div class="hexIn">   
                           <div class='img' style='background-image:url(https://images.unsplash.com/photo-1417436026361-a033044d901f?ixlib=rb-0.3.5&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;w=1080&amp;fit=max&amp;s=faa4e192f33e0d6b7ce0e54f15140e42);'></div>
                                    Gallery
                               
                          </div>              
                                </li>
                     <li class="hex">
                          <div class="hexIn">   
                                    Gallery
                          </div>              
                                </li>
                     <li class="hex">
                          <div class="hexIn">   
                                    Gallery
                          </div>              
                                </li>
                     <li class="hex">
                          <div class="hexIn">   
                                    Gallery
                          </div>              
                                </li>
                     <li class="hex">
                          <div class="hexIn">   
                                    Gallery
                          </div>              
                                </li>
                     <li class="hex">
                          <div class="hexIn">   
                                    Gallery
                          </div>              
                                </li>
                     <li class="hex">
                          <div class="hexIn">   
                                    Gallery
                          </div>              
                                </li>
                     
                 </ul>                           
                </div><!--hexagrid--> 
              </div><!-- dashboard -->  
          </div><!--wrap-->    
          
          
        </div>
      </div>
     
  </body> 
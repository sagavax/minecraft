<?php 
      session_start();
     
      include "../includes/dbconnect.php";
      include "../includes/functions.php";
 
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS</title>
    <!--<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>-->
    <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">  
    <script type="text/javascript" defer src="../js/dashboard.js"></script>
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
  </head>
  
  <body>
  <?php include("../includes/header.php") ?>
      <div class="main_wrap">
        <div class="tab_menu">
          <?php include("../includes/vamilla_menu.php"); ?>
        </div>    
         <div class="content">
           <div class="dashboard_wrap">
              <div class="dashboard">   
                  <div class="dashboard_header">Vanilla: Chose where you want to go:</div>
                  <div class="tile_list">
                    <div class="tile" tile-id='vanilla_bases'><div class="tile_title">Bases</div><div class="tile_info"><span><?php echo GetCountBases() ?> bases, <?php echo GetCountNewestBases(); ?> the newest </span></div></div>
                    <div class="tile" tile-id='vanilla_notes'><div class="tile_title">Notes</div><div class="tile_info"><span><?php echo GetCountVanillaNotes() ?> notes, <?php echo GetCountNewestVanillaNotes(); ?> the newest </span></div></div>
                    <div class="tile" tile-id='vanilla_tasks'><div class="tile_title">Tasks</div><div class="tile_info"><span><?php echo GetCountVanillaTasks()?> tasks, <?php echo GetCountNewestVanillaTasks(); ?> the newest</span></div></div>
                    <div class="tile" tile-id='vanilla_ideas'><div class="tile_title">Ideas</div><div class="tile_info"><span><?php echo GetCountVanillaIdeas(); ?> ideas,<?php echo GetCountNewestVanillaIdeas(); ?> the newest</span></div></div>
                    <div class="tile" tile-id='vanilla_images'><div class="tile_title">Images</div>><div class="tile_info"><span><?php echo  GetCountAllBasesImages(); ?> images</span></span></div></div>
                    <div class="tile" tile-id='vanilla_videos'><div class="tile_title">Videos</div><div class="tile_info">,<?php echo GetCountVanillaVideos(); ?> videos, <?php echo GetCountNewestVanillaVideos(); ?> newest</span></div></div>
                    <div class="tile" tile-id='dashboard'><div class="tile_title">Back</div></div>
                  </div><!--tile list-->    
                <div class="clock_wrap"><span class="clock"></span></div>
              </div><!-- dashboard -->
          </div><!-- wrap -->
       </div><!--content -->
     
  </body> 
<script>

var Clock = (function(){

var exports = function(element) {
  this._element = element;
  var html = '';
  for (var i=0;i<6;i++) {
    html += '<span>&nbsp;</span>';
  }
  this._element.innerHTML = html;
  this._slots = this._element.getElementsByTagName('span');
  this._tick();
};

exports.prototype = {

  _tick:function() {
    var time = new Date();
    this._update(this._pad(time.getHours()) + this._pad(time.getMinutes()) + this._pad(time.getSeconds()));
    var self = this;
    setTimeout(function(){
      self._tick();
    },1000);
  },

  _pad:function(value) {
    return ('0' + value).slice(-2);
  },

  _update:function(timeString) {

    var i=0,l=this._slots.length,value,slot,now;
    for (;i<l;i++) {

      value = timeString.charAt(i);
      slot = this._slots[i];
      now = slot.dataset.now;

      if (!now) {
        slot.dataset.now = value;
        slot.dataset.old = value;
        continue;
      }

      if (now !== value) {
        this._flip(slot,value);
      }
    }
  },

  _flip:function(slot,value) {

    // setup new state
    slot.classList.remove('flip');
    slot.dataset.old = slot.dataset.now;
    slot.dataset.now = value;

    // force dom reflow
    slot.offsetLeft;

    // start flippin
    slot.classList.add('flip');

  }

};

return exports;
}());

var i=0,clocks = document.querySelectorAll('.clock'),l=clocks.length;
for (;i<l;i++) {
new Clock(clocks[i]);
}
</script>
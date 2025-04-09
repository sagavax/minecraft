<?php 
      session_start();
     
      include "includes/dbconnect.php";
      include "includes/functions.php";

      if(isset($_POST['add_note'])){
        header('location:note_add.php');
      }

      if(isset($_POST['add_daily_note'])){
        header('location:note_add.php?curr_date=now');
      }

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
    <script>
        function show_welcome_message(){
          setTimeout(function(){
            document.getElementsByClassName('')[0].style.visibility = 'hidden';
            //alert('hello world!');
          }, 3000);
        }
    </script>
  </head>
  
  <body>
  <?php include("includes/header.php") ?>
      <div class="main_wrap">
         <div class="content">
        
       
   <!--         <div class="list"> -->
 
            <!-- <div class="button_wrap"> 
             <form action="" method="post">
                <button name="add_modpack" type="submit" class="button small_button pull-right" title="New modpack"><i class="material-icons">note_add</i></button>
             </form>
            </div> -->
         <div class="list">   
            <div class="dashboard_header">Chose where you want to go:</div>
            <div class="action_list">
             <div class="tile"><a href="vanilla_bases.php"><span>Bases</span></a><div class="tile_info"><span><?php echo GetCountNotes() ?> notes, <?php echo GetCountNewestNotes(); ?> the newest </span></div></div>
            <div class="tile"><a href="vanilla_notes.php"><span>Notes</span></a><div class="tile_info"><span><?php echo GetCountNotes() ?> notes, <?php echo GetCountNewestNotes(); ?> the newest </span></div></div>
            <div class="tile"><a href="vanilla_tasks.php"><span>Tasks<span></a><div class="tile_info"><span><?php echo GetCountTasks()?> tasks, <?php echo GetCountNewestTasks(); ?> the newest</span></div></div>
            <div class="tile"><a href="vanilla_ideas.php"><span>Modpacks</span><div class="tile_info"><span><?php echo GetCountModpacks(); ?> modpacks, <?php echo GetCountActiveModpacks() ?> are active, <?php echo GetCountInactiveModpacks() ?> are inactive</span></div></a></div>
            <div class="tile"><a href="vanilla_images.php"><span>Videos</span></a><div class="tile_info"><span><?php echo GetCountVideos();?> videos, <?php echo GetCountNewestVideos(); ?> the newest</span></div></div>
            <div class="tile"><a href="pics.php"><span>Gallery</span></a><div class="tile_info"><span><?php echo GetCountImages(); ?> images</span></div></div>
          </div><!--list-->    
          <div class="clock_wrap">
              <span class="clock"></span>
          </div>
          
        </div>
      </div>
     
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
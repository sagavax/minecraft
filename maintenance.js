document.querySelector(".backuped_files_header button").addEventListener("click". ()=>{
  backup();
}) 

function  backup(){
   const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            alert("Backup done!")
          }
          
        xhttp.open("POST", "backup.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send();
}
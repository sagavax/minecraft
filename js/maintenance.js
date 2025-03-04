document.querySelector(".files_list").addEventListener("click", (event) => {
   if(event.target.tagName==="BUTTON" || event.target.tagName==="I"){
      const fileName = event.target.getAttribute("file-name");
      removeBackup(fileName);
      console.log("Remove backup...");
   }
});



document.querySelector(".backuped_files_header").addEventListener("click", (event) => {
   if(event.target.tagName==="BUTTON"){
       buttonName=event.target.name;
       if(buttonName==="make_backup"){
        document.querySelector(".loading-container").style.display="flex";
        console.log("Do backup...");
        backup()
        } else if(buttonName==="remove_backups"){
         document.querySelector(".loading-container").style.display="flex";
         removeAllBackups();
         document.querySelector(".loading-container").style.display="none";
         console.log("Remove backups...");
       }
   }
});

function  backup(){
   const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            document.querySelector(".loading-container").style.display="none";
            getBackupFiles();
            ShowMessage("Backup done!")
          }
          
        xhttp.open("POST", "maintenance_backup.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send();
}

function  getBackupFiles(){
   const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
              document.querySelector(".loading-container").style.display=="none";
              document.querySelector(".files_list").innerHTML = this.responseText;  

          }
        
        xhttp.open("GET", "maintenance_file_list.php",true);
        xhttp.send();
}

function  removeAllBackups(){
   const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            getBackupFiles();
            alert("Backups removed!")
          }
          
        xhttp.open("POST", "maintenance_remove_all_backups.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send();
}

function removeBackup(fileName){
     const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            getBackupFiles();
            alert("Backup removed!")
          }
          
        xhttp.open("POST", "maintenance_remove_backup.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        data = "&file_name="+encodeURIComponent(fileName);
        xhttp.send(data);
}


function restoreDatabase(fileName){
     const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            alert("Database has been restored")
          }
          
        xhttp.open("POST", "maintenance_restore_database.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        data = "&file_name="+encodeURIComponent(fileName);
        xhttp.send(data);
}
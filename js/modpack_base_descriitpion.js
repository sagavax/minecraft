function modpackBaseDescriptionUpdate(baseId, baseDescription) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         // Refresh the bases content after removal
         alert("Update successful");
      }
    };
    xhttp.open("POST", "modapck_base_description_update.php", true);
    data = "base_id="+baseId+"&base_description="+baseDescription;
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
  }

  function modpackBaseUpdateName(baseId, modpackId, baseName) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         alert("Base description updated successfully!");
        
      }
    };
    xhttp.open("POST", "modapck_base_name_update.php", true);
    data = "base_id="+baseId+"&base_name="+baseName+"&modpack_id="+modpackId;
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
  }
// Use event delegation to handle clicks on dynamically loaded content
document.addEventListener("click", function(e) {
    // Check if the click happened within a .modpack_bases element
    const modpack_bases = e.target.closest(".modpack_bases");
    if (!modpack_bases) return; // Exit if not within modpack_bases
    if (e.target.tagName === "BUTTON") {
        if(e.target.name==="modal_new_base") {
                    modal_new_base.showModal();
        } else if (e.target.name === "edit_base") {
            const baseId = parseInt(e.target.closest(".vanilla-base-card").getAttribute("base-id"));
            const modpackId = parseInt(e.target.closest(".vanilla-base-card").getAttribute("modpack-id"));
            window.location.href = "modpack_base.php?base_id=" + baseId + "&modpack_id=" + modpackId;
        } else if (e.target.name === "delete_base") {
            removeBase(e.target.getAttribute("base-id"));
        } 
    } 

    if(e.target.tagName==="DIV") {
        if(e.target.classList.contains("base_description_card")) {
            console.log("focus description");
        e.target.contentEditable = true;
        e.target.focus();
            console.log(e.target);
        }  else if (e.target.classList.contains("base_name")) {
            console.log(e.target.innerText);
        e.target.contentEditable = true;
        e.target.focus();
        }
    }
});

document.addEventListener("focusout", function(e){
     if(e.target.tagName==="DIV") {
        if(e.target.classList.contains("base_description_card")) {

            const baseId = e.target.closest(".vanilla-base-card").getAttribute("base-id");
            const modpackId = e.target.closest(".vanilla-base-card").getAttribute("modpack-id");
            const baseDescription = e.target.innerText;

            modpackBaseDescriptionUpdate(baseId, baseDescription);
            console.log("lost focus description"+e.target.innerText);
        e.target.contentEditable = false;
        }  else if (e.target.classList.contains("base_name")) {
            //console.log("lost focus "+e.target.innerText);

            const baseId = e.target.closest(".vanilla-base-card").getAttribute("base-id");
            const modpackId = e.target.closest(".vanilla-base-card").getAttribute("modpack-id");
            const baseName = e.target.innerText;

            modpackBaseUpdateName(baseId,modpackId, baseName);
           e.target.contentEditable = false;
        }
    }
});

function removeBase(baseId){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
       // Refresh the bases content after removal
       const urlParams = new URLSearchParams(window.location.search);
       const modpackId = urlParams.get('modpack_id');
       LoadPage('bases');
    }
  };
  xhttp.open("POST", "base_remove.php", true);
  data = "base_id="+baseId;
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(data);
}


function modpackBaseDescriptionUpdate(baseId, baseDescription) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         // Refresh the bases content after removal
        
      }
    };
    xhttp.open("POST", "modapck_base_description_update.php", true);
    data = "base_id="+baseId+"&base_description="+baseDescription;
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
  }

  function baseUpdateName(baseId, modpackId, baseName) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         // Refresh the bases content after removal
        
      }
    };
    xhttp.open("POST", "modapck_base_name_update.php", true);
    data = "base_id="+baseId+"&base_name="+baseName+"&modpack_id="+modpackId;
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
  }
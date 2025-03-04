var container = document.querySelector('.sort_bases');
    // Add a click event listener to the container
    container.addEventListener('click', function(event) {
        // Check if the clicked element is a button
        if (event.target.tagName === 'BUTTON'){
            // Get the name attribute of the clicked button
            var baseId = event.target.getAttribute('btn-id');
            sortNotesByBase(baseId);            
            // Do something with the buttonName, for example, log it to the console
            console.log('Button clicked with Id:', baseId);
            //console.log('Button clicked with video-id:', videoId);
        }
    });


var container_remove_btn = document.querySelector('.base_notes_list');
    // Add a click event listener to the container
    container_remove_btn.addEventListener('click', function(event) {
        // Check if the clicked element is a button
        if (event.target.tagName === 'BUTTON'){
            // Get the name attribute of the clicked button
            var noteId = event.target.closest(".note").getAttribute('note-id');
            removeNote(noteId);            
            // Do something with the buttonName, for example, log it to the console
            console.log('Button clicked with Id:', noteId);
            //console.log('Button clicked with video-id:', videoId);
        }
    });



function sortNotesByBase(baseId){
     var xhttp = new XMLHttpRequest();
       //var search_text=document.getElementById("search_string").value;
       xhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               document.querySelector(".base_notes_list").innerHTML =
                   this.responseText;
           }
       };
       xhttp.open("GET", "vanilla_notes_sorted_by_base.php?base_id=" + baseId, true);
       xhttp.send();
}

function removeNote(noteId){
     var xhttp = new XMLHttpRequest();
       //var search_text=document.getElementById("search_string").value;
       xhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               alert("Poznamka bola vymazana");
               const parent = document.querySelector(".base_ideas_list");
               const childToRemove = parent.querySelector(`.note[note-id="${noteId}"]`);
               parent.removeChild(childToRemove);
           }
       };
       
       xhttp.open("POST", "vanilla_notes_remove_note.php",true);
       xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
       data = "idea_id="+ideaId;
       xhttp.send(data);
}
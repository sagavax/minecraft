var new_note_container = document.querySelector(".add_notes");
var container = document.querySelector('.sort_notes');
var container_notes = document.querySelector("#notes_list");
const new_note = document.querySelector("#new_note");
var new_note_header_close_button = document.querySelector(".new_note_header button");
//new_note.style.display="none";


new_note_header_close_button.addEventListener("click", () => {
    new_note.classList.remove("show"); // Odstráni triedu 'show' pre animáciu skrytia
    
    // Po ukončení animácie (500ms) nastavíme display: none
    setTimeout(() => {
        new_note.style.display = "none";  // Po animácii sa nastaví display na 'none'
    }, 500); // Časovanie (v rovnakom čase ako animácia)
});


document.querySelector(".modal_image BUTTON").addEventListener("click", ()=>{
        var modal = document.querySelector(".modal_image");
        var content = document.querySelector(".image_content");
        var existingImg = content.querySelector("img");
        content.removeChild(existingImg);
        modal.style.display="none";
})



container_notes.addEventListener("click", function(event) {
    // Check if the clicked element has the name attribute set to "attach_image"
    //console.log(event.target.name);
    if (event.target.name === "attach_image") {
        // Get the note ID
        var noteId = event.target.closest(".note").getAttribute("note-id");
        
        // Prevent the default behavior of the click event on the file input element
        event.preventDefault();
        
        // Find the file input element
        var fileInput = document.getElementById("file-attach-" + noteId);
        
        // Trigger a click event on the file input element to open the file selection dialog
        fileInput.click();

        // Add an event listener for the 'change' event on the file input element
        fileInput.addEventListener('change', function() {
            // Check if a file is selected
            if (fileInput.files && fileInput.files[0]) {
                // Submit the form
                fileInput.form.submit();
            }
        });
    } else if (event.target.tagName === "I") { // Fix: Change "attach_image" to "attached_image"
        //get file name
        var title = event.target.getAttribute("file-name");
        var icon = document.querySelector("i[name='attached_image']");
        //get note id
        var noteId = event.target.closest(".note").getAttribute("note-id");
        //image path
        var pathtoImage = "gallery/note_attach_"+noteId+"/";
        var image=pathtoImage+title;
        //console.log(image);
        //vytvori element img
        var img = document.createElement('img');
       if (document.querySelector(".modal_image").style.display === "flex") {
              // Get the modal element
              var modal = document.querySelector(".image_content");

              // Find the existing image element (if any)
              var existingImg = modal.querySelector("img");

              if (existingImg) {
                // Remove the existing image
                modal.removeChild(existingImg);
              }

              // Create a new image element
              var newImg = document.createElement("img");
              newImg.src = image;  // Assuming 'image' is a variable containing the image path

              // Append the new image to the modal
              modal.appendChild(newImg);

        } else {
         //document.querySelector(".modal_image").showModal();  
        document.querySelector(".modal_image").style.display="flex";
        document.querySelector(".image_content").appendChild(img);
        //a tu ho zobrazi
        img.src=image;

        }
            
    }
});


//right click on image icon
/*var parentContainer = document.querySelector("#notes_list");
var contextMenu = document.getElementById("contextMenu");

// Add event listener for contextmenu event (right-click)
parentContainer.addEventListener("contextmenu", function(event) {
    // Prevent the default context menu from appearing
    event.preventDefault();

    // Check if the right-clicked element or any of its ancestors is the element you're interested in
    var targetElement = event.target.getAttribute("name") === "attach_image";

    if (targetElement) {
        // Do something when the right-click event occurs on the desired element
        //console.log("Right-clicked on:", targetElement.textContent);
        showContextMenu(event,event.target);
    }
});*/



    // Add a click event listener to the container
    container.addEventListener('click', function(event) {
        // Check if the clicked element is a button
        if (event.target.tagName === 'BUTTON'){
            // Get the name attribute of the clicked button
            var buttonName = event.target.getAttribute('name');
            
            sortNotes(buttonName);
            
            // Do something with the buttonName, for example, log it to the console
            console.log('Button clicked with name:', buttonName);
            //console.log('Button clicked with video-id:', videoId);
        }
    });


    
    new_note_container.addEventListener('click', function(event) {
        // Check if the clicked element is a button
        if (event.target.tagName === 'BUTTON'){
            // Get the name attribute of the clicked button
            var buttonName = event.target.getAttribute('name');
                                    
            // Do something with the buttonName, for example, log it to the console
            console.log('Button clicked with name:', buttonName);
            showNewNote();
            //document.querySelector(".modal_image").showModal();
            //console.log('Button clicked with video-id:', videoId);
        }
    });


    
    function sortNotes(sort_by){

       var xhttp = new XMLHttpRequest();
       //var search_text=document.getElementById("search_string").value;
       xhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               document.getElementById("notes_list").innerHTML =
                   this.responseText;
           }
       };
       xhttp.open("GET", "notes_sorted_by.php?sort_by=" + sort_by, true);
       xhttp.send();
    }



 function showContextMenu(event,targetElement) {
        //console.log(targetElement);
        var rect = targetElement.getBoundingClientRect();
        var iconX = rect.left + rect.width / 2;
        var iconY = rect.top + rect.height / 2;
        
        contextMenu.style.display = "block";
        contextMenu.style.left = iconX + "px";
        contextMenu.style.top = iconY + "px";
        
    }


function previewImage(eventTarget){
    //show modal
    console.log("show modal");

     //get id note
    //show image
}

    function search_note(text){
             var xhttp = new XMLHttpRequest();
             var search_text=document.getElementById("search_string").value;
             xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                document.getElementById("notes_list").innerHTML = this.responseText;
                       }
                    };
                xhttp.open("GET", "notes_search.php?search="+text, true);
                xhttp.send();               
            }


            function showNewNote() {
                new_note.style.display = "flex";  // Zobrazíme element
                setTimeout(() => {
                    new_note.classList.add("show"); // Pridáme triedu na zobrazenie s animáciou
                }, 10); // Krátke oneskorenie pred pridaním triedy
            }
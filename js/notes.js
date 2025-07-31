var new_note_container = document.querySelector(".add_notes");
var container = document.querySelector('.sort_notes');
var container_notes = document.querySelector("#notes_list");
const new_note = document.querySelector("#new_note");
var new_note_header_close_button = document.querySelector(".new_note_header button");
var note_attached_files = document.querySelector(".note_attached_files");
var container_notes_action = document.querySelector(".notes_action");
var container_notes_list = document.querySelector("#notes_list");
var modal_change_modpack = document.querySelector(".modal_change_modpack");
const dialog_modpacks = document.querySelector('.dialog_modpacks');
// new_note.style.display="none";

new_note_header_close_button.addEventListener("click", () => {
    new_note.classList.remove("show"); // Odstráni triedu 'show' pre animáciu skrytia
    
    // Po ukončení animácie (500ms) nastavíme display: none
    setTimeout(() => {
        new_note.style.display = "none";  // Po animácii sa nastaví display na 'none'
    }, 500); // Časovanie (v rovnakom čase ako animácia)
});

document.querySelector(".modal_image BUTTON").addEventListener("click", () => {
    var modal = document.querySelector(".modal_image");
    var content = document.querySelector(".image_content");
    var existingImg = content.querySelector("img");
    content.removeChild(existingImg);
    modal.style.display = "none";
});


dialog_modpacks.addEventListener("click", (event) => {
    if (event.target.tagName === "BUTTON") {
        const modpackName = event.target.textContent;
        const modpackId = event.target.getAttribute("modpack-id");
        changeModpack(modpackName, modpackId); // Call the changeModpack function
    }
})


container_notes_list.addEventListener("click", function(event) {
    //console.log("Clicked element:", event.target.name);

    if (event.target.tagName === "BUTTON") {
        
        const noteId = event.target.closest(".note").getAttribute("note-id");
        sessionStorage.setItem("note_id", noteId);

        console.log(event.target.name);
        if (event.target.name === "attach_image") {
            const noteId = event.target.closest(".note").getAttribute("note-id");
            event.preventDefault();

            const fileInput = document.getElementById(`file-attach-${noteId}`);
            fileInput.click();

            // Odstráň existujúci listener ak nejaký bol (aby sa nehromadili)
            const oldListener = fileInput._changeListener;
            if (oldListener) {
                fileInput.removeEventListener('change', oldListener);
            }

            // Vytvor a ulož nový listener
            // Vytvor a ulož nový listener
            const changeListener = function() {
                if (fileInput.files && fileInput.files[0]) {
                    fileInput.form.submit();
                }
            };
            fileInput._changeListener = changeListener;

            fileInput.addEventListener('change', changeListener);
        } else if (event.target.name === "delete_note") {
            const noteId = event.target.closest(".note").getAttribute("note-id");
            alert("remove note: " + noteId);
            //RemoveNote(noteId);
        } else if (event.target.name === "edit_note") {
            // Implement edit functionality here
            //editNote(noteId);
        } else if (event.target.name === "change_modpack") {
            dialog_modpacks.showModal(); // Open the dialog;
        } else if (event.target.name === "add_mod") {
            //dialog_modifications.showModal();
        }

    } else if (event.target.classList.contains("fa-file-image")) {
        const fileName = event.target.getAttribute("data-file-name");
        console.log("Attached image clicked:", fileName);
        if (fileName) {
            // Get note ID from parent structure
            const noteId = event.target.closest(".note").getAttribute("note-id");
            
            // Construct image path
            const pathToImage = `gallery/note_attach_${noteId}/`;
            const imagePath = pathToImage + fileName;
            
            const modalContainer = document.querySelector(".modal_image");
            const modalContent = document.querySelector(".image_content");
            
            if (modalContainer.style.display === "flex") {
                // Modal is already open, replace image
                const existingImg = modalContent.querySelector("img");
                if (existingImg) {
                    modalContent.removeChild(existingImg);
                }
                
                const newImg = document.createElement("img");
                newImg.src = imagePath;
                modalContent.appendChild(newImg);
            } else {
                // Modal is closed, open it with new image
                modalContainer.style.display = "flex";
                const img = document.createElement("img");
                img.src = imagePath;
                modalContent.appendChild(img);
            }
        } else {
            console.log("File name attribute is missing.");
        }
    }
});



    //event.target.object attached file

/* note_attached_files.addEventListener("click", (event) => {
    // Kontrola či sa kliklo na ikonu
    if (event.target.tagName !== "I") return;
    
    // Získanie potrebných dát
    const fileName = event.target.getAttribute("file-name");
    const noteId = event.target.closest(".note").getAttribute("note-id");
    const imagePath = `gallery/note_attach_${noteId}/${fileName}`;
    
    // Práca s modalom
    const modal = document.querySelector(".modal_image");
    const modalContent = document.querySelector(".image_content");
    
    // Vytvorenie nového img elementu
    const newImage = document.createElement('img');
    newImage.src = imagePath;
    
    if (modal.style.display === "flex") {
        // Ak je modal otvorený, nahraď existujúci obrázok
        const existingImg = modalContent.querySelector("img");
        if (existingImg) {
            existingImg.remove();
        }
    } else {
        // Ak je modal zatvorený, otvor ho
        modal.style.display = "flex";
    }
    
    // Vlož nový obrázok
    modalContent.appendChild(newImage);
}); */

// Add a click event listener to the container
container.addEventListener('click', function(event) {
    // Check if the clicked element is a button
    if (event.target.tagName === 'BUTTON') {
        // Get the name attribute of the clicked button
        var buttonName = event.target.getAttribute('name');
        
        sortNotes(buttonName);
        
        // Do something with the buttonName, for example, log it to the console
        console.log('Button clicked with name:', buttonName);
    }
});

new_note_container.addEventListener('click', function(event) {
    // Check if the clicked element is a button
    if (event.target.tagName === 'BUTTON') {
        // Get the name attribute of the clicked button
        var buttonName = event.target.getAttribute('name');
                                
        // Do something with the buttonName, for example, log it to the console
        console.log('Button clicked with name:', buttonName);
        showNewNote();
    }
});

function sortNotes(sort_by) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("notes_list").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "notes_sorted_by.php?sort_by=" + sort_by, true);
    xhttp.send();
}

function showContextMenu(event, targetElement) {
    var rect = targetElement.getBoundingClientRect();
    var iconX = rect.left + rect.width / 2;
    var iconY = rect.top + rect.height / 2;
    
    contextMenu.style.display = "block";
    contextMenu.style.left = iconX + "px";
    contextMenu.style.top = iconY + "px";
}

function previewImage(eventTarget) {
    // show modal
    console.log("show modal");
    // get id note
    // show image
}

function search_note(text) {
    var xhttp = new XMLHttpRequest();
    var search_text = document.getElementById("search_string").value;
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("notes_list").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "notes_search.php?search=" + text, true);
    xhttp.send();
}

function showNewNote() {
    new_note.style.display = "flex";  // Zobrazíme element
    setTimeout(() => {
        new_note.classList.add("show"); // Pridáme triedu na zobrazenie s animáciou
    }, 10); // Krátke oneskorenie pred pridaním triedy
}


function RemoveNote(noteId){
    var xhttp = new XMLHttpRequest();
    var search_text = document.getElementById("search_string").value;
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //document.getElementById("notes_list").innerHTML = this.responseText;
        }
    };
    data = "note_id="+noteId;
    xhttp.open("POST", "notes_remove.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}

function  changeModpack(modpackName, modpackId) {
    const noteId = sessionStorage.getItem("note_id");
    var xhttp = new XMLHttpRequest();
    var search_text = document.getElementById("search_string").value;
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //change text for modpack in note 
            //document.querySelector(".note[note-id='" + noteId + "'] span_modpack").textContent = modpackName;
            document.querySelector(`.note[note-id="${noteId}"] button[name='change_modpack']`).textContent = modpackName;
            document.querySelector(".dialog_modpacks").close();
        }
    };
    data = "modpack_name="+modpackName+"&modpack_id="+modpackId+"&note_id="+noteId;
    xhttp.open("POST", "notes_change_modpack.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}
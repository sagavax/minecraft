var new_note_container = document.querySelector(".add_notes");
var new_note_form = document.querySelector("#new_note form");
var container = document.querySelector('.sort_notes');
var container_notes = document.querySelector("#notes_list");
const new_note = document.querySelector("#new_note");
var new_note_header_close_button = document.querySelector(".new_note_header button");
var note_attached_files = document.querySelector(".note_attached_files");
var container_notes_action = document.querySelector(".notes_action");
var notes_list = document.querySelector("#notes_list");
var modal_change_modpack = document.querySelector(".modal_change_modpack");
const dialog_modpacks = document.querySelector('.dialog_modpacks');
const note_header = document.querySelector('#new_note input[name="note_title"]')
const dialog_mods = document.querySelector('.dialog_mods');
const dialog_add_coordinates = document.querySelector('.modal_add_coordinates');
const search_wrap_input = document.querySelector('.search_wrap input');



search_wrap_input.addEventListener("keyup", (event) => {
    const searchText = event.target.value;
    searchNote(searchText);
});


dialog_mods.addEventListener("click", (event) => {
    if (event.target.tagName === "BUTTON") {
        if(event.target.name === "add_mod"){
            const modName = event.target.textContent;
            const modId = event.target.getAttribute("mod-id");
            changeNotesMod(modName, modId); // Call the changeMod function   
            event.target.remove(); 
        } else if (evement.target.name === "char"){
            changeModLstByChar(event.target.innerText);
        }
        
    }
})


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


dialog_add_coordinates.addEventListener("click", (event) => {
    //dialog_add_coordinates.close();
    if(event.target.tagName === "BUTTON"){
       if(event.target.name==="set_coordinates"){
        const noteId = sessionStorage.getItem("note_id");
        console.log(noteId);
        const coord_x = dialog_add_coordinates.querySelector("input[name='coord_x']").value;
        const coord_y = dialog_add_coordinates.querySelector("input[name='coord_y']").value;
        const coord_z = dialog_add_coordinates.querySelector("input[name='coord_z']").value;    
        addCoordinates(noteId, coord_x, coord_y, coord_z);
        alert("Koordinaty pre poznamku s id "+ noteId + " boli zmenene");
        dialog_add_coordinates.close()
       }
    }
});


dialog_modpacks.addEventListener("click", (event) => {
    if (event.target.tagName === "BUTTON") {
        const modpackName = event.target.textContent;
        const modpackId = event.target.getAttribute("modpack-id");
        changeModpack(modpackName, modpackId); // Call the changeModpack function
    }
})

// odoslanie formulára
new_note_form.addEventListener("submit", (event) => {
    const noteText = new_note_form.querySelector("textarea[name='note_text']").value.trim();

    if(noteText === "") {
        event.preventDefault();
        alert("Note cannot be empty!");
        return;
    }
    // žiadne preventDefault - bude bežať klasické odoslanie formulára na server
    AddNewNote();
    
});


notes_list.addEventListener("click", function(event) {
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
            document.querySelector(`.note[note-id='${noteId}']`).remove();
            ShowMessage("Note has been removed");
            RemoveNote(noteId);

        } else if (event.target.name === "edit_note") {
            // Implement edit functionality here
            //editNote(noteId);
        } else if (event.target.name === "change_modpack") {
            dialog_modpacks.showModal(); // Open the dialog;
        } else if (event.target.name === "change_mods") {
            dialog_mods.showModal();
        } else if (event.target.name === "add_coordinates") {
            dialog_add_coordinates.showModal();
        } else if (event.target.name === "remove_coordinates") {
             const noteId = event.target.closest(".note").getAttribute("note-id");
            removeCoordinates(noteId);
            document.querySelector(".note[note-id='${noteId}'] .note_coord_wrap").remove()
            ShowMessage("Coordinates for note with ID:"+noteId+" removed");
            
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
    } else if (event.target.classList.contains("note_header")) {
    console.log("Note header clicked");

    const noteId = event.target.closest(".note").getAttribute("note-id");
    sessionStorage.setItem("note_id", noteId);

    const noteHeader = event.target;

    // Zabránime opakovaniu
    if (noteHeader.isContentEditable) return;

    const oldText = noteHeader.textContent;

    noteHeader.contentEditable = true;
    noteHeader.focus();

    // Listener na blur, spustí sa iba raz
    noteHeader.addEventListener("blur", function handleBlur() {
        noteHeader.contentEditable = false;

        const newText = noteHeader.textContent;
        if (newText !== oldText) {
           alert("Note header changed.");
            saveNoteHeader(noteId, newText);
        } else {
            console.log("No change to note header.");
        }

        noteHeader.removeEventListener("blur", handleBlur); // prevent repeated firing
    }, { once: true }); // zabezpečí, že sa nespustí viackrát
} 
});

 note_header.addEventListener("blur", function() {
        note_header.contentEditable = false;
        saveNoteHeader(noteId, note_header.textContent);
    });

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

function searchNote(text) {
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
            alert("Modpack changed.");
        }
    };
    data = "modpack_name="+modpackName+"&modpack_id="+modpackId+"&note_id="+noteId;
    xhttp.open("POST", "notes_change_modpack.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}

function AddNewNote(){
    var note_text = document.querySelector('#new_note textarea[name="note_text"]').value;
    var note_title = document.querySelector('#new_note input[name="note_title"]').value; 
    
    var select = document.querySelector('#new_note select[name="modpack"]');
    var modpackName = select.options[select.selectedIndex].text;
    var selectValue = select.value;

    console.log("Selected modpack:", modpackName, "with ID:", selectValue);


    var modpackButtonHTML = "";

    if (selectValue === "0") {
        modpackButtonHTML = `<button class="span_modpack" type="button" name="change_modpack" title="add modpack">
                                <i class="fa fa-plus"></i>
                            </button>`;
    } else {
        modpackButtonHTML = `<button class="span_modpack" type="button" name="change_modpack" modpack-id="${selectValue}">
                                ${modpackName}
                            </button>`;
    }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
           
            alert("Note saved successfully!");
            document.querySelector('#new_note textarea[name="note_text"]').value = "";
            document.querySelector('#new_note input[name="note_title"]').value = "";
            document.querySelector('#new_note select[name="modpack"]').value = "0";
        }
    };

    var data = "note_header="+encodeURIComponent(note_title)
             + "&note_text="+encodeURIComponent(note_text)
             + "&modpack="+selectValue;

    xhttp.open("POST", "note_add.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}


function saveNoteHeader(noteId, note_header) {
    var xhttp = new XMLHttpRequest();
    var search_text = document.getElementById("search_string").value;
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //document.getElementById("notes_list").innerHTML = this.responseText;
        }
    };
    data = "note_id="+noteId+"&note_header="+encodeURIComponent(note_header);
    xhttp.open("POST", "notes_change_header.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}


function saveNoteCoordinates(noteId, axis, value) {
    const xhttp = new XMLHttpRequest();
    const data = `note_id=${noteId}&coordinate=${axis}&value=${encodeURIComponent(value)}`;
    xhttp.open("POST", "notes_coordinates_update.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}


function addCoordinates(noteId, coord_x, coord_y, coord_z) {
    const xhttp = new XMLHttpRequest();
    const data = `note_id=${noteId}+&coord_x=${coord_x}&coord_y=${coord_y}&coord_z=${coord_z}`;
    xhttp.open("POST", "notes_coordinates_add.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}


function removeCoordinates(noteId) {
    const xhttp = new XMLHttpRequest();
    const data = `note_id=${noteId}`;
    xhttp.open("POST", "notes_coordinates_remove.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}

function changeModLstByChar(char){
    var xhttp = new XMLHttpRequest();
    var search_text = document.getElementById("search_string").value;
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("notes_mods_list").innerHTML = this.responseText;
        }
    };
    data = "char="+char;
    xhttp.open("POST", "notes_mods_filter_by_char.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data); 
}

function  changeNotesMod(modName, modId) {
    const noteId = sessionStorage.getItem("note_id");
    var xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //change text for mod in note 
            //document.querySelector(".note[note-id='" + noteId + "'] span_mod").textContent = modName;
            document.querySelector(`.note[note-id="${noteId}"] button[name='add_mod']`).textContent = modName;
            document.querySelector(".dialog_mods").close();
        }
    };
    data = "mod_name="+modName+"&mod_id="+modId+"&note_id="+noteId;
    xhttp.open("POST", "notes_mod_add.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}
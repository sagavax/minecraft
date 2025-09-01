//var buttons_chars = buttonContainer_chars.getElementsByTagName('button');
var buttonContainer_chars = document.getElementById("letter_list");
var taskRadiosContainers = document.querySelectorAll('.task_view');
var imageRadiosContainers = document.querySelectorAll('.image_radios');
var popupModsListContainer = document.querySelector('.popup_mods_list main');
var new_note = document.getElementById("new_note");
var video_url = document.querySelector("input[name='video_url']");          
//wrapper
var list = document.querySelector(".list");
const dialog_add_new_link = document.querySelector(".dialog_add_new_link");
const popup_mods_list = document.querySelector(".popup_mods_list");
const popup_mods_list_input = document.querySelector(".popup_mods_list input");
const modpack_mod_list = document.querySelector(".modpack_mod_list");
const modpack_mods_urls = document.querySelector(".modpack_mods_urls");
const modal_new_base = document.getElementById('modal_new_base');
const modal_new_link_name = document.querySelector('.dialog_link_name');



modal_new_link_name.addEventListener("click", function(e) {
    if (e.target.tagName === "BUTTON" && e.target.name==="add_link") {
        const link_name = modal_new_link_name.querySelector('input[name="link_name"]').value;
        
        if (link_name === "") {
            alert("Cannot be empty.");
            return;
        } 
           modpack_id = sessionStorage.getItem("modpack_id");
           addNewLinkName(link_name, modpackId);
           modal_new_link_name.close();
     } 
})



modal_new_base.addEventListener("click", function(e) {
    if (e.target.tagName === "BUTTON" && e.target.name==="add_base") {
        const modpackId = sessionStorage.getItem("modpack_id");
        console.log(modpackId);
        const base_name = modal_new_base.querySelector('input[name="base_name"]').value;
        const base_description = modal_new_base.querySelector('textarea[name="base_description"]').value;
        const over_x = modal_new_base.querySelector('input[name="over_x"]').value;
        const over_y = modal_new_base.querySelector('input[name="over_y"]').value;
        const over_z = modal_new_base.querySelector('input[name="over_z"]').value;
        if (base_name === "" || over_x === "" || over_y === "" || over_z === "") {
            alert("Please fill in all the fields.");
            return;
        } 
           addNewModpackBase(modpackId, base_name, base_description, over_x, over_y, over_z);
           modal_new_base.close();
     } else if (e.target.tagName === "BUTTON" && e.target.name==="return_to_vanilla") {
         modal_new_base.close();
     }
 })


popup_mods_list_input.addEventListener("input", function(event) {
     popupSearchMod(popup_mods_list_input.value.trim())
});

popup_mods_list_input.addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        if(popup_mods_list_input.value.trim() === ""){
            alert("Please enter a mod name.");
            return;
        }
        AddModtoMods(popup_mods_list_input.value.trim());
        popup_mods_list_input.value = "";
        alert("Mod added successfully!");
    }
});


dialog_add_new_link.addEventListener("click", function(event) {

    if (event.target.tagName === "INPUT") {

        console.log("input");

    } else if (event.target.tagName === "BUTTON") {

        console.log("button");

        const linkInput = document.querySelector(
            ".dialog_add_new_link input[name='link_url']"
        );
        const linkValue = linkInput.value.trim();

        if (linkValue === "") {
            alert("Empty link URL");
            return;
        }

        if (!isValidURL(linkValue)) {
            alert("Invalid link URL");
            return;
        }

        addNewLink(linkValue);
    }

});



popup_mods_list.addEventListener("click", function(event) {
   if (event.target.tagName === "BUTTON") {
        console.log("button");
        if(event.target.name=="add_new_mod"){
            addNewMod();
        } else if (event.target.name == "char") { // list of characters / A-Z   
            filterModsByChar(event.target.innerText);
        } else if (event.target.name == "hide_popup") {
            document.querySelector(".popup_mods_list").style.display = "none";
        } else if (event.target.name == "add_mod_to_modpack") {
            modID = event.target.getAttribute("data-id")
            modpackId = sessionStorage.getItem("modpack_id");
            modName = event.target.innerText;
            addModToModpack(event.target.getAttribute("data-id"),modpackId);

            const addButton = "document.querySelector(`.modpack_mod_list button[name='add_mods']`)";
            const modList = document.querySelector(".modpack_mod_list");
        modList.insertAdjacentHTML("afterbegin", `<button type='button' class='button blue_button' data-id=${modID} name='remove_mod_from_modpack'>${modName}</buton>`);

            event.target.remove();
        }  
    }
});




//event listener for list
document.querySelector(".list").addEventListener("click", function(event) {
    const button = event.target.closest("button");
    if (button) {
        const urlParams = new URLSearchParams(window.location.search);
        const modpackId = urlParams.get('modpack_id');
        sessionStorage.setItem("modpack_id", modpackId);
       switch (button.name) {
    case "add_new_ext_pic":
        const imageUrl = document.querySelector(`#new_image input[name="image_url"]`).value;
        if (imageUrl === "") {
            alert("Empty url");
            return;
        }
        saveImage();
        break;

     case "task_add":
        //create new task
        alert("create new task");
        event.preventDefault();
        const taskText = document.querySelector(`#new_task textarea[name="task_text"]`).value;
         if (!taskText) {
            alert("Empty text");
            return;
        }
        createTask();
        break;

     case "complete_task":
        //mark task as complete task
        taskCompleted(button.closest(".task").getAttribute('id'));
        break;

    case "edit_task":
        // edit task
        switchToTextarea(button.closest(".task").getAttribute('id'));
        break;

    case "delete_task":
        // delete task
        deleteTask(taskId);
        break;

    case "active":
        // filter active tasks
        filterTasks(modpackId, "active");
        break;

    case "completed":
        // filter completed tasks
        filterTasks(modpackId, "completed");
        break;
    
    case "all":
        // filter all tasks no matter status
        filterTasks(modpackId,"all");
        break;
        

    case "note_add":
        event.preventDefault();
        const noteText = document.querySelector(`#new_note textarea[name="note_text"]`).value;
        const noteHeader = document.querySelector(`#new_note input[name="note_header"]`).value;
        if (noteText==="") {
            alert("Empty text");
            return;
        }
        saveNote();
        break;

    case "clear_search":
        // clear search
        break;

    case "attach_image":
        // handle file click
        const fileInput = button.closest(".note_footer")?.querySelector(`input[type='file']`);
        if (fileInput) fileInput.click();
        break;

    case "edit_note":
        // edit logic
       alert("edit note");
        break;

    case "delete_note":
        // delete logic
        alert("delete note");
        break;

    case "add_new_video":
        // add video
        const videoTitle = document.querySelector(`#new_video input[name="video_title"]`).value;
        const videoUrl = document.querySelector(`#new_video input[name="video_url"]`).value;
        if (!videoUrl) {
            alert("Empty video url");
            return false;
        } else {
            saveVideo();
        }
        break;
     
     case "add_link":
        // add nee link
        //alert("add new link");
        dialog_add_new_link.showModal();
        break;    
     case "add_mods":
        // add mods
        popup_mods_list.showModal();
        break;

     case "reload_mods":
        const modpackId = sessionStorage.getItem("modpack_id");
        reloadMods(modpackId);   

     case "add_base":
        // add new base
        modal_new_base.showModal();
        break;

    case "add_link_name":
        modal_new_link_name.showModal();    
    default:
        // handle other buttons
        break;
    }
    }
});

/**
 * Checks whether a given string is a valid URL.
 * @param {string} url The url to check
 * @returns {boolean} True if the string is a valid URL, false otherwise
 */
   function isValidUrl(url) {
    try {
        new URL(url);
        return true;
    } catch (e) {
        return false;
    }
}




/**
 * Extracts the video ID from a given YouTube URL, removes any time parameter and fetches the video title.
 * If the video title contains "Bedrock", sets the edition select field to "bedrock".
 * @returns {string|null} The video ID if the URL is valid, null otherwise.
 */
function getYouTubeVideoName() {
    var url = document.getElementById("video_url").value;

    // Validácia URL
    if (!isValidUrl(url)) {
        console.error("Invalid URL provided:", url);
        ShowMessage("Invalid URL");
        return; // Exit the function if the URL is invalid
    } else {
        // Kontrola a odstránenie časového parametra
        if (hasTimeParameter(url)) {
            url = removeTimeParameter(url);
            console.log("URL after removing time parameter:", url);
        }

        // Definovanie regulárneho výrazu na zhodu s YouTube URL
        const youtubeRegex = /^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/;
        
        // Extrakcia ID videa z URL pomocou regulárneho výrazu
        const match = url.match(youtubeRegex);

        // Ak je nájdená zhoda, pokračuj
        if (match && match[1]) {
            const videoId = match[1];

            // Asynchrónne volanie na získanie názvu videa
            fetch("get_youtube_video_name.php?videoUrl=" + encodeURIComponent(url))
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.text();
                })
                .then(video_name => {
                    if (video_name) {
                        document.getElementById("video_title").value = video_name;

                        let bedrockVariants = ["Bedrock", "bedrock", "BEDROCK"];

                        // Kontrola, či názov videa obsahuje varianty "Bedrock"
                        if (bedrockVariants.some(variant => video_name.includes(variant))) {
                            document.querySelector('select[name="edition"]').value = "bedrock";
                        }
                    } else {
                        // Spracovanie prípadu, keď názov videa je prázdny
                        ShowMessage("Video name could not be retrieved.");
                    }
                })
                .catch(error => {
                    console.error('Error fetching video name:', error);
                    ShowMessage("An error occurred while fetching the video name.");
                });

            // Môžeš použiť video ID na vykonávanie API požiadaviek alebo iné akcie
            return videoId;
        } else {
            // Zobrazenie chybovej správy, ak URL nie je platná
            ShowMessage("This is not a valid YouTube video URL");
            return null;
        }
    }
}

function checkVideoExists() {
    url = document.getElementById("video_url").value;
    var xhttp = new XMLHttpRequest();
    const icon1 = document.querySelector(".icon1");
    const icon2 = document.querySelector(".icon2");

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

            video_url = document.getElementById("video_url");
            if (this.responseText == 1) {

                video_url.style.borderWidth = "3px";
                video_url.style.borderColor = "#e74c3c";
                setTimeout(clear_video_url_style,2000);
                ShowMessage("Video already exists!!");
                
                return false;
            } else {
                video_url.style.borderWidth = "3px";
                video_url.style.borderColor = "#27ae60";
                
            }
        }
    };
    xhttp.open("GET", "check_video_id.php?video_id=" + video_url.value, true);
    xhttp.send();
}


/**
 * Saves a new video by extracting the video title, URL, and other metadata from the form.
 * Sends an asynchronous POST request to 'videos_save.php' to store the video details in the database.
 * Updates the video list on successful response.
 */


function SaveVideo() {
    const videoTitle = document.querySelector(`#new_video input[name="video_title"]`).value;
    const videoUrl = document.querySelector(`#new_video input[name="video_url"]`).value;
    const modpackId = sessionStorage.getItem("modpack_id");
    const videoSource = "YouTube";
    const edition = "java";
    const videoId = getYouTubeVideoId(videoUrl);

    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.querySelector(".video_list").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "videos_save.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("modpack_id=" + modpackId + "&video_title=" + videoTitle + "&video_url=" + videoUrl + "&video_source=" + videoSource + "&edition=" + edition);
}



function filterTasks(modpackId, taskStatus) {
    // filter tasks
  const xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
      if (this.readyState === 4 && this.status === 200) {
          document.querySelector(".tasks").innerHTML = this.responseText;
      }
  };
  xhttp.open("GET", "modpack_tasks_by_status.php?modpack_id=" + modpackId + "&status=" + taskStatus, true);
  xhttp.send();
}


/**
 * Replaces the task body with a textarea for editing. When the textarea loses focus, saves the changes and switches back to the div.
 * @param {number} taskId The ID of the task to edit
 */
 function switchToTextarea(taskId) {
    const div = document.querySelector(`.task[id="${taskId}"] .task_body`);
    console.log(div);
    const text = div.innerText;

    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.width = '100%';
    textarea.style.height = '100px';
    textarea.style.marginBottom = '10px';

    // Nahradí div textareou
    div.replaceWith(textarea);
    textarea.focus();

    // Po strate fokusu sa uloží a prepne späť
    textarea.addEventListener('blur', () => {
      const newDiv = document.createElement('div');
      newDiv.classList.add('task_body');
      newDiv.innerText = textarea.value;
      textarea.replaceWith(newDiv);
      SaveTaskChanges(taskId, textarea.value);
    });
  }


/**
 * Marks a task as completed.
 * @param {number} taskId The ID of the task to mark as completed
 */
function taskCompleted(taskId) {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.querySelector(`.task[id="${taskId}"] .task_action button[name=complete_task]`).remove();
            document.querySelector(`.task[id="${taskId}"] .task_action button[name=edit_task]`).remove();
            document.querySelector(`.task[id="${taskId}"] .task_action`).innerHTML = "<div class='task_completed'>Complete</div>";
        }
    };
    xhttp.open("POST", "task_completed.php", true);  
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var data = "task_id=" + encodeURIComponent(taskId);
    xhttp.send(data);
}


/**
 * Saves changes to a task's text.
 * @param {number} taskId The ID of the task to update
 * @param {string} taskText The new text for the task
 */
function SaveTaskChanges(taskId, taskText) {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            alert("Task changed");
        }
    };
    xhttp.open("POST", "task_edit.php", true);  
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var data = "task_id=" + encodeURIComponent(taskId) + "&task_text=" + encodeURIComponent(taskText);
    xhttp.send(data);
}

/**
 * Creates a new task.
 * @param {string} taskText The text of the new task
 * @param {number} modpack_id The ID of the modpack to add the task to
 */
function createTask() {
    const taskText = document.querySelector(`#new_task textarea[name="task_text"]`).value;
    const urlParams = new URLSearchParams(window.location.search);
    const modpack_id = urlParams.get('modpack_id');

    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.querySelector(".tasks").innerHTML = this.responseText;
            alert("Task added");
        }
    };
    xhttp.open("POST", "task_add.php", true);  
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var data = "task_text=" + encodeURIComponent(taskText) + "&modpack_id=" + encodeURIComponent(modpack_id);
    xhttp.send(data);

   /*  fetch("task_add.php?task_text=" + encodeURIComponent(taskText) + "&modpack_id=" + encodeURIComponent(modpack_id))
        .then(response => response.text())
        .then(data => {
            document.querySelector(".tasks").innerHTML = data;
        });        */
}       


/**
 * Saves a new note.
 * @param {string} noteTitle The title of the new note
 * @param {string} noteText The text of the new note
 * @param {number} modpack_id The ID of the modpack to add the note to
 */
function SaveNote() {
    const noteTitle = document.querySelector(`#new_note input[name="note_header"]`).value;
    const noteText = document.querySelector(`#new_note textarea[name="note_text"]`).value;

    const urlParams = new URLSearchParams(window.location.search);
    const modpack_id = urlParams.get('modpack_id');

    // Najskôr ulož poznámku
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {

            // Získaj posledné note_id
            fetch("GetLatestNoteId.php")
                .then(response => response.text())
                .then(noteId => {
                    // Potom zisti meno modpacku
                    fetch("modpack_name.php?modpack_id=" + modpack_id)
                        .then(response => response.text())
                        .then(modpackName => {

                            const noteHTML = `
                                <div class="note">
                                    <div class="note_header">${noteTitle}</div>
                                    <div class="note_text">${noteText}</div>
                                    <div class="note_footer">
                                        <div class="notes_action">
                                            <button class="span_mod" type="button" name="add_mod" title="add mod"><i class="fa fa-plus"></i></button><span class="span_modpack">${modpackName}</span>
                                            <form method="post" action="notes_attach_file.php" enctype="multipart/form-data">
                                                <input type="hidden" name="note_id" value="${noteId}">
                                                <input type="file" name="image" id="file-attach-${noteId}" accept="image/*" style="display: none;">
                                            </form>
                                            <button name="attach_image" type="button" class="button small_button">
                                                <i class="material-icons">attach_file</i>
                                            </button>
                                            <button name="edit_note" type="submit" class="button small_button">
                                                <i class="material-icons">edit</i>
                                            </button>
                                            <button name="delete_note" type="submit" class="button small_button">
                                                <i class="material-icons">delete</i>
                                            </button>
                                        </div>
                                        <div class="note_attached_files"></div>
                                    </div>
                                </div>`;

                            document.querySelector("#notes_list").insertAdjacentHTML("afterbegin", noteHTML);
                        })
                        .catch(err => console.error("Chyba pri načítaní mena modpacku:", err));
                })
                .catch(err => console.error("Chyba pri získavaní note_id:", err));
        }
    };

    xhttp.open("POST", "notes_save.php", true);
    const params = "note_title=" + encodeURIComponent(noteTitle) + "&note_text=" + encodeURIComponent(noteText);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
}


/**
 * Získa meno modpacku podľa URL parametrov a vypíše ho do elementu .modpack_name
 */
function GetModpackName() {
    const urlParams = new URLSearchParams(window.location.search);
    const modpack_id = urlParams.get('modpack_id');

    var xhttp = new XMLHttpRequest();
    // var search_text = document.getElementById("search_string").value;
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(".modpack_name").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "modpack_name.php?modpack_id=" + modpack_id, true);
    xhttp.send();
}

/**
 * Získa ID poslednej poznámky.
 * @return {string} ID poslednej poznámky
 */
function GetLatestNoteId() { // get latest note ID
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            return this.responseText;
        }
    };
    xhttp.open("GET", "notes_get_latest_id.php", true);
    xhttp.send();
}


function showNewNote() {
    new_note.style.display = "flex";  // Zobrazíme element
    setTimeout(() => {
        new_note.classList.add("show"); // Pridáme triedu na zobrazenie s animáciou
    }, 10); // Krátke oneskorenie pred pridaním triedy
}


// Convert NodeList to an array and loop through each container
Array.from(taskRadiosContainers).forEach(function(container) {
    // Get all radio buttons inside the current container
    var taskRadioButtons = container.querySelectorAll('input[type="radio"]');

    // Add click event listener to each radio button
    taskRadioButtons.forEach(function(taskRadioButton) {
        taskRadioButton.addEventListener('click', function() {
            // Get the id of the clicked radio button
            var status = taskRadioButton.id;
            console.log(status);
            sort_tasks(status);
        });
    });
});



// Convert NodeList to an array and loop through each container
Array.from(imageRadiosContainers).forEach(function(container) {
    // Get all radio buttons inside the current container
    var imageRadioButtons = container.querySelectorAll('input[type="radio"]');

    // Add click event listener to each radio button
    imageRadioButtons.forEach(function(imageRadioButton) {
        imageRadioButton.addEventListener('click', function() {
            // Get the id of the clicked radio button
            var clickedImageRadioId = imageRadioButton.id;

            if (clickedImageRadioId === "upload_image") {
                document.getElementById("new_image_upload").style.display = "flex";
                document.getElementById("new_image_external").style.display = "none";
            }

            if (clickedImageRadioId === "add_ext_image") {
                document.getElementById("new_image_external").style.display = "flex";
                document.getElementById("new_image_upload").style.display = "none";
            }

            localStorage.setItem("modpack_image_radio", imageRadioButton.id); // remember clicked radio button
            console.log('Clicked Radio ID:', clickedImageRadioId);
        });
    });
});


function reloadMods(modpack_id){
     var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(".popup_mods_list main").innerHTML = this.responseText;
        }
    };
    // xhttp.open("GET", "count_comments.php?video_id=<?php echo $_GET['video_id'] ?>", true);
    xhttp.open("GET", "modpack_reaload_mods.php", true);
    xhttp.send();
}


function toggle_popup_mods() {
    document.querySelector(".popup_mods_list").showModal();
   
}

function hide_popup() {
    var div = document.querySelector(".popup_mods_list");
    div.style.display = 'none';
}

function addModToModpack(mod_id, modpack_id) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        
    }

    xhttp.open("POST", "modpack_mod_add.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   // data = "&video_id=" + encodeURIComponent(video_id) + "&video_comment=" + encodeURIComponent(new_note);
    var data = "mod_id=" + encodeURIComponent(mod_id) + "&modpack_id=" + encodeURIComponent(modpack_id);
    xhttp.send(data);
}

/* function sort_mods_by_char(char) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(".popup_mods_list main").innerHTML = this.responseText;
        }
    };
    // xhttp.open("GET", "count_comments.php?video_id=<?php echo $_GET['video_id'] ?>", true);
    xhttp.open("GET", "modpack_sort_mods_by_char.php?char=" + char, true);
    xhttp.send();
} */

function sort_tasks(status) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(".tasks").innerHTML = this.responseText;
        }
    };
    var modpack_id = localStorage.getItem("modpack_id");
    // xhttp.open("GET", "count_comments.php?video_id=<?php echo $_GET['video_id'] ?>", true);
    xhttp.open("GET", "modpack_tasks.php?modpack_id=" + modpack_id + "&status=" + status, true);
    xhttp.send();
}

// Load page
function LoadPage(page) {
    const urlParams = new URLSearchParams(window.location.search);
    const modpack_id = urlParams.get('modpack_id');

    const pages = {
        "description": "modpack_description.php",
        "bases": "modpack_bases.php",
        "images": "modpack_images.php",
        "mods": "modpack_mods.php",
        "notes": "modpack_notes.php",
        "tasks": "modpack_tasks.php",
        "videos": "modpack_videos.php"
    };

    const url = pages[page];
    if (!url) return; // Ak je stránka neplatná

    const xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
            document.querySelector(".list").innerHTML = xmlHttp.responseText;
        }
    };

    xmlHttp.open("GET", `${url}?modpack_id=${modpack_id}`, true);
    xmlHttp.send();
}

function search_mods(mod) {
    var xhttp = new XMLHttpRequest();
    // var search_text = document.getElementById("search_string").value;
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("categories_list").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "modpack_mod_search.php?mod=" + encodeURIComponent(mod), true);
    xhttp.send();
}

function popupSearchMod(mod) {
    var xhttp = new XMLHttpRequest();
    // var search_text = document.getElementById("search_string").value;
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(".popup_mods_list main").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "modpack_mod_search.php?mod=" + encodeURIComponent(mod), true);
    xhttp.send();
}


function saveImage(){
  console.log("save image");  
  const imageName = document.querySelector('#new_image input[name="image_name"]').value;
  const imageUrl = document.querySelector('#new_image input[name="image_url"]').value;
  const imageDescription = document.querySelector('#new_image textarea[name="image_description"]').value;
  var xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          alert("Image saved successfully!");
           document.querySelector('#new_image input[name="image_name"]').value="";
           document.querySelector('#new_image input[name="image_url"]').value="";
           document.querySelector('textarea[name="image_description"]').value="";
      }
     };
   data = "image_name="+encodeURIComponent(imageName)+"&image_url="+encodeURIComponent(imageUrl)+"&image_description="+encodeURIComponent(imageDescription)+"&modpack_id="+encodeURIComponent(localStorage.getItem("modpack_id"));
   xhttp.open("POST", "images_save.php", true);
   xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xhttp.send(data);
}

function GetLatestImageID() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      sessionStorage.setItem("latest_image_id", this.responseText);
    }
  };
  xhttp.open("GET", "images_get_latest_id.php", true);
  xhttp.send();
}


function saveNote(){
  const note = document.querySelector('#new_note textarea[name="note_text"]').value;
  var xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          alert("Note saved successfully!");
           document.querySelector('#new_note textarea[name="note_text"]').value="";
      }
     };
   data = "note="+encodeURIComponent(note)+"&modpack_id="+encodeURIComponent(localStorage.getItem("modpack_id"));
   xhttp.open("POST", "note_add.php", true);
   xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xhttp.send(data);
}

function addNewLink(link){
  var xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          document.querySelector('.dialog_add_new_link input[name="link_url"]').value="";
          document.querySelector(".dialog_add_new_link").close();
          alert("Link added successfully!");
      }
     };
   data = "link="+encodeURIComponent(link)+"&modpack_id="+encodeURIComponent(localStorage.getItem("modpack_id"));
   xhttp.open("POST", "modpack_mods_link_add.php", true);
   xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xhttp.send(data);
}

function isValidURL(str) {
  try {
    new URL(str); // ak je to neplatné, hodí chybu
    return true;
  } catch {
    return false;
  }
}

function filterModsByChar(char) {
  var xhttp = new XMLHttpRequest();
  const modpackId = sessionStorage.getItem("modpack_id");
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
       document.querySelector(".popup_mods_list main").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", `modpack_sort_mods_by_char.php?char=${char}`, true);
  xhttp.send();
}


function removeModFromModpack(modId,modpackId){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
       document.querySelector(".popup_mods_list main").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", `modpack_mod_remove.php?mod_id=${modId}&modpack_id=${modpackId}`, true);
  xhttp.send();
}


function addNewModpackBase(modpackId, base_name, base_description, coord_x, coord_y, coord_z) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
       // Refresh the bases content after adding
       LoadPage('bases');
    }
  };
  xhttp.open("POST", "base_add.php", true);
  const data = "modpack_id="+localStorage.getItem("modpack_id")+"&base_name="+encodeURIComponent(base_name)+"&base_description="+encodeURIComponent(base_description)+"&coord_x="+coord_x+"&coord_y="+coord_y+"&coord_z="+coord_z;
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(data);
}


function AddModtoMods(mod){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    /* if (this.readyState == 4 && this.status == 200) {
       document.querySelector(".popup_mods_list main").innerHTML = this.responseText;
    } */
  };
  xhttp.open("POST", "mod_add.php", true);
  const data = "mod="+encodeURIComponent(mod);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(data);
}

function addNewLinkName(link_name, linkId){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
       document.querySelector(".popup_mods_list main").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", `modpack_link_name_add.php?link_name=${link_name}&link_id=${linkkId}`, true);
  xhttp.send();
}

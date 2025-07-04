//var buttons_chars = buttonContainer_chars.getElementsByTagName('button');
var buttonContainer_chars = document.getElementById("letter_list");
var taskRadiosContainers = document.querySelectorAll('.task_view');
var imageRadiosContainers = document.querySelectorAll('.image_radios');
var popupModsListContainer = document.querySelector('.popup_mods_list main');
var new_note = document.getElementById("new_note");
var video_url = document.querySelector("input[name='video_url']");          
//wrapper
var list = document.querySelector(".list");





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
        if (!noteText || !noteHeader) {
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

    default:
        // handle other buttons
        break;
    }
    }
});

 

/* document.querySelector("input[name='video_title']").addEventListener("click", function(event){
    if(event.target.tagName==="INPUT"){
        alert("input");
    }
})


document.addEventListener("DOMContentLoaded", function () {
  const videoInput = document.querySelector("input[name='video_url']");
  if (videoInput) {
    videoInput.addEventListener("input", function () {
      getYouTubeVideoName();
      checkVideoExists(videoInput.value);
    });
  } else {
    console.warn("Input video_url not found.");
  }
}); */

  
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
                                            <span class="span_modpack">${modpackName}</span>
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



// Check if the container exists
if (popupModsListContainer) {
    // Add click event listener to the container
    popupModsListContainer.addEventListener('click', function(event) {
        // Check if the clicked element is a button
        if (event.target.tagName === 'BUTTON') {
            // Get the data-id attribute of the clicked button
            var dataId = event.target.getAttribute('data-id');

            // Check if the data-id attribute exists
            if (dataId) {
                // Add mod to modpack
                add_mod_to_modpack(dataId); // add mod(s) into a modpack list

                // Remove button
                var elementToRemove = document.querySelector('[data-id="' + dataId + '"]');
                if (elementToRemove) {
                    elementToRemove.remove();
                }

                // console.log('Clicked Button Data ID:', dataId);
            } else {
                // console.warn('Button has no data-id attribute');
            }
        }
    });
}

function reload_mods(modpack_id){
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
    var div = document.querySelector(".popup_mods_list");
    if (div.style.display === 'none') {
        div.style.display = 'flex';
    } else {
        div.style.display = 'none';
    }
}

function hide_popup() {
    var div = document.querySelector(".popup_mods_list");
    div.style.display = 'none';
}

function add_mod_to_modpack(mod_id) {
    var modpack_id = localStorage.getItem("modpack_id");

    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {}

    xhttp.open("POST", "modpack_add_mod.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var base_id = sessionStorage.getItem('base_id');
    // data = "&video_id=" + encodeURIComponent(video_id) + "&video_comment=" + encodeURIComponent(new_note);
    var data = "mod_id=" + encodeURIComponent(mod_id) + "&modpack_id=" + encodeURIComponent(modpack_id);
    console.log(data);
    xhttp.send(data);
    // xhttp.send("note_group="+group+"&note_text="+encodeURIComponent(text));
}

function sort_mods_by_char(char) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(".popup_mods_list main").innerHTML = this.responseText;
        }
    };
    // xhttp.open("GET", "count_comments.php?video_id=<?php echo $_GET['video_id'] ?>", true);
    xhttp.open("GET", "modpack_sort_mods_by_char.php?char=" + char, true);
    xhttp.send();
}

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

function popup_search_mod(mod) {
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
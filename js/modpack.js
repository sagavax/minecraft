//var buttons_chars = buttonContainer_chars.getElementsByTagName('button');
var buttonContainer_chars = document.getElementById("letter_list");
var taskRadiosContainers = document.querySelectorAll('.task_view');
var imageRadiosContainers = document.querySelectorAll('.image_radios');
var popupModsListContainer = document.querySelector('.popup_mods_list main');
//wrapper
var list = document.querySelector(".list");

window.onload = GetModpackName;

document.querySelector(".list").addEventListener("click", function(event) {
    const button = event.target.closest("button");
    if (button) {
        const urlParams = new URLSearchParams(window.location.search);
        const modpack_id = urlParams.get('modpack_id');
        sessionStorage.setItem("modpack_id", modpack_id);
        if (button.name === "add_new_ext_pic") {
            if (document.querySelector(`#new_image input[name="image_url"]`).value === "") {
                alert("Empty url");
            } else {
                saveImage();
            }
        //notes    
        } if(button.name==="vanilla"){
            //vanilla
        } else if (button.name === "modded"){
            //modded
        } else if (button.name === "all"){
            //all
        } else if (button.name === "add_note") {
           // showNewNote();
        } else if (button.name === "clear_search") {
            //clear search
        } else if (button.name==="attach_image"){
            //attach image
        } else if (button.name==="edit_note"){
           //edit note 
        } else if (button.name==="delete_note"){
          //delete note   
        } else if (button.name==="add_new_video"){
            //add video
        }
    }
});




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


/* 

// Attach a click event listener to each button
for (var i = 0; i < buttons_chars.length; i++) {
    buttons_chars[i].addEventListener('click', function() {
        // You can perform actions here when a button is clicked
        var chars_text = this.textContent || this.innerText;
        // alert(chars_text);
        sort_mods_by_char(chars_text);
    });
}
 */

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
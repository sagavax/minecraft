// document.getElementById("new_image_upload").style.display = "none";

window.onload = GetModpackName;

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

var taskRadiosContainers = document.querySelectorAll('.task_view');

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

var imageRadiosContainers = document.querySelectorAll('.image_radios');

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

var popupModsListContainer = document.querySelector('.popup_mods_list main');

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

var buttonContainer_chars = document.getElementById("letter_list");
// Get all buttons within the container
var buttons_chars = buttonContainer_chars.getElementsByTagName('button');

// Attach a click event listener to each button
for (var i = 0; i < buttons_chars.length; i++) {
    buttons_chars[i].addEventListener('click', function() {
        // You can perform actions here when a button is clicked
        var chars_text = this.textContent || this.innerText;
        // alert(chars_text);
        sort_mods_by_char(chars_text);
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

function LoadPage(page) {
    const urlParams = new URLSearchParams(window.location.search);
    const modpack_id = urlParams.get('modpack_id');

    var url;
    if (page === "description") {
        url = "modpack_description.php";
    } else if (page === "images") {
        url = "modpack_images.php";
    } else if (page === "mods") {
        url = "modpack_mods.php";
    } else if (page === "notes") {
        url = "modpack_notes.php";
    } else if (page === "tasks") {
        url = "modpack_tasks.php";
    } else if (page === "videos") {
        url = "modpack_videos.php";
    }

    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            document.querySelector(".list").innerHTML = this.responseText;
        }
    }

    xmlHttp.open("GET", url + "?modpack_id=" + modpack_id, true);
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

const mod_images = document.querySelector(".mod_images");
const mod_videos = document.querySelector(".mod_videos");

const mod_details = document.querySelector(".mod_details");

const mod_images_videos_tabs = document.querySelector(".mod_images_videos_tabs");
const mod_images_videos_wrap = document.querySelector(".mod_images_videos_wrap");

const save_image = document.querySelector("#dialog_new_image button[name='save_image']");
const save_video = document.querySelector("#dialog_new_video button[name='save_video']");


//hide videos
document.querySelector(".mod_videos").style.display="none";


//tabs
mod_images_videos_tabs.addEventListener("click",function(event){
    if(event.target.tagName==="BUTTON"){
        if(event.target.name==="mods_images"){
            document.querySelector(".mod_images").style.display="flex";
            document.querySelector(".mod_videos").style.display="none";
        }
        if(event.target.name==="mods_videos"){
            document.querySelector(".mod_images").style.display="none";
            document.querySelector(".mod_videos").style.display="flex";
        }
    }
})

//auto resize of textarea
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.querySelector('textarea[name="mod_description"]');
    autoResizeTextarea(textarea); // Správne volanie funkcie
});


//
let urlParams = new URLSearchParams(window.location.search);
    const mod_id = urlParams.get('mod_id');
    sessionStorage.setItem("mod_id",mod_id);

//
mod_images_videos_wrap.addEventListener("click", function(event) {
    if (event.target.tagName !== "BUTTON") return;

    const name = event.target.name;

    switch (name) {
        case "add_new_image":
            dialog_new_image.showModal();
            break;

        case "add_new_video":
            dialog_new_video.showModal();
            break;

        case "back_to_mods":
            window.location.href = "mods.php";
            break;

        case "reload_images":
            reloadImages();
            break;

        case "reload_videos":
            reloadVideos();
            break;

        case "delete_image":
            const ImageId = event.target.closest(".mod_image").getAttribute("image-id");
            deleteImage(ImageId);
            document.querySelector(`.mod_image [image-id="${ImageId}"]`)?.remove();
            break;

        default:
            // Optional: handle unknown button names
            console.warn("Unhandled button:", name);
    }
});


save_image.addEventListener("click", (event)=>{
    if(event.target.tagName === "BUTTON"){
        modAddImage();
        document.querySelector("#dialog_new_image").close();
    }
})

save_video.addEventListener("click", (event)=>{
    if(event.target.tagName === "BUTTON"){
        modAddVideo();
        document.querySelector("#dialog_new_video").close();
    }
})


mod_details.addEventListener("click",function(event){
    if(event.target.tagName==="INPUT" || event.target.tagName==="TEXTAREA"){
        event.target.removeAttribute('readonly');
    }
})


mod_details.addEventListener("focusout", function(event) {
    console.log("Event triggered on:", event.target);

    if (event.target.tagName === "INPUT") {
        event.target.setAttribute("readonly", true);
        console.log("Input element blurred with name:", event.target.name);

        if (event.target.name === "mod_name") {
            updateModName();
        } else if (event.target.name === "mod_url") {
            updateModUrl();
        }
    } else if (event.target.tagName === "TEXTAREA") {
        event.target.setAttribute("readonly", true);
        console.log("Textarea element blurred");
        updateModDescription();
    }
});




function modAddImage() {
    let urlParams = new URLSearchParams(window.location.search);
    const mod_id = urlParams.get('mod_id');
    const image_title= document.querySelector('input[name="image_title"]').value;
    const image_url = document.querySelector('input[name="image_url"]').value;
    
    console.log("title " + image_title);
    console.log("url " + image_url);

    if (image_title === "" && image_url === "") {
        alert("url  title cannot be empty");
        return; // Zastaví ďalšie vykonávanie funkcie, ak je popis prázdny
    }
    
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert("Update successful");
            document.querySelector('input[name="image_title"]').value="";
            document.querySelector('input[name="image_url"]').value="";
            document.querySelector("#dialog_new_image").close();            
            
            reloadImages()
        }
    };

    var data = "image_title=" + encodeURIComponent(image_title) + 
               "&image_url=" + encodeURIComponent(image_url) + 
               "&mod_id=" + encodeURIComponent(mod_id);
    
    console.log(data); // Na ladenie
    
    xhttp.open("POST", "categories_image_update.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}


function reloadImages() {
       const mod_id = sessionStorage.getItem("mod_id");
       var xhttp = new XMLHttpRequest();
       //var search_text=document.getElementById("search_string").value;
       xhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               document.querySelector(".mod_images main").innerHTML =
                   this.responseText;
           }
       };
       xhttp.open("GET", "categories_reload_images.php?mod_id=" + encodeURIComponent(mod_id), true);
       xhttp.send();

   }


   function modAddVideo(){
        let urlParams = new URLSearchParams(window.location.search);
    const mod_id = urlParams.get('mod_id');
    const video_title= document.querySelector('input[name="video_title"]').value;
    const video_url = document.querySelector('input[name="video_url"]').value;
    
    if (video_title === "" && video_url === "") {
        alert("url or title cannot be empty");
        return; // Zastaví ďalšie vykonávanie funkcie, ak je popis prázdny
    }
    
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert("Update successful");
            document.querySelector('input[name="video_title"]').value="";
            document.querySelector('input[name="video_url"]').value="";
    
            document.querySelector("#dialog_new_video").close();            
            // Prípadne pridaj nejakú vizuálnu spätnú väzbu pre používateľa
            //load noveho obrazku 
            reloadVideos()
        }
    };

    var data = "video_title=" + encodeURIComponent(video_title) + 
               "&video_url=" + encodeURIComponent(video_url) + 
               "&mod_id=" + encodeURIComponent(mod_id);
    
    console.log(data); // Na ladenie
    
    xhttp.open("POST", "categories_video_update.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send(data);
   }


  function updateModDescription() {
    const mod_id = sessionStorage.getItem("mod_id");
    const mod_description = document.querySelector('textarea[name="mod_description"]').value;
    const xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector('textarea[name="mod_description"]').setAttribute("readonly", true);
        }
    };

    var data = "mod_description=" + encodeURIComponent(mod_description) + 
               "&mod_id=" + encodeURIComponent(mod_id);
    
    console.log(data); // Na ladenie
    
    xhttp.open("POST", "category_description_update.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}

function updateModName() {
    const mod_id = sessionStorage.getItem("mod_id");
    const mod_name = document.querySelector('input[name="mod_name"]').value;
    const xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector('input[name="mod_name"]').setAttribute("readonly", true);
        }
    };

    var data = "mod_name=" + encodeURIComponent(mod_name) + 
               "&mod_id=" + encodeURIComponent(mod_id);
    
    console.log(data); // Na ladenie
    
    xhttp.open("POST", "category_name_update.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}

function updateModUrl() {
    const mod_id = sessionStorage.getItem("mod_id");
    const mod_url = document.querySelector('input[name="mod_url"]').value;  // Opravená premenná 'mod_url'
    const xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector('input[name="mod_url"]').setAttribute("readonly", true);
        }
    };

    var data = "mod_url=" + encodeURIComponent(mod_url) + 
               "&mod_id=" + encodeURIComponent(mod_id);
    
    console.log(data); // Na ladenie
    
    xhttp.open("POST", "category_url_update.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}

function autoResizeTextarea(textarea) {
    textarea.style.height = 'auto'; // Resetovať výšku
    textarea.style.height = (textarea.scrollHeight+2) + 'px'; // Nastaviť na dynamickú výšku
}


function reloadVideos(){
    const mod_id = sessionStorage.getItem("mod_id");
    var xhttp = new XMLHttpRequest();
    //var search_text=document.getElementById("search_string").value;
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(".mod_videos main").innerHTML =
                this.responseText;
        }
    };
    xhttp.open("GET", "categories_reload_videos.php?mod_id=" + encodeURIComponent(mod_id), true);
    xhttp.send();
}

function deleteImage(imageId){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert("Image has been removed!");
            reloadImages()
        }
    };
    xhttp.open("POST", "categories_image_delete.php", true);
    var data = "image_id=" + encodeURIComponent(imageId);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}
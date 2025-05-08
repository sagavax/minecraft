const new_image_container = document.querySelector(".modification header");
const save_image = document.querySelector(".action");
const mod_details = document.querySelector(".mod_details");


document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.querySelector('textarea[name="mod_description"]');
    autoResizeTextarea(textarea); // Správne volanie funkcie
});



let urlParams = new URLSearchParams(window.location.search);
    const mod_id = urlParams.get('mod_id');
    sessionStorage.setItem("mod_id",mod_id);

new_image_container.addEventListener("click", (event)=>{
    if(event.target.tagName === "BUTTON"){
        if(event.target.name==="add_new")
        dialog_new_image.showModal();
    } 

    if (event.target.name==="reload"){
        reload_images();
    }

    if (event.target.name==="back_to_mods"){
        window.location.href = "mods.php";
    }
})


save_image.addEventListener("click", (event)=>{
    if(event.target.tagName === "BUTTON"){
        mod_add_image();
    }
})


mod_details.addEventListener("click",function(event){
    if(event.target.tagName==="INPUT" || event.target.tagName==="TEXTAREA"){
        event.target.removeAttribute('readonly');
    }
})

/*mod_details.addEventListener("blur", function(event) {
    if (event.target.tagName === "INPUT") {
        event.target.setAttribute("readonly", true);
        if (event.target.name === "mod_name") {
            update_mod_name();
        } else if (event.target.name === "mod_url") {
            update_mod_url();
        }
    } else if (event.target.tagName === "TEXTAREA") {
        event.target.setAttribute("readonly", true);
        update_mod_description();
    }
});*/


mod_details.addEventListener("focusout", function(event) {
    console.log("Event triggered on:", event.target);

    if (event.target.tagName === "INPUT") {
        event.target.setAttribute("readonly", true);
        console.log("Input element blurred with name:", event.target.name);

        if (event.target.name === "mod_name") {
            update_mod_name();
        } else if (event.target.name === "mod_url") {
            update_mod_url();
        }
    } else if (event.target.tagName === "TEXTAREA") {
        event.target.setAttribute("readonly", true);
        console.log("Textarea element blurred");
        update_mod_description();
    }
});




function mod_add_image() {
    let urlParams = new URLSearchParams(window.location.search);
    const mod_id = urlParams.get('mod_id');
    const image_title= document.querySelector('input[name="image_title"]').value;
    var image_url = document.querySelector('input[name="image_url"]').value;
    

    if (image_url === "") {
        alert("url cannot be empty");
        return; // Zastaví ďalšie vykonávanie funkcie, ak je popis prázdny
    }
    
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert("Update successful");
            image_url="";
            document.querySelector("#dialog_new_image").close();            
            // Prípadne pridaj nejakú vizuálnu spätnú väzbu pre používateľa
            //load noveho obrazku 
            reload_images()
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


function reload_images() {
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

  function update_mod_description() {
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

function update_mod_name() {
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

function update_mod_url() {
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

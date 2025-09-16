const gallery_wrap = document.querySelector(".gallery_wrap");
const gallery_item = document.querySelector(".gallery_item");
const image_full_view = document.querySelector(".image_full_view"); //image_full_view

const modal_change_modpack = document.querySelector(".modal_change_modpack"); 

const modal_change_gallery = document.querySelector(".modal_change_gallery");
const modal_change_gallery_input = document.querySelector(".modal_change_gallery input");
const modal_change_gallery_close_button = document.querySelector(".modal_change_gallery button[name='close_gallery_modal']");

const modal_new_gallery = document.querySelector(".modal_new_gallery");
const modal_new_gallery_input = document.querySelector(".modal_new_gallery input[name='gallery_name']");
const modal_new_gallery_textarea = document.querySelector(".modal_new_gallery textarea[name='gallery_description']");
const modal_new_gallery_select = document.querySelector(".modal_new_gallery select[name='gallery_category']");

const add_new_image = document.querySelector(".add_new_image");
const image_url_input = document.querySelector(".add_new_image input[name='image_url']");

const image_galleries = document.querySelector(".image_galleries");

add_new_image.addEventListener("click", function(event){
  if(event.target.tagName==="BUTTON"){
    if(event.target.name==="add_new_ext_pic"){
      saveImage();
    }
  }
})


image_url_input.addEventListener("input", function(event) {
  checkImageExists(image_url_input.value);
}) 

image_url_input.addEventListener("dragover", function(event) {
event.target.style.backgroundColor = "#d2f9be82";
console.log("drag over");
})

image_url_input.addEventListener("dragleave", function(event) {
image_url_input.style.backgroundColor = "#eff3f4";
})

image_url_input.addEventListener("drop", function(event) {
image_url_input.style.backgroundColor = "#eff3f4";
})

modal_new_gallery.addEventListener("click", function(event) {
  if(event.target.tagName === "BUTTON" && event.target.name==="create_gallery"){
    if(modal_new_gallery_input.value===""){
      ShowMessage("Please enter a name for the gallery.");
      return
    } else {

      checkIfGalleryExists(modal_new_gallery_input.value);
      if(checkIfGalleryExists(modal_new_gallery_input.value)){
        ShowMessage("Gallery with this name already exists.");
        return;
      } else {
        createNewGallery();  
      }
      
    }
    //console.log("Volám createNewGallery()");
    //createNewGallery();
  } else if(event.target.tagName === "BUTTON" && event.target.name==="close_modal"){
    document.querySelector(".modal_new_gallery textarea[name='gallery_description']").value = "";
    document.querySelector(".modal_new_gallery input[name='gallery_name']").value = "";
    modal_new_gallery.close();
  }
});


image_galleries.addEventListener("click", function(event) {
  if (event.target.tagName === "BUTTON"){
    if(event.target.name==="all_galleries"){
      reloadGalleries();
    } else if (event.target.name==="add_new_gallery"){
     modal_new_gallery.showModal();
    } else if (event.target.name==="modpacks_galleries"){
      loadModpacksGalleries();
    } else if (event.target.name==="vanilla_galleries"){
      loadVanillaGalleries();
    } else if (event.target.name==="reload_galleries"){
      loadAllGalleries();
    } else if (event.target.name==="new_gallery"){
      modal_new_gallery.show();
    } 
  }
  if (event.target.tagName === "DIV" && event.target.hasAttribute("gallery-id")) {
    const galleryId = event.target.getAttribute("gallery-id");
    sessionStorage.setItem("galery_id", galleryId);
    window.location.href = "gallery.php?gallery_id="+galleryId;
  } else if (event.target.tagName === "DIV" && event.target.classList.contains("gallery_name")) {
    const nameEl = event.target;
    const galleryId = nameEl.closest(".gallery_list_item").getAttribute("gallery-id");
    ShowImagesByGallery(galleryId);
    //alert("klikol som na galeriu.");
   /*  const originalName = nameEl.innerText.trim();

    nameEl.contentEditable = "true";
    nameEl.focus();

    nameEl.addEventListener("blur", function saveOnBlur() {
        nameEl.contentEditable = "false";
        nameEl.removeEventListener("blur", saveOnBlur);

        const newName = nameEl.innerText.trim();

        if (newName && newName !== originalName) {
            updateGalleryName(galleryId, newName);
        } else {
            nameEl.innerText = originalName;
        } 
    });*/
    
  } else if(event.target.tagName === "DIV" && event.target.classList.contains("gallery_remove")) {
    const galleryId = event.target.closest(".gallery_list_item").getAttribute("gallery-id");
    console.log(galleryId);
    deleteGallery(galleryId);
  }
});


gallery_wrap.addEventListener("contextmenu", (event) => {
  event.preventDefault(); // riešiš tu

  const target = event.target;
  if (target.tagName?.toLowerCase() !== "img") return;

  const galleryItem = target.closest(".gallery_item");
  if (!galleryItem) return;

  const imageId = galleryItem.id;
  CreateContextMenu(event, imageId);
});


gallery_wrap.addEventListener("click", function(event) {
    const target = event.target;

    // Klik na obrázok v galérii
    if (target.tagName.toLowerCase() === "img") {
        const galleryItem = target.closest(".gallery_item");
        const image_id = galleryItem.id;

        sessionStorage.setItem("picture_id", image_id);

        window.location.href = `image.php?image_id=${image_id}`;

        /* const image_full_view = document.querySelector(".image_full_view");
        const image_tag = image_full_view.querySelector("img");
        const image_name = image_full_view.querySelector(".image-name");

        // Vyčisti predchádzajúci obrázok
        image_tag.src = "";
        image_name.textContent = "";

        image_full_view.showModal();

        // Ak modal naozaj otvorený
        if (image_full_view.open) {
            fetch(`gallery_image_detail.php?image_id=${image_id}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(image => {
                        image_tag.src = image.picture_path;
                        image_name.textContent = image.picture_title;
                    });
                })
                .catch(error => {
                    console.error("Chyba pri načítaní obrázka:", error);
                });
        } */
    }

    // Klik na tlačidlo (pridanie komentára)
    if (target.tagName.toLowerCase() === "button" && target.name === "add_comment") {
        console.log("add comment");
       /*  const comment_input = document.querySelector(".input-container input");

        if (comment_input.value.trim() !== "") {
            addComment(comment_input.value.trim());
            comment_input.value = "";
        } else {
            alert("Please enter any comment");
            comment_input.style.border = "2px solid red";
            setTimeout(() => {
                comment_input.style.border = "1px solid #d1d1d1";
            }, 2000);
        } */
    }
});



/* image_full_view.addEventListener("click", function(event) {
    if (event.target.tagName.toLowerCase() === "img") {
        image_full_view.close();
    } 

    if(event.target.classList.contains("image-name")){
        const imageId = sessionStorage.getItem("picture_id"); 
        const picture_name = document.querySelector(".image_full_view .image-name");
        picture_name.setAttribute("contenteditable", "true");
        picture_name.focus();
           
        picture_name.onblur = function() {
        const new_image_name = picture_name.innerHTML;
        const old_image_name = sessionStorage.getItem("picture_name");
        if(new_image_name!==old_image_name){
            saveImageName(stripiHtml(picture_name.innerHTML), imageId);  
        } 
        picture_name.contentEditable = false;
        };
        }
}) */


function checkImageExists(imageUrl) {
  const xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function () {
      if (this.readyState === 4 && this.status === 200) {
          if (this.responseText === "true") {
              ShowMessage("Image already exists!");

              const inputField = document.querySelector(".add_new_image input[name='image_url']");
              inputField.style.border = "2px solid red";

              setTimeout(() => {
                  inputField.style.border = "1px solid #d1d1d1";
                  inputField.value = "";
              }, 3000);
          } else {
              const inputField = document.querySelector(".add_new_image input[name='image_url']");
              inputField.style.border = "2px solid green";

              setTimeout(() => {
                  inputField.style.border = "1px solid #d1d1d1";
              }, 3000);
          }
      }
  };

  xhttp.open("GET", "images_check.php?image_url=" + encodeURIComponent(imageUrl), true);
  xhttp.send();
}


function addTagToImage(tagId){
  var xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          ShowMessage("Tag added successfully!");
      }
     };
   data = "image_id="+sessionStorage.getItem('image_id')+"&tag_id="+tagId;
   xhttp.open("POST", "image_add_tag.php", true);
   xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xhttp.send(data);
}

function sortImagesTagsByLetters(letterButton){
  const xhttp = new XMLHttpRequest();

  // Define what happens on successful data submission
  xhttp.onreadystatechange = function() {
      // Check if the request is complete and was successful
      if (this.readyState == 4 && this.status == 200) {
          // Show a message when the export is successful
          //ShowMessage("Videos tags have been sorted ...");
          document.querySelector(".tags_list").innerHTML = this.responseText;
      }
  };

  // Configure the request
  xhttp.open("POST", "image_tags_sort_by_letters.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  // You need to define the `data` variable before calling `exportCSV()`
  // For example:
  var data = "letter="+letterButton;
  // Send the request with data (assuming `data` is defined elsewhere)
  xhttp.send(data);
}

function savetoImageTagList(tagId, imageId){
  var xhttp = new XMLHttpRequest();
  console.log("image id:"+imageId+", tag id: "+tagId);
  // Check the state of the AJAX request
  xhttp.onreadystatechange = function() {
      // Check if the request is complete and was successful
      if (this.readyState == 4 && this.status == 200) {
          // Show a message when the export is successful
          ShowMessage("tags has been added successfully!");
      }
  };

  // Configure the request
  xhttp.open("POST", "image_tag_save.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  // You need to define the `data` variable before calling `exportCSV()`
  // For example:
   var data = "tag_id="+tagId+"&image_id="+imageId;

  // Send the request with data (assuming `data` is defined elsewhere)
  xhttp.send(data);
}

function stripiHtml(text) {
    // Vytvorí dočasný element, ktorý spracuje HTML ako text
    let div = document.createElement("div");
    div.innerHTML = text;
    return div.textContent || div.innerText || "";
}

function addComment(imageId, commentText){
  console.log(imageId);
   var xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          ShowMessage("Comment added successfully!");
         modal_add_new_comment.close();
      }
     };
   data = "image_id="+imageId+"&comment_text="+commentText;
   xhttp.open("POST", "image_comment_add.php", true);
   xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xhttp.send(data);

}

function saveImage() {
  const imageName = document.querySelector('.add_new_image input[name="image_name"]').value;
  const imageUrl = document.querySelector('.add_new_image input[name="image_url"]').value;
  const imageDescription = document.querySelector('textarea[name="image_description"]').value;

  const xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      ShowMessage("Image saved successfully!");

      // Vyčistiť formulár
      document.querySelector('.add_new_image input[name="image_name"]').value = "";
      document.querySelector('.add_new_image input[name="image_url"]').value = "";
      document.querySelector('textarea[name="image_description"]').value = "";

      // Zavolajme hneď po uložení funkciu na získanie ID
      fetchLatestImageIDAndInsert(imageName, imageUrl);
    }
  };

  const data = 
    "image_name=" + encodeURIComponent(imageName) +
    "&image_url=" + encodeURIComponent(imageUrl) +
    "&image_description=" + encodeURIComponent(imageDescription);

  xhttp.open("POST", "images_save.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(data);
}

function fetchLatestImageIDAndInsert(imageName, imageUrl) {
  const xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      const imageID = this.responseText;

      // Prípadne definuj tieto premenné, ak ich potrebuješ z niekadiaľ:
      const modpackID = "";   // ← sem si daj správne ID
      const modpackName = ""; // ← a tu názov modpacku, ak je dostupný

      const imageList = document.querySelector('#picture_list');
      const html = `
        <div class="picture" image-id="${imageID}">
          <div class="picture_name">${imageName}</div>
          <div class="pic" image-id="${imageID}">
            <img src="${imageUrl}" alt="${imageName}">
          </div>
          <div class="picture_footer">
            <div class="picture_action" image-id="${imageID}">
              <button class="button blue_button" modpack-id="${modpackID || 2}" name="image_modpack" type="button">${modpackName || "Vanilla Minecraft"}</button>
              <button class="button small_button" name="add_tag" type="button"><i class="fas fa-tag"></i></button>
              <button class="button small_button" name="add_comment" type="button"><i class="fa fa-comment"></i></button>
              <button class="button small_button" name="view_image" type="button"><i class="fa fa-eye"></i></button>
              <button class="button small_button" name="delete_image" type="button"><i class="fa fa-times"></i></button>
            </div>
          </div>
        </div>
      `;

      imageList.insertAdjacentHTML("afterbegin", html);
    }
  };

  xhttp.open("GET", "images_get_latest_id.php", true);
  xhttp.send();
}


function loadLatestImage(){
  const latestImageId = sessionStorage.getItem("latest_image_id");
  if(latestImageId){
    const image = document.querySelector(".picture[image-id='"+latestImageId+"']");
    if(image){
      image.scrollIntoView({behavior: "smooth"});
    }
  }
}


function saveImageName(new_name,image_id){
  console.log(new_name);
  const xhttp = new XMLHttpRequest();
      xhttp.onload = function() {
       ShowMessage("Image name has been changed!");  
      }
      
    xhttp.open("POST", "picture_name.php",true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var data = "image_id="+encodeURIComponent(image_id)+"&picture_title="+encodeURIComponent(new_name);                
    xhttp.send(data);
}

function stripiHtml(text) {
    // Vytvorí dočasný element, ktorý spracuje HTML ako text
    let div = document.createElement("div");
    div.innerHTML = text;
    return div.textContent || div.innerText || "";
}

 function addComment() {
      var commentText = document.querySelector(".input-container input").value;
      var comment_text = encodeURIComponent(commentText);
      if (comment_text === "") {
        alert("Please enter any comment");
        document.querySelector(".input-container input").style.border = "3px solid red";
        setTimeout(() => {
          document.querySelector(".input-container input").style.border = "1px solid #d1d1d1";
        }, 2000);
        return false;
      } else {
        var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
         if (this.readyState == 4 && this.status == 200) {
            alert("Komment bol vytvoreny!");
            count_comments();
            //div_delete = querySelectorAll()
            //reload_comments();
          }
        };
      var image_id = sessionStorage.getItem("picture_id"); //get image idd  
      data = "commentText="+decodeURIComponent(comment_text)+ "&image_id="+decodeURIComponent(image_id);
      xhttp.open("POST", "image_comment_create.php", true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send(data);

      var comments = document.getElementById("image_comments");
      var div_comment = document.createElement("div");
      div_comment.classList.add("comment");
      
      // Fetch the maximum comment ID from the server
      fetch("picture_get_max_comment_id.php?picture_id=" + image_id)
          .then(response => response.json())
          .then(data => {
             
      // Set the 'data-id' attribute of the 'div_comment' element to the fetched data (max comment ID)
            div_comment.setAttribute("data-id", data);

            // Create a new div element to wrap the comment text
            var divCommentWrap = document.createElement("div");
            // Add the class 'comment_text' to the newly created div
            divCommentWrap.classList.add("comment_text");
            // Append the comment text wrapper to the main comment div
            div_comment.appendChild(divCommentWrap);
            // Set the text content of the comment text wrapper to the provided comment text
            divCommentWrap.textContent = comment_text;

            // Create a new div element to wrap the footer of the comment (e.g., for action buttons)
            var divFooterWrap = document.createElement("div");
            // Add the class 'comment_footer' to the footer wrapper
            divFooterWrap.classList.add("comment_footer");
            // Append the footer wrapper to the main comment div
            div_comment.appendChild(divFooterWrap);

            // Create a button element for removing the comment
            var btnRemoveComment = document.createElement("button");
            // Add the classes 'button' and 'small_button' to the remove button
            btnRemoveComment.classList.add("button", "small_button");
            // Set the inner HTML of the remove button to an icon (font-awesome times icon)
            btnRemoveComment.innerHTML = "<i class='fa fa-times'></i>";
            // Append the remove button to the footer wrapper
            divFooterWrap.appendChild(btnRemoveComment);

            // Append the complete comment div to the comments section
            comments.appendChild(div_comment);

            // Clear the comment input field after adding the comment
            comment_input.value = "";
                })
          .catch(error => {
              console.error("Error fetching max comment ID:", error);
          });
          
      }
      
      //div_del_comment.onclick = function(){ alert(this.getAttribute("data-id"));};
    }


function createNewGallery(){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      ShowMessage("Gallery created successfully!");
      modal_new_gallery.close();
      document.querySelector(".image_galleries_list").insertAdjacentHTML("afterbegin", "<button class='button small_button gallery_button'>"+modal_new_gallery_input.value+"</button>");
    }
  };
  data = "gallery_name="+encodeURIComponent(modal_new_gallery_input.value)+"&gallery_description="+encodeURIComponent(modal_new_gallery_textarea.value)+"&gallery_category="+encodeURIComponent(modal_new_gallery_select.value);
  xhttp.open("POST", "gallery_create.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(data);
}

function checkIfGalleryExists(galleryName) {
  const galleryList = document.querySelector(".image_galleries_list"); // nebo '#image_galleries_list', záleží na vašem HTML
  if (!galleryList) return false;

  const buttons = galleryList.querySelectorAll("button");
  for (let button of buttons) {
    if (button.innerText === galleryName) {
      return true;
    }
  }
  return false;
}

function loadAllGalleries(){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.querySelector(".image_galleries_list").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "pictures_gallery_list.php", true);
  xhttp.send();
}

function ShowImagesByGallery(galleryId){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.querySelector(".gallery_wrap").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "pictures_by_gallery.php?gallery_id="+galleryId, true);
  xhttp.send();
}


function deleteGallery(galleryId) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          ShowMessage("Gallery has been deleted successfully!");
          document.querySelector(".image_galleries_list .gallery_list_item").remove(); // ← tu si mazas element image_galleries_list
          //reloadGalleries();
      }
  };
  var data = "gallery_id=" + galleryId;
  xhttp.open("POST", "gallery_delete.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(data);
}

function loadVanillaGalleries(){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.querySelector(".image_galleries_list").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "pictures_vanilla_galleries.php", true);
  xhttp.send();
}

function loadModpacksGalleries(){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.querySelector(".image_galleries_list").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "pictures_modpacks_galleries.php", true);
  xhttp.send();
}


function updateGalleryName(galleryId, galleryName){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.querySelector(".image_galleries_list").innerHTML = this.responseText;
    }
  };
  var data = "gallery_id=" + galleryId + "&gallery_name=" + encodeURIComponent(galleryName);
  xhttp.open("POST", "pictures_gallery_name_update.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(data);
}

function reloadGalleries(){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.querySelector(".image_galleries_list").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "pictures_all_galleries.php", true);
  xhttp.send();
}


function CreateContextMenu(event, imageId) {
  console.log("=== CreateContextMenu Debug ===");
  console.log("Event type:", typeof event);
  console.log("Event object:", event);
  console.log("clientX:", event?.clientX);
  console.log("clientY:", event?.clientY);
  console.log("pageX:", event?.pageX);
  console.log("pageY:", event?.pageY);
  console.log("ImageId:", imageId);
  console.log("==============================");
  
  // NAJPRV odstráň staré menu + vyčisti event listenery
  const oldMenu = document.querySelector(".custom-context-menu");
  if (oldMenu) {
    console.log("Removing old menu");
    oldMenu.remove();
    document.onclick = null;
    document.onkeydown = null;
  }

  // Vytvor menu
  const menu = document.createElement("div");
  menu.className = "custom-context-menu";
  
  const options = ["View", "Delete", "Add to gallery", "Delete from gallery"];
  
  options.forEach(label => {
    const item = document.createElement("div");
    item.className = "context-menu-item";
    item.textContent = label;
    
    item.onclick = () => {
      if (label === "View") {
        sessionStorage.setItem("picture_id", imageId);
        window.location.href = `image.php?image_id=${imageId}`;
      } else if (label === "Delete") {
        removeImage(imageId);
      } else if (label === "Add to gallery") {
        sessionStorage.setItem("image_id", imageId);
        modal_change_gallery?.showModal?.();
      } else if (label === "Delete from gallery") {
        const galleryId = sessionStorage.getItem("gallery_id");
        if (galleryId) removeImageFromGallery(imageId, galleryId);
      }
      menu.remove();
    };
    
    menu.appendChild(item);
  });

  // Pozícia a zobrazenie (s fallback ak nie sú súradnice)
  if (event && event.clientX !== undefined) {
    menu.style.left = event.clientX + "px";
    menu.style.top = event.clientY + "px";
  } else {
    // Ak nie je event, zobraz v strede obrazovky
    menu.style.left = (window.innerWidth / 2) + "px";
    menu.style.top = (window.innerHeight / 2) + "px";
  }
  document.body.appendChild(menu);

  // Zatvor pri kliknutí mimo alebo ESC
  setTimeout(() => {
    document.onclick = () => {
      menu.remove();
      document.onclick = null;
      document.onkeydown = null;
    };
    
    document.onkeydown = (e) => {
      if (e.key === 'Escape') {
        menu.remove();
        document.onclick = null;
        document.onkeydown = null;
      }
    };
  }, 10);
}
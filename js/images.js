var pictures_name = document.querySelectorAll('.picture_name');
var picture_list = document.querySelector("#picture_list");        
const upload_image = document.getElementById("upload_image");
const drag_and_drop = document.getElementById("drag_and_drop");
//var picture_modpacks = document.querySelector(".picture_modpacks");
var modal_change_modpack = document.querySelector(".modal_change_modpack"); 
var image_url_input = document.querySelector(".add_new_image input[name='image_url']")     
document.getElementById("upload_external_image").style.display="block";
var modal_new_tags = document.querySelector(".modal_new_tags");
var  pictures_images = document.querySelectorAll('.pic');
const external_image_form = document.getElementById('upload_external_image'); // Nahraďte 'external_image_form' ID vášho formulára

// Potom pridajte event listener
if (external_image_form) {
  external_image_form.addEventListener("submit", function(event) {
    // Ak chcete zobraziť len upozornenie a potom odoslať formulár:
    // V tomto prípade nebráňte predvolenému odoslaniu
    ShowMessage("Obrazok sa ulozil.");
    //alert("Obrazok sa ulozil.");
        // Formulár sa automaticky odošle po potvrdení upozornenia
    // Nemusíte volať external_image_form.submit();
    
    // ALEBO ak chcete plnú kontrolu nad odoslaním:
    
    event.preventDefault(); // Zabráňte predvolenému odoslaniu
    
    // Tu môžete pridať validáciu alebo iné operácie
    
    // A potom manuálne odošlite formulár s menším oneskorením 
    //aby sa upozornenie stihlo zobraziť a spracovať
    setTimeout(function() {
      external_image_form.submit();
    }, 3000);
    
  });
} else {
  console.error("Formulár nebol nájdený! Skontrolujte ID formulára.");
}

//sessionStorage.setItem("picture_id",imageId);

image_url_input.addEventListener("input", function(event) {
  console.log("image url input changed");
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

/* picture_modpacks.addEventListener("click", function(event){
  if (event.target.tagName === "BUTTON"){
    modal_change_modpack.showModal();
  }
}); */


modal_change_modpack.addEventListener("click", function(event) {
  // Skontrolujeme, či kliknutie bolo na tlačidlo s atribútom 'modpack-id'
if (event.target.tagName === "BUTTON" && event.target.hasAttribute("modpack-id")) {
    const modpackId = event.target.getAttribute("modpack-id"); 
    const modpackName = event.target.innerText;
    const imageId = sessionStorage.getItem("image_id");
    //degugg
    console.log("Modpack name:", modpackName); // Alebo alert, ak preferuješ
    console.log("Modpack ID:", modpackId); // Alebo alert, ak preferuješ
    console.log("image id:", imageId);
    // change modpack
    imageChangeModpack(imageId, modpackId,modpackName);
}
});



function check_url(){
const url = document.getElementById("image_url").value;
console.log(url);
if(url!==null || url!==""){
  //alert(url);   
  return false;
} else {
//alert("Empty url");
return false;
}

return true;
}


picture_list.addEventListener("click", function(event) {
  
  
  if (event.target.tagName === "BUTTON") {
    let buttonName = event.target.name; // <- deklarace pomocí let
    var imageId = event.target.closest(".picture").getAttribute("image-id");
    if (buttonName === "add_tag") {
      //AddImageTag(imageId);
      modal_new_tags.showModal();
    } else if (buttonName === "view_image") {
      viewImage(imageId);
    } else if (buttonName === "add_comment") {
      addComment(imageId);
    } else if (buttonName === "delete_image") {
      removeImage(imageId);
    } else if (buttonName === "image_modpack") {
      sessionStorage.setItem("image_id",imageId);var imageId = event.target.closest(".picture_action").getAttribute("image-id");
      modal_change_modpack.showModal();
    }
  }
});

picture_list.addEventListener("dblclick", function(event) {
  if (event.target.tagName === "DIV" && event.target.classList.contains("picture_name")) {
    var picture_name = event.target;
    var imageId = picture_name.closest(".picture").getAttribute("image-id");
    picture_name.contentEditable = true;

    picture_name.onblur = function() {
      saveImageName(stripiHtml(picture_name.innerHTML), imageId);
      picture_name.contentEditable = false;
    };
  }
});



modal_new_tags.addEventListener("click", function(event) {
  if (event.target.tagName === "BUTTON") {
   if(event.target.name==="add_new_tag"){
    var  tagId = event.target.getAttribute("tag-id");
    var imageId = sessionStorage.getItem("image_id");
     console.log(tagId,imageId);
    savetoImageTagList(tagId, imageId);
   } else if (event.target.name==="letter"){
     var letterButton = event.target.innerText;
     sortImagesTagsByLetters(letterButton);
   }
  }
});


function saveImageName(new_name,image_id){
  console.log(new_name);
  const xhttp = new XMLHttpRequest();
      xhttp.onload = function() {

      }
      
    xhttp.open("POST", "picture_name.php",true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var data = "image_id="+encodeURIComponent(image_id)+"&picture_title="+encodeURIComponent(new_name);                
    xhttp.send(data);
}


function AddImageTag(imageId){
console.log(imageId);
}

function removeImage(imageId){
console.log(imageId);
const xhttp = new XMLHttpRequest();
      xhttp.onload = function() {
        alert("image has been removed");
        document.querySelector('.picture[image-id="'+imageId+'"]').remove();
      }
      
    xhttp.open("POST", "picture_remove.php",true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var data = "image_id="+encodeURIComponent(imageId);                
    xhttp.send(data);
}

function viewImage(imageId){

window.location.href="image.php?image_id="+imageId;
}

function addComment(imageId){
console.log(imageId);
}

function saveExternalImage() {
const image_name = document.querySelector('input[name="image_name"]').value;
const image_url = document.querySelector('input[name="image_url"]').value;
const modpack_id = document.querySelector('input[name="modpack_id"]').value;
const image_description = document.querySelector('textarea[name="image_description"]').value;

const xhttp = new XMLHttpRequest();
xhttp.onload = function() {
  alert("Image has been uploaded"); 
};

xhttp.open("POST", "images_add_ext_image.php", true);
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
var data = "image_name=" + encodeURIComponent(image_name) + 
          "&image_url=" + encodeURIComponent(image_url) + 
          "&image_description=" + encodeURIComponent(image_description) + 
          "&modpack_id=" + encodeURIComponent(modpack_id);
          
xhttp.send(data);

return false; // ZASTAVÍ normálne odoslanie formulára
}




function imageChangeModpack(imageId, modpackId, modpackName) {
var xhttp = new XMLHttpRequest();

// Prepare the data before the request
xhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
      alert("Modpack zmenený!");
      //document.querySelector(`.bug[bug-id='${bugId}'] .bug_footer .bug_text`)
      document.querySelector(`.picture_action[image-id='${imageId}'] button`).innerText = modpackName;
      modal_change_modpack.close();
  }
}

// Send the request
xhttp.open("POST", "images_modpack_change.php", true);
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
var data = "image_id=" + imageId + "&modpack_id=" + modpackId;
xhttp.send(data);
}


function checkImageExists(imageUrl){
const xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200) {
  if(this.responseText==="true"){
    ShowMessage("Image already exists!");
    //alert("Image already exists!");  
        document.querySelector(".add_new_image input[name='image_url']").value="";
  }  
}
}
xhttp.open("GET", "images_check.php?image_url="+encodeURIComponent(imageUrl), true);
xhttp.send(); 
}

function addTagToImage(tagId){
  var xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         alert("Tag pridaný!");
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

              
         const upload_image = document.getElementById("upload_image");
         const external_image = document.getElementById("upload_external_image");
         const drag_and_drop = document.getElementById("drag_and_drop");
         //var picture_modpacks = document.querySelector(".picture_modpacks");
         var modal_change_modpack = document.querySelector(".modal_change_modpack"); 
         var image_url_input = document.querySelector(".add_new_image input[name='image_url']")     
         document.getElementById("upload_external_image").style.display="block";
         //document.getElementById("drag_and_drop").style.display="none";

      
         //sessionStorage.setItem("picture_id",imageId);

         image_url_input.addEventListener("input", function(event) {
           console.log("image url input changed");
           checkImageExists(image_url_input.value);
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
              const imageId = sessionStorage.getItem("picture_id");
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


var  pictures_images = document.querySelectorAll('.pic');

// Add event listener to each button
pictures_images.forEach(function(pictures_image) {
  pictures_image.addEventListener('click', function() {
      var imageDivValue = this.closest("div.picture").getAttribute("image-id");
      //console.log(imageDivValue);
      window.location.href="image.php?image_id="+imageDivValue;

  });
});


var image_action = document.querySelector("#picture_list");
image_action.addEventListener("click", function(event) {
  var imageId = event.target.closest(".picture_action").getAttribute("image-id");
  
  if (event.target.tagName === "BUTTON") {
    buttonName = event.target.name;
  } else if (event.target.tagName === "I") {
    buttonName = event.target.closest("BUTTON").name;
  }

  if (buttonName === "add_tag") {
    AddImageTag(imageId);
  } else if (buttonName === "view_image") {
    viewImage(imageId);
  } else if (buttonName === "add_comment") {
    addComment(imageId);
  } else if (buttonName === "delete_image") {
    removeImage(imageId);
  } else if (buttonName === "image_modpack") {
    modal_change_modpack.showModal();
  }
});


var  pictures_name = document.querySelectorAll('.picture_name');
// Add event listener to each button
pictures_name.forEach(function(picture_name) {
  picture_name.addEventListener('dblclick', function() {
    // Get the name attribute of the clicked button
     var closestDiv = picture_name.closest('.picture');
      var imageId = closestDiv.getAttribute('image-id');
    //if(buttonName==="picture_delete"){
      console.log("clicked on header");
    picture_name.contentEditable = true;
    
     picture_name.onblur =  function() {
    save_image_name(picture_name.innerHTML,imageId);
    picture_name.contentEditable = false;
    }
  });
});


function save_image_name(new_name,image_id){
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

function save_external_image(){
   const image_name = document.querySelector('input[name="image_name"]').value;
   const image_url = document.querySelector('input[name="image_url"]').value;
   const modpack_id = document.querySelector('input[name="modpack_id"]').value;
   const image_description = document.querySelector('textarea[name="image_description"]').value;
   const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            alert("image has been upoloaded"); 
          }
          
    xhttp.open("POST", "images_add_ext_image.php",true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var data = "image_name="+encodeURIComponent(image_name)+"&image_url="+encodeURIComponent(image_url)+"&image_description="+encodeURIComponent(image_description)+"&modpack_id="+encodeURIComponent(modpack_id);                
    xhttp.send(data);
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
        alert("Image already exists!");  
        document.querySelector(".add_new_image input[name='image_url']").value="";
      }  
    }
}
  xhttp.open("GET", "images_check.php?url="+encodeURIComponent(imageUrl), true);
  xhttp.send(); 
}
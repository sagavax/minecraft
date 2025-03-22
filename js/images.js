
              
         const upload_image = document.getElementById("upload_image");
         const external_image = document.getElementById("upload_external_image");
         const drag_and_drop = document.getElementById("drag_and_drop");

              
         const upload_external_image = document.getElementById("upload_external_image");
         upload_external_image.addEventListener("submit",(e)=>{
          e.preventDefault();
         });

         document.getElementById("upload_external_image").style.display="block";
         //document.getElementById("drag_and_drop").style.display="none";

      

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

       
                  function show_upload_form() {
                    external_image.style.display="none";
                    upload_image.style.display="block";
                    drag_and_drop.style.display="none";
                    localStorage.setItem("current_radio","upload_image");
                    localStorage.setItem("current_radio_id","upload_image");
                 
                  }   
                  function show_link_form(){
                               
                    external_image.style.display="block";
                    upload_image.style.display="none";
                    drag_and_drop.style.display="none";  
                   localStorage.setItem("current_radio","external_image");
                   localStorage.setItem("current_radio_id","upload_external_image");
                }

                function show_drag_form() {
                  external_image.style.display="none";
                    upload_image.style.display="none";
                    drag_and_drop.style.display="block";
                    localStorage.setItem("current_radio","drag_and_drop");
                    localStorage.setItem("current_radio_id","drag_and_drop");
                }

/*  */

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
  var buttonName;

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

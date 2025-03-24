  //parse url and get image id
var urlParams = new URLSearchParams(window.location.search);
var imageId = urlParams.get('image_id');
var images_tags = document.querySelector(".images_tags");
var image_description = document.querySelector(".image_description");
var modal_new_tags = document.querySelector(".modal_new_tags");
var old_description = document.querySelector(".image_description").innerText;
//
sessionStorage.setItem("picture_id",imageId);


images_tags.addEventListener("click", function(event){
  if (event.target.tagName === "BUTTON" && event.target.name==="new_tag"){
    document.querySelector(".modal_new_tags").showModal();
  }
});

modal_new_tags.addEventListener("click", function(event){
  if(event.target.tagName === "BUTTON" && event.target.name=="tag") {
    var  tagId = event.target.getAttribute("tag-id");
    console.log("new tag added: ", tagId);
    addTagToImage(tagId);
  }
});


image_description.addEventListener("click", function(event){
    image_description.setAttribute("contenteditable", "true");
})

image_description.addEventListener("blur", function(event){
    var new_description = document.querySelector(".image-description").innerText;
    if(old_description==new_description){
      //ziadna zmena. nic sa nebude ukladat
      console.log("no change");
      return;
    } else {
    console.log("image_description saved");
    const pictureId = sessionStorage.getItem("picture_id");
    image_description.removeAttribute("contenteditable");
    saveImageDescrition(pictureId,new_description);
    }
});
  
           this.contentEditable=false;  
              window.onload = function() {
          var anchors = document.querySelectorAll('.comment');
          for(var i = 0; i < anchors.length; i++) {
              var anchor = anchors[i];
              anchor.onclick = function() {
                 listenForDoubleClick(this);
              }
              anchor.onblur=this.contentEditable=false;
              anchor.onkeyup=update_comment(anchor.getAttribute('data-id'), anchor.innerHTML);
              }
                
          }
       
   
            function listenForDoubleClick(element) {
              element.contentEditable = true;
              setTimeout(function() {
                if (document.activeElement !== element) {
                  element.contentEditable = false;
                }
              }, 300);
            }


           var image_name_div = document.querySelector(".picture_name");
           
           image_name_div.contentEditable=false;
           image_name_div.addEventListener("click",function(){
            image_name_div.contentEditable = 'true';
            //alert("meno");
           })  

         image_name_div.addEventListener("blur", function () {
         image_name_div.contentEditable = false;  // Corrected line
         var image_name = image_name_div.innerText;
         save_image_name(image_name);
            });
            

            // Select the element that contains the picture comments
                var imageComments = document.querySelector(".picture_comments");

                // Add a click event listener to the image name div
                imageComments.addEventListener("click", function(event) {
                    // Check if the clicked element is a button or an icon within a button
                    if (event.target.tagName === "BUTTON" || event.target.tagName === "I") {
                        // Log a message to the console for debugging purposes
                        console.log("remove...");

                        // Find the closest ancestor element with the class 'comment' and get its 'data-id' attribute
                        const buttonId = event.target.closest(".comment").getAttribute("data-id");
                        
                        // Log the 'data-id' of the comment to the console
                        console.log(buttonId);

                        // Call the function to remove the comment, passing the 'data-id'
                        removeComment(buttonId);
                    }
                });



                 function add_comment() {
                   var comment_input = document.querySelector(".new_comment input");
                    var comment_text = comment_input.value;
                 
                    if(comment_text===""){
                      alert("Please enter any comment");
                      comment_input.style.border = "2px solid red";
                       
                    setTimeout(() => {
                      comment_input.style.border = "1px solid #d1d1d1";
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
                    data = "comment_text="+decodeURIComponent(comment_text)+ "&image_id="+decodeURIComponent(image_id);
                    xhttp.open("POST", "image_comment_create.php", true);
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.send(data);
                    var comments = document.getElementById("comments");
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
                    
                    //div_del_comment.onclick = function(){ alert(this.getAttribute("data-id"));};
                  }
                    }

                function reload_comments() {
                  var xhttp = new XMLHttpRequest();
                  xhttp.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                    document.querySelector(".picture_comments").innerHTML = this.responseText;
                    count_comments();
                  }
                };
                picture_id=sessionStorage.getItem('picture_id');
                //xhttp.open("GET", "load_comments.php?video_id=<?php echo $_GET['video_id'] ?>", true);
                xhttp.open("GET", "image_load_comments.php?image_id="+picture_id, true);
                xhttp.send();
                }

                function count_comments(){
                    var xhttp = new XMLHttpRequest();
                  xhttp.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("nr_of_comments").innerHTML = this.responseText;
                    //alert(this.responseText);
                  }
                };
                picture_id=sessionStorage.getItem('picture_id');
                //console.log(video_id);
                //xhttp.open("GET", "count_comments.php?video_id=<?php echo $_GET['video_id'] ?>", true);
                xhttp.open("GET", "image_count_comments.php?picture_id="+picture_id, true);
                xhttp.send();
                }
          
                function update_comment(comm_id,content){
                var url= "image_comment_update.php?comm_id="+encodeURIComponent(comm_id)+"&comment="+encodeURIComponent(content);
                //var url= "update_base_descr.php?base_id="+encodeURIComponent(base_id);
                var xhttp = new XMLHttpRequest();
                        xhttp.open("POST", url, true);
                        xhttp.send();

                //ajax update content
               }

               function removeComment(commId){
                  var xhttp = new XMLHttpRequest();
                  xhttp.onreadystatechange = function() {
                     if (this.readyState == 4 && this.status == 200) {
                        alert("Komment bol vymazany!");
                        var parent = document.querySelector(".picture_comments");
                        var commentToDelete = parent.querySelector('.comment[data-id="' + commId + '"]');
                        
                        // If the comment to delete is found, you can proceed with removing it
                        if (commentToDelete) {
                            commentToDelete.remove(); // This will remove the element from the DOM
                            count_comments()
                        } else {
                            console.log('Comment not found');
                        }
                      }
                    };
                  var data = "comm_id="+commId;
                  xhttp.open("POST", "image_comment_remove.php", true);
                  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                  xhttp.send(data);
                }

               function get_max_comment_id(){
                var xhttp = new XMLHttpRequest();
                  xhttp.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                    //document.getElementById("nr_of_comments").innerHTML = this.responseText;
                    var max_comment_id = this.responseText;
                    //funct1(max_comment_id);
                  }
                };
                //xhttp.open("GET", "count_comments.php?video_id=<?php echo $_GET['video_id'] ?>", true);
                xhttp.open("GET", "picture_get_max_comment_id.php", true);
                xhttp.send();

               
               }


               function save_image_name(new_name){
                 var xhttp = new XMLHttpRequest();
                  xhttp.onreadystatechange = function() {
                     if (this.readyState == 4 && this.status == 200) {
                       
                      }
                    };
                  imageId=sessionStorage.getItem('picture_id');
                  data = "new_name="+encodeURIComponent(new_name)+"&image_id="+imageId;
                  xhttp.open("POST", "image_save_name.php", true);
                  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                  xhttp.send(data);
               }

               function saveImageDescription(pictureId, new_description) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        alert("Popis obrázku uložený!");
                    } else if (this.readyState == 4) {
                        // Ošetrenie chýb pri neúspešnej požiadavke
                        console.error("Chyba pri ukladaní popisu: " + this.status);
                    }
                };
            
                // Opravený preklep z "nre_description" na "new_description"
                var data = "image_id=" + pictureId + "&description=" + encodeURIComponent(new_description);
            
                // Odoslanie POST požiadavky
                xhttp.open("POST", "image_save_description.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(data);
            }
            

               function addTagToImage(tagId){
                 var xhttp = new XMLHttpRequest();
                  xhttp.onreadystatechange = function() {
                     if (this.readyState == 4 && this.status == 200) {
                        alert("Tag pridaný!");
                        
                     }
                    };
                  data = "image_id="+sessionStorage.getItem('picture_id')+"&tag_id="+tagId;
                  xhttp.open("POST", "image_add_tag.php", true);
                  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                  xhttp.send(data);
               }
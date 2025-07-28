const gallery_wrap = document.querySelector(".gallery_wrap");
const gallery_item = document.querySelector(".gallery_item");
const image_full_view = document.querySelector(".image_full_view"); //image_full_view

gallery_wrap.addEventListener("click", function(event) {
    const target = event.target;

    // Klik na obrázok v galérii
    if (target.tagName.toLowerCase() === "img") {
        const galleryItem = target.closest(".gallery_item");
        const image_id = galleryItem.id;

        sessionStorage.setItem("picture_id", image_id);

        const image_full_view = document.querySelector(".image_full_view");
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
        }
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



image_full_view.addEventListener("click", function(event) {
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
})

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
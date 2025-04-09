const idea_comment_new_form= document.querySelector(".idea_comment_new form" );
const idea_comments_list = document.querySelector(".idea_comments_list");



/* let isSubmitting = false;
idea_comment_new_form.addEventListener("submit", function(event) {
  event.preventDefault();
  if (isSubmitting) return;
  isSubmitting = true;

  var textarea = document.querySelector(".idea_comment_new form textarea");
  if (textarea.value.trim() === "") {
      alert("Please enter a comment.");
      isSubmitting = false; // Obnoviť stav
      return;
  }

  // Po spracovaní formulára
  console.log("Comment submitted:", textarea.value);
  isSubmitting = false;
}); */


idea_comments_list.addEventListener("click",function(event) {
    if(event.target.tagName==="BUTTON"){
        if(event.target.name==="save_idea_comment"){
            //alert("Uložiť komentár");
            saveIdeaComment();
        } else if (event.target.name==="delete_comment"){
            const commentId = event.target.closest(".idea_comment").getAttribute("data-comment-id");
            console.log(commentId);
            deleteIdeaComment(commentId);
        }
        
    }
});


function getIdeaComment(commentId) {
}

function deleteIdeaComment(commentId) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
       if (this.readyState == 4 && this.status == 200) {
        document.querySelector(`.idea_comment[data-comment-id='${commentId}']`).remove();
          alert("Komment bol vymazany!");
        }
      };
    var data = "comm_id="+commentId;
    xhttp.open("POST", "idea_comment_remove.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}

function saveIdeaComment(ideaId) {
   if(document.querySelector(".idea_comment_new textarea").value==""){
     alert("Prosím, vložte komentár.");
     return;
   }
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
       if (this.readyState == 4 && this.status == 200) {
          alert("Komentár bol uložený!");
          // refresh comments list
          ideaId = sessionStorage.getItem("idea_id");
          getIdeaComments(ideaId);
        }
      };
    var ideaId = sessionStorage.getItem("idea_id");  
    var textarea = document.querySelector(".idea_comment_new textarea");
    var input = document.querySelector(".idea_comment_new input");
    var data = "comment="+encodeURIComponent(textarea.value)+"&comment_title="+encodeURIComponent(input.value)+"&idea_id="+encodeURIComponent(ideaId);
    xhttp.open("POST", "idea_comment_save.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}


function getIdeaComments(ideaId) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
       if (this.readyState == 4 && this.status == 200) {
          var comments = JSON.parse(this.responseText);
          clearIdeaComments();
          comments.forEach(function(comment) {
             addIdeaComment(ideaId);
          });
        }
      };
    xhttp.open("POST", "idea_comments_get.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("idea_id="+encodeURIComponent(ideaId));
}

function clearIdeaComments() {
    while (idea_comments_list.firstChild) {
        idea_comments_list.removeChild(idea_comments_list.firstChild);
    }
}


function addIdeaComment(ideaId) {
    
}
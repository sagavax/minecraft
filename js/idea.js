const idea_comment_new_form= document.querySelector(".idea_comment_new form" );
const idea_comments_list = document.querySelector(".idea_comments_list");
const idea_comment_action = document.querySelector(".idea_comment_action");


const ideaId = new URLSearchParams(window.location.search).get('idea_id');
sessionStorage.setItem("idea_id", ideaId);


idea_comment_action.addEventListener("click", function(event) {
    if(event.target.tagName==="BUTTON"){
        if(event.target.name==="save_idea_comment"){
          if(document.querySelector(".idea_comment_new textarea").value==""){
            alert("Prosím, vložte komentár.");
            return;
          }
            //alert("Uložiť komentár");
            const ideaId = sessionStorage.getItem("idea_id");
            saveIdeaComment(ideaId);
        }         
    }
});


idea_comments_list.addEventListener("click",function(event) {
    if(event.target.tagName==="BUTTON"){
        if (event.target.name==="delete_comment"){
            const commentId = event.target.closest(".idea_comment").getAttribute("data-comment-id");
            console.log(commentId);
            deleteIdeaComment(commentId);
        }
        
    }
});



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
          document.querySelector(".idea_comment_new textarea").value="";
          document.querySelector(".idea_comment_new input").value="";
          // refresh comments list
          ideaId = sessionStorage.getItem("idea_id");
          //getIdeaComments(ideaId);
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

function clearIdeaComments() {
    while (idea_comments_list.firstChild) {
        idea_comments_list.removeChild(idea_comments_list.firstChild);
    }
}
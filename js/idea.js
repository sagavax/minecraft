const idea_comment_new_form= document.querySelector(".idea_comment_new form" );
const idea_comments_list = document.querySelector(".idea_comments_list");

idea_comment_new_form.addEventListener("submit", function(event) {
          event.preventDefault(); // Prevent form submission
        var textarea = document.querySelector(".idea_comment_new form textarea");
        
        // Kontrola, či je textarea prázdna
        if (textarea.value.trim() === "") {
            alert("Please enter a comment.");
            return;
        }

});


idea_comments_list.addEventListener("click",function(event) {
    if(event.target.tagName==="BUTTON"){
        const commentId = event.target.getAttribute("comment-id");
        console.log(commentId);
        deleteIdeaComment(commentId);
    }
});


function getIdeaComment(commentId) {
}
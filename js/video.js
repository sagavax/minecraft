  //console.log(sessionStorage.getItem('video_id'));
  var urlParams = new URLSearchParams(window.location.search);
  var videoId = urlParams.get('video_id');
  sessionStorage.setItem("video_id",videoId);
  var video_name_wrap = document.querySelector(".video_details_name_wrap");  
  var video_tags_list = document.querySelector(".video_tags_list");
  var video_comments = document.querySelector(".video_comments");
  var modal_add_new_tags_closeButton = document.querySelector(".modal_new_tags .inner_layer button");
  const modal_new_video_tags = document.querySelector(".modal_new_tags");
  const video_tag_list = document.querySelector(".video_tags_list");
       

  video_tag_list.addEventListener('click', function(event) {
    if(event.target.tagName.toLowerCase()=="i"){
      videoId = sessionStorage.getItem("video_id");
      remove_tag_from_video(event.target.parentElement.getAttribute('tag-id'), videoId);
    }  
  });    

  video_name_wrap.addEventListener("click", (ev) => {
    if (ev.target.getAttribute('name') === "edit_title") {
        document.querySelector(".video_details_name").contentEditable = "true";
        //hide edit button
        document.querySelector("button[name='edit_title']").style.display = "none";
        //show 
        document.querySelector("button[name='save_chnages']").style.display = "block";

        console.log("editable content is true...");
    } else if (ev.target.getAttribute('name') === "save_chnages") {
      console.log("save changes");   
        if (document.querySelector(".video_details_name").innerText === "") {
            alert("Cannot be empty!!!");
        } else {
            const video_title = document.querySelector(".video_details_name").innerText;
            console.log(video_title);
            // Assuming updateVideoTitle is defined elsewhere
            updateVideoTitle(video_title);
            document.querySelector(".video_details_name").contentEditable = "false";
            document.querySelector(".video_details_name").removeAttribute("contentEditable");
            
            //hide edit button
            document.querySelector("button[name='edit_title']").style.display = "block";
            //show save changes 
            document.querySelector("button[name='save_chnages']").style.display = "none";
            
            alert("Video title has been changed");
            console.log("save changes");
        }
    }
});
        
      document.querySelector(".new_comment").addEventListener("click",function(event){
          if(event.target.tagName==="BUTTON"){
              //alert("add comment");
              addComment();
          }
      })

      video_tags_list.addEventListener("click",function(event){
        if(event.target.tagName==="BUTTON"){
          if(event.target.name==="add_new_tag"){
            document.querySelector(".modal_new_tags").showModal();
          }
        }
      })

      modal_new_video_tags.addEventListener("click", function(event){
        if(event.target.tagName==="BUTTON"){
          console.log(event.target.name);
          if(event.target.name==="add_new_tag"){
            var  tagId = event.target.getAttribute("tag-id");
            var videoId = sessionStorage.getItem("video_id");
             console.log(tagId,videoId);
            savetoVideoTagList(tagId, videoId);
            //remove from the list to avoid confusion
            document.querySelector(".modal_new_tags .tags_list").removeChild(event.target);
          } if(event.target.name==="letter"){
            var letterButton = event.target.innerText;
            sortVideosTagsByLetters(letterButton);
          }
        }
      })
        

      modal_add_new_tags_closeButton.addEventListener("click",function(){
        document.querySelector(".modal_new_tags").close();
      })
      

      video_comments.addEventListener("click", function(event){
          if(event.target.tagName==="BUTTON" || event.target.tagName==="I"){
                  //alert("remove");    
                  console.log("remove...");
                  const buttonId = event.target.closest(".comment").getAttribute("data-id"); 
                  console.log(buttonId);  
                  removeComment(buttonId);
              
            }
      })   

              
          function listenForDoubleClick(element) {
            element.contentEditable = true;
            setTimeout(function() {
              if (document.activeElement !== element) {
                element.contentEditable = false;
              }
            }, 300);
          }

      
      async function addComment() {
            const videoId = sessionStorage.getItem("video_id");
            const commentText = document.querySelector('#video_comment').value;
            const data = `comment=${encodeURIComponent(commentText)}&video_id=${videoId}`;

            try {
              // Send the comment to the server
              const response = await fetch("video_comment_create.php", {
                method: "POST",
                headers: {
                  "Content-Type": "application/x-www-form-urlencoded"
                },
                body: data
              });

              if (response.ok) {
                // Assuming fetchMaxCommentId is an async function that fetches the max comment ID
                const commentId = await fetchMaxCommentId();
                const commentContainer = document.getElementById('comments');

                const commentElement = document.createElement('div');
                commentElement.classList.add('comment');
                commentElement.dataset.id = commentId;
                //crate div container containing text
                textElementwrap = document.createElement("div");
                //assigning class comment_text
                textElementwrap.classList.add('comment_text');
                //appends to .comment div
                commentElement.appendChild(textElementwrap);
                //assign the text
                textElementwrap.textContent = commentText;
                //create div that wraps footer
                footerElement = document.createElement("div");
                //assigns the class comment_footer
                footerElement.classList.add('comment_footer');
                //appends to maina comment
                commentElement.appendChild(footerElement);
                //create a button
                const deleteButton = document.createElement('button');
                deleteButton.classList.add('button', 'small_button');
                deleteButton.innerHTML = "<i class='fa fa-times'></i>";

                footerElement.appendChild(deleteButton);
                commentContainer.appendChild(commentElement);
                  
                count_comments()

                // Clear input field after successful comment submission
                document.querySelector('#video_comment').value = '';
              } else {
                console.error("Failed to post comment:", response.statusText);
              }
            } catch (error) {
              console.error("Error posting comment:", error);
            }
          }

          async function fetchMaxCommentId() {
              const videoId = sessionStorage.getItem('video_id');
              const response = await fetch(`video_get_max_comment_id.php?video_id=${videoId}`);
              const data = await response.json();
              return data; // Assuming the server returns the maximum comment ID
          }


          function reload_comments() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              document.querySelector(".video_comments").innerHTML = this.responseText;
            }
          };
          const video_id=sessionStorage.getItem('video_id');
          xhttp.open("GET", "load_comments.php?video_id="+video_id, true);
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
          var video_id=sessionStorage.getItem('video_id');
          //console.log(video_id);
          //xhttp.open("GET", "count_comments.php?video_id=<?php echo $_GET['video_id'] ?>", true);
          xhttp.open("GET", "count_comments.php?video_id="+video_id, true);
          xhttp.send();
          }
    
          function update_comment(comm_id,content){
            //var comm_id = this.getAttribute("data-id");
          //var element = document.getElementById(obj_id);
          //console.log(comm_id); 
          
            //console.log(content);
          var url= "update_comment.php?comm_id="+encodeURIComponent(comm_id)+"&comment="+encodeURIComponent(content);
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
                  var parent = document.querySelector(".video_comments");
                  var commentToDelete = parent.querySelector('.comment[data-id="' + commId + '"]');
                  
                  // If the comment to delete is found, you can proceed with removing it
                  if (commentToDelete) {
                      commentToDelete.remove(); // This will remove the element from the DOM
                      count_comments()
                  } else {
                      console.log('Comment not found');
                  }
                  //div_delete = querySelectorAll()
                  //reload_comments();
                }
              };
            var data = "comm_id="+commId;
            xhttp.open("POST", "video_comment_remove.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(data);
          }

          function get_max_comment_id(funct1){
          var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              //document.getElementById("nr_of_comments").innerHTML = this.responseText;
              var max_comment_id = this.responseText;
              //funct1(max_comment_id);
            }
          };
          //xhttp.open("GET", "count_comments.php?video_id=<?php echo $_GET['video_id'] ?>", true);
          xhttp.open("GET", "get_max_comment_id.php", true);
          xhttp.send();

          
          }

      function updateVideoTitle(video_title) {
      console.log(video_title);
      var xhttp = new XMLHttpRequest();

      // Check the state of the AJAX request
      xhttp.onreadystatechange = function() {
          // Check if the request is complete and was successful
          if (this.readyState == 4 && this.status == 200) {
              // Show a message when the export is successful
              ShowMessage("Videos title has been updated ...");
          }
      };
  
      // Configure the request
      xhttp.open("POST", "video_update_title.php", true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  
      // You need to define the `data` variable before calling `exportCSV()`
      // For example:
      // var data = "param1=value1&param2=value2";
  
      // Send the request with data (assuming `data` is defined elsewhere)
      videoId = sessionStorage.getItem("video_id");
      const data = "video_title="+video_title+"&video_id="+ videoId;
      xhttp.send(data);
      }

           
function savetoVideoTagList(tagId, videoId){
  var xhttp = new XMLHttpRequest();

  // Check the state of the AJAX request
  xhttp.onreadystatechange = function() {
      // Check if the request is complete and was successful
      if (this.readyState == 4 && this.status == 200) {
          // Show a message when the export is successful
          ShowMessage("Tag has been assigned ...");
      }
  };

  // Configure the request
  xhttp.open("POST", "video_tag_save.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  // You need to define the `data` variable before calling `exportCSV()`
  // For example:
   var data = "video_id="+videoId+"&tag_id="+tagId;
   console.log(data);
  // Send the request with data (assuming `data` is defined elsewhere)
  xhttp.send(data);
}

function remove_tag_from_video(tagId,videoId ){
  alert("video id: "+videoId+" tag id: "+tagId);
}

function sortVideosTagsByLetters(letterButton){
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
  xhttp.open("POST", "video_tags_sort_by_letters.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  // You need to define the `data` variable before calling `exportCSV()`
  // For example:
  var data = "letter="+letterButton;
  // Send the request with data (assuming `data` is defined elsewhere)
  xhttp.send(data);
}
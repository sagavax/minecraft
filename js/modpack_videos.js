

const pagination = document.querySelector(".inner_tags_layer .pagination");

pagination.addEventListener('click', function(event) {
    // Check if the clicked element is a button
    if (event.target.tagName === "BUTTON") {
        // Log the event target tag name for debugging
        console.log('Clicked element tag name:', event.target.tagName);

        // Retrieve the page number from the button's inner text
        const pageNumber = event.target.innerText;

        // Log the page number for debugging
        console.log('Page number:', pageNumber);

        // Call the PaginateTags function with the page number
        PaginateTags(pageNumber);

        // Add your logic to handle pagination here
    }
});

const tags = document.querySelector(".tag_map");
tags.addEventListener("click", function(event){
    if(event.target.tagName==="BUTTON"){
        const tagName = event.target.innerText;
        const tagId =event.target.getAttribute("tag-id");
        console.log(tagName, tagId);
    }
})



const hide_top_bar = document.querySelector(".video_top_bar button");
//console.log(hide_top_bar);

hide_top_bar.addEventListener("click",function(){
        document.getElementById("new_video").style.display="none";
})    



// Identify a common parent element
const parentElement = document.querySelector(".inner_layer");

// Attach event listener to the parent element
parentElement.addEventListener("input", function(event) {
    // Check if the target element is the input field
    if (event.target.matches(".inner_layer input")) {
        // Remove previous search results
        RemovePrevResults();

        // Check if the input field is not empty
        if (event.target.value !== "") {
            // Call TagAutocomplete function with the input value
            TagAutocomplete(event.target.value);
        }
    }
});

parentElement.addEventListener("keydown", function(event) {
    // Check if the target element is the input field
    if (event.target.matches(".inner_layer input") && event.key === "Enter") {
        createVideoTag(event.target.value);
    }
});






const modal_tag_input = document.querySelector(".inner_tags_layer input");
    modal_tag_input.addEventListener("keyup",function(event){
        searchModalTags(modal_tag_input.value);
    })




    const closeButton = document.querySelector(".inner_layer button");
    closeButton.addEventListener("click", function() {
        //console.log(closeButton);
        document.querySelector(".modal").style.display = "none";
    });


const closeVideoTagsButton = document.querySelector(".inner_tags_layer button");
    closeVideoTagsButton.addEventListener("click", function() {
        //console.log(closeButton);
        document.querySelector(".modal_video_tags").style.display = "none";
    });



const modal_comm_input = document.querySelector(".modal_notes input");

modal_comm_input.addEventListener("keydown", function(event) {
    if (event.key === "Enter" && modal_comm_input.value !== "") {
        createVideoComment(modal_comm_input.value);
    }
});




    const modal_modpack_input = document.querySelector(".inner_modpack_layer input");
    modal_modpack_input.addEventListener("keydown", function(event) {
    if (event.key == "Enter" && modal_modal_input.value !=="") {
        if(modal_modpack_input.value=="")
        //alert(modal_modpack_input.value);
        createNewModpack(modal_modpack_input.value)
    } else if (modal_modpack_input.value === "") {
        alert("Input cannot be empty!");
    }
});



     //const closeCommButton = document.querySelector(".inner_comment_layer button");
      const closeCommButton=document.querySelector(".modal_notes button");
      closeCommButton.addEventListener("click", function() {
        //console.log(closeButton);
        document.querySelector(".modal_notes input").value="";
        document.querySelector(".modal_notes").close();
    });


     const closeModpackButton = document.querySelector(".inner_modpack_layer button");
    closeModpackButton.addEventListener("click", function() {
        document.querySelector(".inner_modpack_layer input").value="";
        document.querySelector(".modal_modpack").style.display = "none";
    });



    //clear search input
    //var search_wrap = document.querySelector(".search_wrap");
    var search_input=document.querySelector(".search_wrap input");
    var clear_button= document.querySelector(".search_wrap button");
    clear_button.addEventListener("click", function(){
        search_input.value="";
    })


  /*  const tags_map = document.querySelector(".tags_map");
    tags_map.addEventListener("click",function(event){
        if(event.target.tagName==="BUTTON"){
            console.log(event.target.textContent);
        }
    })*/

   
    // Get the input element
    var video_url = document.getElementById("video_url");

    // Attach the first function to the input change event
    //video_url.addEventListener("input", check_video_exists);

    // Attach the second function to the input change event
    video_url.addEventListener("input", getYouTubeVideoName);

   

   video_url.oninput = function() { check_video_exists(video_url.value) };
   //document.getElementById("videos_cards").style.display = "none";

   function search_the_video(text) {
      
       var xhttp = new XMLHttpRequest();
       //var search_text=document.getElementById("search_string").value;
       xhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               document.getElementById("videos_list").innerHTML =
                   this.responseText;
           }
       };
       xhttp.open("GET", "videos_search.php?search=" +text, true);
       xhttp.send();

   }

   function show_list() {
      // document.getElementById("videos_list").style.display = "block";
      // document.getElementById("videos_cards").style.display = "none";
   }

   function show_cards() {
       //document.getElementById("videos_list").style.display = "none";
       //document.getElementById("videos_cards").style.display = "grid";
   }

   function check_video_exists() {
       url = document.getElementById("video_url").value;
       var xhttp = new XMLHttpRequest();
       const icon1 = document.querySelector(".icon1");
       const icon2 = document.querySelector(".icon2");

       xhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {

               video_url = document.getElementById("video_url");
               if (this.responseText == 1) {

                   video_url.style.borderWidth = "3px";
                   video_url.style.borderColor = "#e74c3c";
                   setTimeout(clear_video_url_style,2000);
                   ShowMessage("Video already exists!!");
                   //icon1.style.display = "flex";
                   //icon2.style.display = "none";

                   //alert("Taketo video uz je v databaze");

                   return false;
               } else {
                   video_url.style.borderWidth = "3px";
                   video_url.style.borderColor = "#27ae60";
                   
                   //icon1.style.display = "none";
                   //icon2.style.display = "flex";
               }
           }
       };
       xhttp.open("GET", "check_video_id.php?video_id=" + video_url.value, true);
       xhttp.send();
   }

   function reload_videos() {
       // alert(video_url);
       document.getElementById("videos_list").style.display = "block";
       //document.getElementById("videos_cards").style.display = "none";

       var xhttp = new XMLHttpRequest();
       xhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {

               document.getElementById("videos_list").innerHTML = this.responseText;
               alert("reload done");
           }
       };
       xhttp.open("GET", "reload_videos.php", true);
       xhttp.send();
   }

   function show_add_new_note(video_id) {
       //zobrazim modal 
       document.getElementById("add_new_video_note_modal").classList.add("show-modal");
       //console.log(video_id);
       var modal_head = document.getElementById("modal_header");
       //vlozime text do hlavicky
       modal_head.innerHTML = "Add new note to video id " + video_id;

      
       var show_modal = document.getElementById('modal_footer').querySelector('.submit_note');
       var close_modal = document.getElementById('modal_footer').querySelector('.close_modal')
       close_modal.onclick = function() {
           document.getElementById("add_new_video_note_modal").classList.remove("show-modal");
       }


       //for(var i=0; i<kbButtons.length; i++) {
       //    kbButton=kbButtons[i];
       show_modal.setAttribute("video-id", video_id);
   }

   function add_new_note(e) {
       //text co napiseme do textarea
       var new_note = document.getElementById("new_note").value;
       var video_id = e.getAttribute("video-id");

       //posleme to comment.php
       var xhttp = new XMLHttpRequest();
       xhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               alert("novy comment pridany!!");
               document.getElementById("new_note").value = "";
               document.getElementById("add_new_video_note_modal").classList.remove("show-modal");
           }
       };
       var data = "&video_id=" + encodeURIComponent(video_id) + "&video_comment=" + encodeURIComponent(new_note);

       //console.log(data);
       xhttp.open("POST", "comment.php", true);
       xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
       xhttp.send(data);
   }

   function validate_form() {
       var x = document.forms["upload_videos"]["video_title"].value;
       if (x == "") {
           alert("Chyba titulok videa");
       }
   }

   function getYouTubeVideoName() {
    var url = document.getElementById("video_url").value;

    // Define a regular expression pattern to match YouTube URLs
    const youtubeRegex = /^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/;

    // Extract the video ID from the URL using the regular expression
    const match = url.match(youtubeRegex);

    // If a match is found, return the video ID
    if (match && match[1]) {
        const videoId = match[1];

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("video_title").value = this.responseText;
                const video_name = this.responseText;
                if(video_name.includes("Bedrock")){
                    document.querySelector('select[name="edition"]').value = "bedrock";
                }
            }
        };
        xhttp.open("GET", "get_youtube_video_name.php?videoUrl="+encodeURIComponent(url), true);
        xhttp.send();

        // You can use the video ID to make API requests or perform other actions
        return videoId;
    } else {
        // Corrected typo here
        ShowMessage("This is not a video URL");
        return null;
    }
}


function remove_readonly(object){
    object.removeAttribute("readonly");
}

function set_readonly(object){
    object.setAttribute("readonly", true);
}


//source videos by mod

var container = document.querySelector('.tab_view');

    // Add a click event listener to the container
    container.addEventListener('click', function(event) {
        // Check if the clicked element is a button
        if (event.target.tagName === 'BUTTON'){
            // Get the name attribute of the clicked button
            var buttonName = event.target.getAttribute('name');
            
            sort_videos_by_modif(buttonName);
            
            // Do something with the buttonName, for example, log it to the console
            console.log('Button clicked with name:', buttonName);
            //console.log('Button clicked with video-id:', videoId);
        }
    });

//show_favorites of watch later
var container_fav_later = document.querySelector('.tab_view_fav_later');

    // Add a click event listener to the container
    container_fav_later.addEventListener('click', function(event) {
        // Check if the clicked element is a button
        if (event.target.tagName === 'BUTTON' || event.target.tagName==='I'){
            // Get the name attribute of the clicked button
            var buttonName = event.target.getAttribute('name');
            
            sort_videos_by_fav_watch_later(buttonName);
            
            // Do something with the buttonName, for example, log it to the console
            console.log('Button clicked with name:', buttonName);
            //console.log('Button clicked with video-id:', videoId);
        }
    });




//show list or grid
var container_view_style = document.querySelector('.tab_view_list_grid');
//console.log(container_view_style);

    // Add a click event listener to the container
    container_view_style.addEventListener('click', function(event) {
        // Check if the clicked element is a button
        if (event.target.tagName === 'BUTTON'){
            // Get the name attribute of the clicked button
            var buttonName = event.target.getAttribute('name');
            
            videos_display_as(buttonName);
            
            // Do something with the buttonName, for example, log it to the console
            console.log('Button clicked with name:', buttonName);
            //console.log('Button clicked with video-id:', videoId);
        }
    });




//sort videos by source 
    var container_view_source = document.querySelector('.tab_view_source');

    // Add a click event listener to the container
    container_view_source.addEventListener('click', function(event) {
        // Check if the clicked element is a button
        if (event.target.tagName === 'BUTTON'){
            // Get the name attribute of the clicked button
            var buttonName = event.target.getAttribute('name');
            
            sort_videos_by_source(buttonName);
            
            // Do something with the buttonName, for example, log it to the console
            console.log('Button clicked with name:', buttonName);
            //console.log('Button clicked with video-id:', videoId);
        }
    });

//sort videos by source 
    var container_view_source = document.querySelector('.tab_view_edition');

    // Add a click event listener to the container
    container_view_source.addEventListener('click', function(event) {
        // Check if the clicked element is a button
        if (event.target.tagName === 'BUTTON'){
            // Get the name attribute of the clicked button
            var buttonName = event.target.getAttribute('name');
            
            sort_videos_by_edition(buttonName);
            
            // Do something with the buttonName, for example, log it to the console
            console.log('Button clicked with name:', buttonName);
            //console.log('Button clicked with video-id:', videoId);
        }
    });

var container_view_tags = document.querySelector(".tab_view_tags");

    // Add a click event listener to the container
    container_view_tags.addEventListener('click', function(event) {
         if(event.target.tagName==="BUTTON"){
            buttonName=event.target.name;
         }
        // Show the modal_video_tags container
        document.querySelector(".modal_video_tags").style.display = "flex";
    });


function sort_videos_by_source(source){
      var xhttp = new XMLHttpRequest();
       //var search_text=document.getElementById("search_string").value;
       xhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               document.getElementById("videos_list").innerHTML =
                   this.responseText;
           }
       };
       xhttp.open("GET", "videos_sorted_by_source.php?sort_by=" + source, true);
       xhttp.send();
}


function sort_videos_by_edition(source){
      var xhttp = new XMLHttpRequest();
       //var search_text=document.getElementById("search_string").value;
       xhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               document.getElementById("videos_list").innerHTML =
                   this.responseText;
           }
       };
       xhttp.open("GET", "videos_sorted_by_edition.php?sort_by=" + source, true);
       xhttp.send();
}



    //modpack list hide button
    var hide_btn = document.querySelector(".video_modpacks header button");
            hide_btn.addEventListener("click", function(){
                     document.querySelector(".video_modpacks").style.display="none";
            })  

            function hideModpackList(){
                document.querySelector(".video_modpacks").style.display="none";
            }


function LoadVideosModpacks(){
      var xhttp = new XMLHttpRequest();
       //var search_text=document.getElementById("search_string").value;
       xhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               document.getElementById("videos_modpacks").innerHTML =
                   this.responseText;
           }
       };
       xhttp.open("GET", "videos_modpacks.php", true);
       xhttp.send();
}

function sort_videos_by_modif(source){
  if (source === "modded") {
        // Show the container with class "video_modpacks"
        document.querySelector(".video_modpacks").style.display = "flex";
        
        // Get the container for modpack buttons
        var containerModpackList = document.querySelector(".video_modpacks main");
                
        // Check if the container was found
        if (containerModpackList) {
            // Add a click event listener to the container
            containerModpackList.addEventListener("click", function (event) {
                // Check if the clicked element is a button
                if (event.target.tagName.toLowerCase() === "button") {
                    // Perform your action here
                    mdpk_id = event.target.getAttribute("mdpk-id");
                    videos_sorted_by_mdpk(mdpk_id);
                    //alert(mdpk_id);
                }
            });
        } else {
            console.error("Container not found");
        }
    }

    // Create an XMLHttpRequest object
    var xhttp = new XMLHttpRequest();

    // Set up the callback function for when the request is complete
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // Update the content of the element with ID "videos_list" with the response
            document.getElementById("videos_list").innerHTML = this.responseText;
        }
    };

    // Open and send the GET request to the server
    xhttp.open("GET", "videos_sorted_by_modif.php?sort_by=" + source, true);
    xhttp.send();
}

function videos_sorted_by_mdpk(mdpk_id){
        var xhttp = new XMLHttpRequest();

    // Set up the callback function for when the request is complete
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // Update the content of the element with ID "videos_list" with the response
            document.getElementById("videos_list").innerHTML = this.responseText;
        }
    };

    // Open and send the GET request to the server
    xhttp.open("GET", "videos_sorted_by_mdpk.php?sort_by=" + mdpk_id, true);
    xhttp.send();
}


function sort_videos_by_fav_watch_later(source){
        var xhttp = new XMLHttpRequest();

    // Set up the callback function for when the request is complete
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // Update the content of the element with ID "videos_list" with the response
            document.getElementById("videos_list").innerHTML = this.responseText;
        }
    };

    // Open and send the GET request to the server
    xhttp.open("GET", "videos_sorted_by_fav_later.php?sort_by=" + source, true);
    xhttp.send();
}

function videos_display_as(source){
      var xhttp = new XMLHttpRequest();
        console.log(source);
        if((source)==="cards"){
            var url = "videos_display_as_cards.php";
        }else {
            var url="videos_display_as_list.php";
        }


         xhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               document.getElementById("videos_list").innerHTML =
                   this.responseText;
           }
       };
       xhttp.open("GET", url, true);
       xhttp.send();
}


function clear_video_url_style(){
    video_url.style.borderWidth = "1px";
    video_url.style.borderColor = "#d1d1d1";
    document.getElementById("video_url").value = "";
    document.getElementById("video_title").value = "";
    document.querySelector('select[name="edition"]').value = "java";   
};



function createVideoTag(tag_name){
    const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            const video_id = sessionStorage.getItem("video_id");
            document.querySelector(".modal").style.display = "none";
            reloadTags(video_id);

          }
        
        const video_id = sessionStorage.getItem("video_id");

        xhttp.open("POST", "video_create_tag.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "video_id="+encodeURIComponent(video_id)+"&tag_name="+encodeURIComponent(tag_name);                
        xhttp.send(data);
}

function createVideoComment(comment){
    const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            const input = document.querySelector(".modal_notes input");
            input.value="";
            document.querySelector(".modal_notes").close();
          }
        
        video_id = sessionStorage.getItem("video_id");

        xhttp.open("POST", "video_comment_create.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "video_id="+encodeURIComponent(video_id)+"&comment="+encodeURIComponent(comment);                
        xhttp.send(data);
}

function reloadTags(videoId){
     const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            const videoTagsCont = document.querySelector(`.videos_tags[video-id="${videoId}"]`);
            //console.log(videoTagsCont, video_id);
            videoTagsCont.innerHTML = this.responseText
          }
        
        //video_id = sessionStorage.getItem("video_id");

        xhttp.open("POST", "video_tags_reload.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "video_id="+encodeURIComponent(videoId);                
        xhttp.send(data);
}

function createNewModpack(modpack_name) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        const modpck = document.querySelector(".modpack_container");
        // Remove previous select element with name "modpack"
        const select = modpck.querySelector('select[name="modpack"]');
        if (select) {
            select.remove();
        }
        // Append new select element
        modpck.innerHTML = this.responseText;
        document.querySelector(".modal_modpack").style.display = "none";        
    };

    xhttp.open("POST", "video_modpack_create.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var data = "modpack_name=" + encodeURIComponent(modpack_name);
    xhttp.send(data);
}


function TagAutocomplete(tag) {
    // Reference to the input field and list
    const inputField = document.querySelector(".inner_layer input");
    const list = document.querySelector(".inner_layer ul");
    list.style.borderWidth ="1px";

    // Clear the autocomplete list if the tag is empty
    if (tag === "") {
        list.innerHTML = "";
        return; // Exit the function early
    }

    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        // Clear the list (if it has children)
        if (list.children.length > 0) {
            list.innerHTML = "";
        }

        // Parse the JSON response
        const jsonData = JSON.parse(this.responseText);

        // Iterate over the array of objects
        jsonData.forEach(function(currentTag) {
            var listItem = document.createElement("li");
            listItem.textContent = currentTag.tag_name; // Assuming your objects have a 'tag_name' property
            //listItem.classList.add("fade-in"); 

             setTimeout(function() {
                list.appendChild(listItem);
                    }, 50)
            

            // Add click event listener to each list item
            listItem.addEventListener("click", function() {
                inputField.value = this.textContent; // Set input value to the clicked item's text
                list.innerHTML = ""; // Optionally clear the list after selection
            });
        });

        // Make sure the list is visible (in case it was previously set to 'none')
        list.style.display = "block";
    };

    xhttp.open("GET", "video_tags_autocomplete.php?tag=" + encodeURIComponent(tag), true);
    xhttp.send();
}

// Event listener for the input field to trigger autocomplete
document.querySelector(".inner_layer input").addEventListener("input", function() {
    TagAutocomplete(this.value);
});


function RemovePrevResults() {
    let listItems = document.querySelectorAll(".inner_layer ul li");
    listItems.forEach(function(item) {
        item.remove();
    });
    document.querySelector(".inner_layer ul").style.borderWidth="0px";
}


function loadVideoTags() {
  const videoId = sessionStorage.getItem("videoId");
  const url = `video_tags.php?video_id=${videoId}`;

  fetch(url)
    .then(response => response.json())
    .then(tags => {
      const ul = document.querySelector("ul");
      ul.innerHTML = ""; // Clear existing list items

      for (const tag of tags) {
        const liTag = `
          <li>
            ${tag}
           <i class="fa fa-times" onclick="remove(this, '${tag}')"></i>
          </li>
        `;
        ul.insertAdjacentHTML("afterbegin", liTag);
      }
    })
    .catch(error => console.error(error));
}


 function searchModalTags(tag) {
       var xhttp = new XMLHttpRequest();
       xhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {

               document.querySelector(".tag_map").innerHTML = this.responseText;
            }
       };
       xhttp.open("GET", "videos_search_tags.php?search_tag="+tag, true);
       xhttp.send();
   }


function PaginateTags(pageNumber){
    var xhttp = new XMLHttpRequest();
       xhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {

               document.querySelector(".tag_map").innerHTML = this.responseText;
               
           }
       };
       xhttp.open("POST", "videos_tags_page.php?page="+pageNumber, true);
       xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
       data = "page="+pageNumber;
       xhttp.send(data);
}

/*function showNewVideoForm(){
    var div = document.getElementById('new_video');
    div.style.display = 'flex';
    var opacity = 0;
    var interval = setInterval(function() {
        if (opacity < 1) {
            opacity += 0.1;
            div.style.opacity = opacity;
        } else {
            clearInterval(interval);
        }
    }, 50)
}
*/

function showNewVideoForm(){
    var div = document.getElementById('new_video');
    div.style.display = 'flex';
   window.scrollTo({
  top: 0,
  behavior: 'smooth' // This makes the scrolling smooth, omit if not needed
});
}


function ShowMessage(text){
    console.log(text);
    const message = document.querySelector(".message")
    const p = document.querySelector(".message_text");
    p.innerHTML=text;

    message.classList.remove('hidden'); // Make sure the div is visible
    message.classList.add('fade-out'); // Start the fade-out effect

    setTimeout(function() {
      message.classList.add('hidden'); // Hide the div after 3 seconds
    }, 3000); // 3000 milliseconds = 3 seconds
  }


document.querySelector('#new_video form').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

    var formData = new FormData(this); // Create a FormData object from the form

    fetch('videos_save.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json()) // Assuming the response is JSON
    .then(data => {
        // Display your message based on the response
        console.log("Video added successfully");
        ShowMessage("Video added successfully!");
       fetchLatestVideo();
       clearNewVideoform();
    })
    .catch((error) => {
        console.error('Error:', error);
        //document.getElementById('message').innerText = 'An error occurred';
    });
});


function fetchLatestVideo() {
    fetch('videos_reload_lastest.php') // Corrected the typo in the URL
    .then(response => response.json())
    .then(data => {
        // Assuming 'data' contains the latest video record
        // Append the latest video record to the beginning of the list
        const latestVideoContainer = document.querySelector('.videos_list');
        const videoHTML = `
            <div class="video" video-id="${data.video_id}">
                <div class="video_thunb"><img src="${data.video_thumbnail}" alt="Video Thumbnail"></div>
                <div class="video_list_details">
                    <div class="video_name"><span>${data.video_title}</span></div>
                    <div class="video_action">
                        <button name="watch_later" type="button" title="Watch later" class="button app_badge" video-id="${data.video_id}"><i class="far fa-clock"></i></button>
                        <button name="add_to_favorites" type="button" title="Add to favorites" class="button small_button app_badge" video-id="${data.video_id}"><i class="far fa-star"></i></button>
                        <button name="add_note" title="Add note" class="button app_badge open-button" video-id="${data.video_id}"><i class="fa fa-comment"></i></button>
                        <button name="edit_video" type="button" class="button app_badge" video-id="${data.video_id}"><i class="far fa-edit"></i></button>
                        <button name="delete_video" type="button" class="button app_badge" video-id="${data.video_id}"><i class="fas fa-times"></i></button>
                    </div>
                    <div class='videos_tags' video-id="${data.video_id}"></div>
                </div>
                <div class='video_banner_list'></div>
                <div class='video_action_play'>
                    <div class='video_play_button'><div><a href='video.php?video_id=${data.video_id}'><i class='fas fa-play'></i></a></div></div>
                </div>
            </div>
        `;
        latestVideoContainer.insertAdjacentHTML('afterbegin', videoHTML);

        // Fetch and load video tags for the newly added video
        getVideosTags(data.video_id);
       
    })
    .catch(error => {
        console.error('Error fetching the latest video:', error);
    });
}

function getVideosTags(video_id) {
    fetch(`videos_get_tags?video_id=${video_id}`)
    .then(response => response.text()) // Assuming the response is plain text or HTML
    .then(data => {
        // Assuming the first video in the list is the latest one
        // and that's where we want to append the tags
        const firstVideoTagsContainer = document.querySelector('.videos_list .video:first-child .videos_tags');
        if (firstVideoTagsContainer) {
            firstVideoTagsContainer.innerHTML = data;
        }
    })
    .catch(error => {
        console.error('Error fetching video tags:', error);
    });
}


function clearNewVideoform(){
    video_url.style.borderWidth = "1px";
    video_url.style.borderColor = "#d1d1d1";
    document.getElementById("video_url").value = "";
    document.getElementById("video_title").value = "";
    document.querySelector('select[name="edition"]').value = "java";   
    document.querySelector('select[name="modpack"]').value = "99";   
}
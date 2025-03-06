//const pagination = document.querySelector(".inner_tags_layer .tag_pagination");
const select_mod_vanila = document.querySelector(".modpack_container select");
const hide_top_bar = document.querySelector(".video_top_bar button");
const tags = document.querySelector(".tag_map");
const parentElement = document.querySelector(".inner_layer");
const modal_tag_input = document.querySelector(".inner_tags_layer input");
const closeVideoCategoryButton = document.querySelector(".inner_video_category_layer button");
const modal_comm_textarea = document.querySelector(".modal_notes textarea");
const modal_modpack_input = document.querySelector(".inner_modpack_layer input");
const modpal_comm_button = document.querySelector(".modal_notes_action");
const closeCommButton=document.querySelector(".modal_notes button");
const closeModpackButton = document.querySelector(".inner_modpack_layer button");
var search_input=document.querySelector(".search_wrap input");
var clear_button= document.querySelector(".search_wrap button");
var video_url = document.getElementById("video_url");
var videos_tag_list = document.querySelector(".modal_video_tags");
var videos_tag_list_close_button = document.querySelector(".modal_video_tags button");
const modal_new_video_tags = document.querySelector(".modal_new_tags");
const modal_new_video_tags_closeButton = document.querySelector(".modal_new_tags button");
var container_view_source = document.querySelector('.tab_view_edition');
const selectElement =document.querySelector('select[name="modpack_vanilla"]');
var container_view_style = document.querySelector('.tab_view_list_grid');
var container_view_source = document.querySelector('.tab_view_source');


selectElement.addEventListener("change", (event) => {
    console.log("Selected value:", event.target.value);
    // Ďalšie akcie, ktoré chcete vykonať pri zmene výberu
    if(event.target.value==1){
        console.log("modded");
        document.querySelector('select[name="modpack"]').removeAttribute("disabled");
        document.querySelector('select[name="category"]').removeAttribute("disabled");
    } 

    if(event.target.value==0){
        console.log("modded");
        document.querySelector('select[name="modpack"]').setAttribute("disabled",true);
        document.querySelector('select[name="category"]').setAttribute("disabled",true);
    }
    
});



/* pagination.addEventListener('click', function(event) {
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
 */

/* tags.addEventListener("click", function(event){
    if(event.target.tagName==="BUTTON"){
        const tagName = event.target.innerText;
        const tagId =event.target.getAttribute("tag-id");
        sort_videos_by_tag(tagId);
        console.log(tagName, tagId);
    }
})
 */



//console.log(hide_top_bar);

hide_top_bar.addEventListener("click",function(){
        document.getElementById("new_video").style.display="none";
})    

videos_tag_list_close_button.addEventListener("click", ()=>{
    videos_tag_list.close();
})

// Identify a common parent element


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



   /*  modal_tag_input.addEventListener("keyup",function(event){
        searchModalTags(modal_tag_input.value);
    })
 */




    modal_new_video_tags_closeButton.addEventListener("click", function() {
        //console.log(closeButton);
        document.querySelector(".modal_new_tags input").value= "";
        document.querySelector(".modal_new_tags").close();
    });




modal_comm_textarea.addEventListener("keydown", function(event) {
    if (event.key === "Enter" && modal_comm_textarea.value !== "") {
        createVideoComment(modal_comm_textarea.value);
    }
});


modpal_comm_button.addEventListener("click", ()=> {
    createVideoComment(modal_comm_textarea.value);
    //console.log("save comment / note");
})




modal_modpack_input.addEventListener("keydown", function(event) {
    if (event.key == "Enter") {
        if(modal_modpack_input.value=="") {
            alert("Input cannot be empty!");
        } else {
            ShowMessage("New modpack <b>"+modal_modpack_input.value+"</b> has been created")
            createNewModpack(modal_modpack_input.value);
        }
    }
});

modal_modpack_input.addEventListener("input", function(){
    modpackExists(modal_modpack_input.value);
    
})



     //const closeCommButton = document.querySelector(".inner_comment_layer button");

      closeCommButton.addEventListener("click", function() {
        //console.log(closeButton);
        document.querySelector(".modal_notes textarea").value="";
        document.querySelector(".modal_notes").close();
    });


   
    closeModpackButton.addEventListener("click", function() {
        document.querySelector(".inner_modpack_layer input").value="";
        document.querySelector(".modal_modpack").style.display = "none";
    });



    //clear serch input
    //var search_wrap = document.querySelector(".search_wrap");

    clear_button.addEventListener("click", function(){
        search_input.value="";
    })


    modal_new_video_tags.addEventListener("click", function(event){
        if(event.target.tagName==="BUTTON"){
           var  tagId = event.target.getAttribute("tag-id");
           //var  videoId = event.target.closest(".")
           alert(tagId);
           
           //remove from the list to avoid confusion
           document.querySelector(".modal_new_tags .tags_list").removeChild(event.target);
           //get videoId
           var videoId = sessionStorage.getItem("video_id");
           
                   
           //add tags to database
           savetoVideoTagList(videoId, tagId);
           //get videoID
        }
    })

    

  /*  const tags_map = document.querySelector(".tags_map");
    tags_map.addEventListener("click",function(event){
        if(event.target.tagName==="BUTTON"){
            console.log(event.target.textContent);
        }
    })*/

   
    // Get the input element


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


   function isValidUrl(url) {
    try {
        new URL(url);
        return true;
    } catch (e) {
        return false;
    }
}

  

  function getYouTubeVideoName_old() {
    var url = document.getElementById("video_url").value;
    
    if (!isValidUrl(url)) {
        console.error("Invalid URL provided:", url);
        ShowMessage("invalid url");
        return; // Exit the function if the URL is invalid
    }




   if(hasTimeParameter(url)===true){
    url = removeTimeParameter(url);
    console.log(url);
   }



    // Define a regular expression pattern to match YouTube URLs
   const youtubeRegex = /^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/;
    // Extract the video ID from the URL using the regular expression
    const match = url.match(youtubeRegex);

    // If a match is found, proceed
    if (match && match[1]) {
        const videoId = match[1];

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const video_name = this.responseText;

                if (video_name) {
                    document.getElementById("video_title").value = video_name;
                    
                    let bedrockVariants = ["Bedrock", "bedrock", "BEDROCK"];

                    // Check if any of the variants is included in the video name
                    for (let i = 0; i < bedrockVariants.length; i++) {
                        if (video_name.includes(bedrockVariants[i])) {
                            document.querySelector('select[name="edition"]').value = "bedrock";
                            break; // Stop searching after the first match
                        }
                    }
                } else {
                    // Handle case where video name is empty
                    ShowMessage("Video name could not be retrieved.");
                }
            }
        };
        xhttp.open("GET", "get_youtube_video_name.php?videoUrl="+encodeURIComponent(url), true);
        xhttp.send();

        // You can use the video ID to make API requests or perform other actions
        return videoId;
    } else {
        // Display error message if the URL is not valid
        ShowMessage("This is not a valid YouTube video URL");
        return null;
    }
}


function getYouTubeVideoName() {
    var url = document.getElementById("video_url").value;

    // Validácia URL
    if (!isValidUrl(url)) {
        console.error("Invalid URL provided:", url);
        ShowMessage("Invalid URL");
        return; // Exit the function if the URL is invalid
    } else {
        // Kontrola a odstránenie časového parametra
        if (hasTimeParameter(url)) {
            url = removeTimeParameter(url);
            console.log("URL after removing time parameter:", url);
        }

        // Definovanie regulárneho výrazu na zhodu s YouTube URL
        const youtubeRegex = /^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/;
        
        // Extrakcia ID videa z URL pomocou regulárneho výrazu
        const match = url.match(youtubeRegex);

        // Ak je nájdená zhoda, pokračuj
        if (match && match[1]) {
            const videoId = match[1];

            // Asynchrónne volanie na získanie názvu videa
            fetch("get_youtube_video_name.php?videoUrl=" + encodeURIComponent(url))
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.text();
                })
                .then(video_name => {
                    if (video_name) {
                        document.getElementById("video_title").value = video_name;

                        let bedrockVariants = ["Bedrock", "bedrock", "BEDROCK"];

                        // Kontrola, či názov videa obsahuje varianty "Bedrock"
                        if (bedrockVariants.some(variant => video_name.includes(variant))) {
                            document.querySelector('select[name="edition"]').value = "bedrock";
                        }
                    } else {
                        // Spracovanie prípadu, keď názov videa je prázdny
                        ShowMessage("Video name could not be retrieved.");
                    }
                })
                .catch(error => {
                    console.error('Error fetching video name:', error);
                    ShowMessage("An error occurred while fetching the video name.");
                });

            // Môžeš použiť video ID na vykonávanie API požiadaviek alebo iné akcie
            return videoId;
        } else {
            // Zobrazenie chybovej správy, ak URL nie je platná
            ShowMessage("This is not a valid YouTube video URL");
            return null;
        }
    }
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
                
                return false;
            } else {
                video_url.style.borderWidth = "3px";
                video_url.style.borderColor = "#27ae60";
                
            }
        }
    };
    xhttp.open("GET", "check_video_id.php?video_id=" + video_url.value, true);
    xhttp.send();
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




//sorts videos by source 

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

  //sorts videos by edition
    

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
            document.querySelector(".modal_video_tags").showModal();
         }
        
    });

var container_view_export = document.querySelector(".tab_view_export");

    // Add a click event listener to the container
    container_view_export.addEventListener('click', function(event) {
         if(event.target.tagName==="BUTTON"||event.target.tagName==="I"){
             buttonName = event.target.name;
            if(buttonName ==="export_all_videos_cvs"){
               exportCSV();
            }   else if (buttonName==="eport_farms_cvs"){
                exportFarmsCSV();
            }
        }
    });

//sorts videos according the source like pinterest, youtube, tiktok
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


//sorts videos according edition like Java, Bedrock, both
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

//sorts videos according particular tag
function sort_videos_by_tag(source){
      var xhttp = new XMLHttpRequest();
       //var search_text=document.getElementById("search_string").value;
       xhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               document.getElementById("videos_list").innerHTML =
                   this.responseText;
           }
       };
       xhttp.open("GET", "videos_sorted_by_tag.php?sort_by=" + source, true);
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

//reload modpacks in new video forms
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


//sorts videos according by particular mod
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


//sorts videos according modpack
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


//sorts videos according watch later status
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

//this function should swtich displaying video content from list to card and vice versa
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

//restore back original style for he url in new video form
function clear_video_url_style(){
    video_url.style.borderWidth = "1px";
    video_url.style.borderColor = "#d1d1d1";
    document.getElementById("video_url").value = "";
    document.getElementById("video_title").value = "";
    document.querySelector('select[name="edition"]').value = "java";   
};



//creates tags for the video
function createVideoTag(tag_name){
    const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            const video_id = sessionStorage.getItem("video_id");
            document.querySelector(".modal").close();
            document.querySelector(".modal input").value = "";
            reloadTags(video_id);

          }
        
        const video_id = sessionStorage.getItem("video_id");

        xhttp.open("POST", "video_create_tag.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "video_id="+encodeURIComponent(video_id)+"&tag_name="+encodeURIComponent(tag_name);                
        xhttp.send(data);
}


//create new comment for the video using modal comment dialog
function createVideoComment(comment){
    const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            const input = document.querySelector(".modal_notes textarea");
            input.value="";
            document.querySelector(".modal_notes").close();
          }
        
        video_id = sessionStorage.getItem("video_id");

        xhttp.open("POST", "video_comment_create.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "video_id="+encodeURIComponent(video_id)+"&comment="+encodeURIComponent(comment);                
        xhttp.send(data);
}


//relads tags
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


//creates new modpack
function createNewModpack(modpack_name) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        const modpck = document.querySelector(".modpack_container");
        // Find the previous select element with name "modpack"
        const oldSelect = modpck.querySelector('select[name="modpack"]');
        let referenceNode = null;
        if (oldSelect) {
            referenceNode = oldSelect.nextSibling;
            modpck.removeChild(oldSelect);
        }

        // Create a temporary container to hold the response HTML
        const tempContainer = document.createElement('div');
        tempContainer.innerHTML = this.responseText;

        // Extract the new select element
        const newSelect = tempContainer.querySelector('select[name="modpack"]');
        if (newSelect) {
            if (referenceNode) {
                modpck.insertBefore(newSelect, referenceNode);
            } else {
                modpck.appendChild(newSelect);
            }
        }

        document.querySelector(".modal_modpack").close();
    };

    xhttp.open("POST", "video_modpack_create.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var data = "modpack_name=" + encodeURIComponent(modpack_name);
    xhttp.send(data);
}



//autocomplete for modal add tag dialog
function TagAutocomplete(tag) {
    // Reference to the input field, list, and list container
    const inputField = document.querySelector(".inner_layer input");
    const list = document.querySelector(".inner_layer ul");
    const list_container = document.querySelector(".list_container");
    const loadingIndicator = document.querySelector(".loading");
    //list.style.borderWidth = "1px";

    // Clear the autocomplete list if the tag is empty
    if (tag === "") {
        list.innerHTML = "";
        list.style.display = "none";
        //loadingIndicator.style.display = "none";
        return; // Exit the function early
    }

    // Clear the list and show loading indicator before making a new request
    list.classList.add("hidden");
    //loadingIndicator.style.display = "block";
    
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        // Parse the JSON response
        const jsonData = JSON.parse(this.responseText);

        // Create a document fragment to minimize DOM updates
        const fragment = document.createDocumentFragment();
        
        jsonData.forEach(function(currentTag) {
            const tagName = currentTag.tag_name; // Assuming your objects have a 'tag_name' property
            
            const listItem = document.createElement("li");
            listItem.textContent = tagName;

            // Add click event listener to each list item
            listItem.addEventListener("click", function() {
                inputField.value = this.textContent; // Set input value to the clicked item's text
                list.innerHTML = ""; // Optionally clear the list after selection
                list.style.display = "none";
                //loadingIndicator.style.display = "none";
            });

            // Add list item to the fragment
            fragment.appendChild(listItem);
        });

        // Clear the list and append new items from the fragment
        list.innerHTML = "";
        list.appendChild(fragment);

        // Hide loading indicator and show the list with a transition
        //loadingIndicator.style.display = "none";
        list.classList.remove("hidden");
        list.style.display = "flex";
        //list_container.style.display = "block";
    };

    xhttp.open("GET", "video_tags_autocomplete.php?tag=" + encodeURIComponent(tag), true);
    xhttp.send();
}


// Event listener for the input field to trigger autocomplete
document.querySelector(".inner_layer input").addEventListener("keyup", function() {
    TagAutocomplete(this.value);
});


//clears autocomplete from previous results
function RemovePrevResults() {
    let listItems = document.querySelectorAll(".inner_layer ul li");
    listItems.forEach(function(item) {
        item.remove();
    });
    document.querySelector(".inner_layer ul").style.borderWidth="0px";
}



function loadVideoTags(videoId) {
    const url = `video_tags.php?video_id=${videoId}`;
    const videoTags = document.querySelector(".video_tags"); 

    // Vyčistíme obsah před načtením nových tagů
    videoTags.innerHTML = '';

    fetch(url)
        .then(response => response.json())
        .then(tagsObj => {
            for (const [id, tag] of Object.entries(tagsObj)) {
                const buttonTag = `
                    <button class='button small_button'>
                        ${tag}
                        <i class="fa fa-times" onclick="remove(this, '${tag}')"></i>
                    </button>
                `;
                videoTags.insertAdjacentHTML("afterbegin", buttonTag);
            }
        })
        .catch(error => console.error(error));
}


//searches tags in modal tags dialog
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

//pagination for modal tags
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

//show off new video form
function showNewVideoForm(){
    var div = document.getElementById('new_video');
    div.style.display = 'flex';
   window.scrollTo({
  top: 0,
  behavior: 'smooth' // This makes the scrolling smooth, omit if not needed
});
}


//show custome message
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



//create new video
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
        ShowMessage("Video added successfully!");
       fetchLatestVideo();
       clearNewVideoform();
    })
    .catch((error) => {
        console.error('Error:', error);
        //document.getElementById('message').innerText = 'An error occurred';
    });
});



//gat latest video and display him in the list
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
    fetch(`videos_get_tags.php?video_id=${video_id}`)
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
    document.querySelector('select[name="modpack"]').value = "0";   
}

function exportCSV() {
    var xhttp = new XMLHttpRequest();

    // Check the state of the AJAX request
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            // Show a message when the export is successful
            ShowMessage("Videos have been exported ...");
        }
    };

    // Configure the request
    xhttp.open("POST", "videos_export_to_csv.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // You need to define the `data` variable before calling `exportCSV()`
    // For example:
    // var data = "param1=value1&param2=value2";

    // Send the request with data (assuming `data` is defined elsewhere)
    xhttp.send();
}


function exportFarmsCSV() {
    var xhttp = new XMLHttpRequest();

    // Check the state of the AJAX request
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            // Show a message when the export is successful
            ShowMessage("Videos (Farms) have been exported ...");
        }
    };

    // Configure the request
    xhttp.open("POST", "videos_export_farms_to_csv.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // You need to define the `data` variable before calling `exportCSV()`
    // For example:
    // var data = "param1=value1&param2=value2";

    // Send the request with data (assuming `data` is defined elsewhere)
    xhttp.send();
}

function modpackExists(text) {
    console.log(text);
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState === 4) {
            if (this.status === 200) {
                if (this.responseText === "1") {
                    // Warning modpack exists and remove text from input
                    var modalModpackInput = document.querySelector(".modal_modpack input");
                    modalModpackInput.style.border = "2px solid red";
                    ShowMessage("Modpack already exists!");
                    //return input style back to normal
                    setTimeout(function() {
                        modalModpackInput.style.border = "";
                    }, 3000);
                    modalModpackInput.value = "";
                } else {
                    ShowMessage("New modpack <b>" + modal_modpack_input.value + "</b> has been created");
                    createNewModpack(text);
                }
            } else {
                console.error("Error: " + this.status);
            }
        }
    };

    xhttp.open("GET", "modpack_check.php?modpack=" + encodeURIComponent(text), true);
    xhttp.send();
} 
       

  function backModalModpackNormal(){
    modal_modpack_input.border="1px solid #d1d1d1";
 }

 function removeTimeParameter(url) {
    const urlObj = new URL(url);
    urlObj.searchParams.delete('t');
    return urlObj.toString();
}

function hasTimeParameter(url) {
    const urlObj = new URL(url);
    return urlObj.searchParams.has('t');
}


function savetoVideoTagList(videoId, tagId){
    var xhttp = new XMLHttpRequest();
    console.log("video id:"+videoId+", tag id: "+tagId);
    // Check the state of the AJAX request
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            // Show a message when the export is successful
            ShowMessage("tags has been added successfully!");
        }
    };

    // Configure the request
    xhttp.open("POST", "video_tag_save.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // You need to define the `data` variable before calling `exportCSV()`
    // For example:
     var data = "tag_id="+tagId+"&video_id="+videoId;

    // Send the request with data (assuming `data` is defined elsewhere)
    xhttp.send(data);
}
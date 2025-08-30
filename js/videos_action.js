//import {ShowMessage} from '/videos.js';
var container = document.querySelector('.videos_list');

// Add a click event listener to the container
container.addEventListener('click', function(event) {
    var target = event.target;

    // Find the closest button ancestor of the clicked element
    var button = target.closest('button');

    // If the clicked element is not a button, check if it's an <i> element
    if (!button && target.tagName === 'I') {
        // Find the closest button ancestor of the <i> element
        button = target.closest('button');
    }

    // If a button is found
    if (button) {
        var buttonName = button.getAttribute('name');
        var videoId = button.getAttribute('video-id');
        
        switch (buttonName) {
            case 'add_to_favorites':
            case 'watch_later':
                if (buttonName === 'add_to_favorites') {
                    add_to_favorites(videoId);
                } else {
                    add_watch_later(videoId);
                }
                button.setAttribute('name', buttonName === 'add_to_favorites' ? 'remove_from_favorites' : 'remove_watch_later');
                button.innerHTML = buttonName === 'add_to_favorites' ? "<i class='fas fa-star'></i>" : "<i class='fas fa-clock'></i>";
                alert(buttonName === 'add_to_favorites' ? 'Added to Favorites' : 'Added to Watch later');
                break;
            case 'remove_from_favorites':
            case 'remove_watch_later':
                if (buttonName === 'remove_from_favorites') {
                    remove_from_favorites(videoId);
                } else {
                    remove_watch_later(videoId);
                }
                button.setAttribute('name', buttonName === 'remove_from_favorites' ? 'add_to_favorites' : 'watch_later');
                button.innerHTML = buttonName === 'remove_from_favorites' ? "<i class='far fa-star'></i>" : "<i class='far fa-clock'></i>";
                alert(buttonName === 'remove_from_favorites' ? 'Removed from Favorites' : 'Removed from Watch later');
                break;
            case 'delete_video':
                delete_video(videoId);
                //alert('Removed!');
                break;
            case 'edit_video':
                window.location.href = "video_edit.php?video_id=" + videoId;
                break;
            case 'add_note':
                // Implement your add_note functionality here
                //alert("Adding new node/comment");
                console.log("add new comment");
                document.querySelector(".modal_notes").showModal();
                sessionStorage.setItem("video_id", videoId);
                break;

            case 'new_tag':
                console.log("create new tag(s)");    
                //document.querySelector(".modal").style.display = "flex";
                document.querySelector(".modal_new_tags").showModal();
                const video_id = event.target.closest(".videos_tags").getAttribute("video-id");
                sessionStorage.setItem("video_id", videoId);
                break;

            case 'video_tags_count':
                var videoId = event.target.closest(".videos_tags").getAttribute("video-id");
                sessionStorage.setItem("video_id", videoId);
                console.log("getting list of tags");
                loadVideoTags(videoId); // zavolá funkci před zobrazením modalu
                document.querySelector(".modal_video_tags").showModal();
                break;

            case 'change_modpack':
                var videoId = event.target.closest(".video").getAttribute("video-id");
                sessionStorage.setItem("video_id", videoId);
                console.log("change modpack");
                document.querySelector(".modal_change_modpack").showModal();
                break;
            case 'add_mod':
                var videoId = event.target.closest(".video").getAttribute("video-id");
                sessionStorage.setItem("video_id", videoId);
                console.log("add mod");
                //check what typpe of game Vanilla or modded it is. 
                if(document.querySelector(`.video[video-id='${videoId}'] .video_modpack_info button[name='change_modpack'`).innerText=="Vanilla Minecraft"){
                    alert("Vanilla Minecraft games don't have modpacks. You can't add mods to them.");
                    return;
                } else{
                    document.querySelector(".modal_modpack_mods").showModal();
                }
                
                break;
            
                
            default:
                // Handle default case or ignore
                break;
        }
    }
});

var addModpackButton = document.querySelector(".modpack_container button");
addModpackButton.addEventListener("click", function(){
    document.querySelector(".modal_modpack").showModal();
})




   function add_to_favorites(videoId){
      const xhttp = new XMLHttpRequest();
      
       xhttp.open("POST", "video_manage_favorites.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                
        data = "&video_id=" + encodeURIComponent(videoId) + "&is_favorite=1";
        xhttp.send(data); 
      console.log("added to favorites....");
   }

   function remove_from_favorites(videoId){
     const xhttp = new XMLHttpRequest();
      
       xhttp.open("POST", "video_manage_favorites.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                
        data = "&video_id=" + encodeURIComponent(videoId) + "&is_favorite=0";
        xhttp.send(data); 
      console.log("removed from favorites ...");
   }

   function add_watch_later(videoId){
       const xhttp = new XMLHttpRequest();
      
       xhttp.open("POST", "video_manage_watch_later.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                
        data = "&video_id=" + encodeURIComponent(videoId) + "&watch_later=1";
        xhttp.send(data); 
      console.log("added to watch later....");
   }

   function remove_watch_later(videoId){
    const xhttp = new XMLHttpRequest();
      
       xhttp.open("POST", "video_manage_watch_later.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                
        data = "&video_id=" + encodeURIComponent(videoId) + "&watch_later=0";
        xhttp.send(data); 
    console.log("removed from watch later....");
   }

 function delete_video(videoId) {
    const xhttp = new XMLHttpRequest();
    
    // Define what happens on successful data submission
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            var videosListDiv = document.querySelector('.videos_list');
            if (videosListDiv) {
                var videoDivToRemove = videosListDiv.querySelector('.video[video-id="' + videoId + '"]');
                console.log(videoDivToRemove);
                if (videoDivToRemove) {
                    videoDivToRemove.parentNode.removeChild(videoDivToRemove);
                    ShowMessage("video " + videoId + " has been removed...."); // Moved inside the if block
                } else {
                    console.log('No video div found with video-id:', videoId);
                }
            } else {
                console.log('Videos list div not found');
            }
        }
    };
    
    // Configure the request
    xhttp.open("POST", "video_delete.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    // Send the request with data
    var data = "video_id=" + encodeURIComponent(videoId);
    xhttp.send(data);
}



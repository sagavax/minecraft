 

function getYouTubeVideoName(url) {
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
                    document.getElementById("video_title").innerHTML = this.responseText;
                    
                  }
                };
                xhttp.open("GET", "get_youtube_video_name.php?videoUrl="+url, true);
                xhttp.send();
        

        // You can use the video ID to make API requests or perform other actions
        return videoId;
    } else {
        // Return null if the URL is not recognized
        return null;
    }
}

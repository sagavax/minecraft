var buttons = document.querySelectorAll('.tasks button');

// Add event listener to each button
buttons.forEach(function(button) {
  button.addEventListener('click', function() {
    // Get the name attribute of the clicked button
    var buttonName = button.getAttribute('name');
    var taskId = button.getAttribute('task-id');

    if(buttonName==="complete_task") {
      alert("Complete task!");
      task_completed(taskId);  
    }

    if(buttonName==="edit_task"){
      window.location.href="vanilla_task_edit.php?task_id="+taskId;
    }
    
    // Log the name attribute to the console (you can modify this part as needed)
       // console.log('Button clicked: ' + buttonName + ', Task ID: ' + taskId);
  });
});


var container = document.querySelector('.task_view');

    // Add a click event listener to the container
    container.addEventListener('click', function(event) {
        // Check if the clicked element is a button
        if (event.target.tagName === 'BUTTON'){
            // Get the name attribute of the clicked button
            var buttonName = event.target.getAttribute('name');
            
            base_tasks_sort_by_status(buttonName);
            
            // Do something with the buttonName, for example, log it to the console
            console.log('Button clicked with name:', buttonName);
            //console.log('Button clicked with video-id:', videoId);
        }
    });


     function base_tasks_sort_by_status(status){

       var xhttp = new XMLHttpRequest();
                  xhttp.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                    document.querySelector(".tasks").innerHTML = this.responseText;
                    
                  }
                };
                var modpack_id = localStorage.getItem("modpack_id");
                //xhttp.open("GET", "count_comments.php?video_id=<?php echo $_GET['video_id'] ?>", true);
                xhttp.open("GET", "base_tasks_sort_by_status.php?status="+encodeURIComponent(status));
                xhttp.send();
    }


    function search_the_string(){
             var xhttp = new XMLHttpRequest();
             var search_text=document.getElementById("search_string").value;
             xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                document.getElementById("tasks").innerHTML =
                    this.responseText;
                       }
                    };
                xhttp.open("GET", "vanilla_tasks_search.php?search="+search_text, true);
                xhttp.send();
                           
            }
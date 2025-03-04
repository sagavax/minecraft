
const taskTopBarButton = document.querySelector(".task_top_bar button");
taskTopBarButton.addEventListener("click",function(){
    document.getElementById("new_task").style.display="none";
})

document.querySelector("#new_task form").addEventListener("submit", function(event){
  // Check if the textarea value is empty (no characters)
  if(document.querySelector("#new_task textarea").value === "") {
    alert("text cannot be empty!");  // Shortened the message a bit
    event.preventDefault(); // Prevent form submission
  }
});

var taskRadiosContainers = document.querySelectorAll('.task_view');

    // Convert NodeList to an array and loop through each container
    Array.from(taskRadiosContainers).forEach(function (container) {
      // Get all radio buttons inside the current container
      var taskRadioButtons = container.querySelectorAll('input[type="radio"]');

      // Add click event listener to each radio button
      taskRadioButtons.forEach(function (taskRadioButton) {
        taskRadioButton.addEventListener('click', function () {
          // Get the id of the clicked radio button
          var status = taskRadioButton.id;
          console.log(status);
          sort_tasks_by_status(status);
        });
      });
    });


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
      window.location.href="task.php?task_id="+taskId;
    }
    
    // Log the name attribute to the console (you can modify this part as needed)
       // console.log('Button clicked: ' + buttonName + ', Task ID: ' + taskId);
  });
});


function task_completed(taskId) {
  const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {

          }
          
        xhttp.open("POST", "task_completed.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "task_id="+encodeURIComponent(taskId);                
        xhttp.send(data);
}


var container = document.querySelector('.task_view');

    // Add a click event listener to the container
    container.addEventListener('click', function(event) {
        // Check if the clicked element is a button
        if (event.target.tagName === 'BUTTON'){
            // Get the name attribute of the clicked button
            var buttonName = event.target.getAttribute('name');
            
            sort_tasks_by_status(buttonName);
            
            // Do something with the buttonName, for example, log it to the console
            console.log('Button clicked with name:', buttonName);
            //console.log('Button clicked with video-id:', videoId);
        }
    });


var tasks = document.querySelector('.tasks');
    // Add a click event listener to the container
    container.addEventListener('click', function(event) {
        // Check if the clicked element is a button
        if (event.target.tagName === 'DIV'){
            console.log(event.target.tagName);
            // Get the name attribute of the clicked button
            const taskId = document.querySelector(".task").getAttribute("id");
            window.href="task.php?task_id="+taskId;
        }
    });



var container = document.querySelector('.tab_view');

    // Add a click event listener to the container
    container.addEventListener('click', function(event) {
        // Check if the clicked element is a button
        if (event.target.tagName === 'BUTTON'){
            // Get the name attribute of the clicked button
            var buttonName = event.target.getAttribute('name');
            
            sort_tasks_by_modif(buttonName);
            
            // Do something with the buttonName, for example, log it to the console
            console.log('Button clicked with name:', buttonName);
            //console.log('Button clicked with video-id:', videoId);
        }
    });

var container = document.querySelector('.modpack_view');

    // Add a click event listener to the container
    container.addEventListener('click', function(event) {
        // Check if the clicked element is a button
        if (event.target.tagName === 'BUTTON'){
            // Get the name attribute of the clicked button
            var buttonName = event.target.getAttribute('name');
            var modpack_id = event.target.getAttribute("modpack-id");
            console.log(modpack_id);
            sort_tasks_by_modpack(modpack_id);
            
            // Do something with the buttonName, for example, log it to the console
            console.log('Button clicked with name:', buttonName);
            //console.log('Button clicked with video-id:', videoId);
        }
    });


    function sort_tasks_by_status(status){

       var xhttp = new XMLHttpRequest();
                  xhttp.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                    document.querySelector(".tasks").innerHTML = this.responseText;
                    
                  }
                };
                var modpack_id = localStorage.getItem("modpack_id");
                //xhttp.open("GET", "count_comments.php?video_id=<?php echo $_GET['video_id'] ?>", true);
                xhttp.open("GET", "tasks_sorted_by_status.php?status="+encodeURIComponent(status));
                xhttp.send();
    }


      function sort_tasks_by_modif(sort_by){

       var xhttp = new XMLHttpRequest();
       //var search_text=document.getElementById("search_string").value;
       xhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               document.getElementById("tasks").innerHTML =
                   this.responseText;
           }
       };
       xhttp.open("GET", "tasks_sorted_by_modif.php?sort_by=" + sort_by, true);
       xhttp.send();
    }


      function sort_tasks_by_modpack(sort_by){

       var xhttp = new XMLHttpRequest();
       //var search_text=document.getElementById("search_string").value;
       xhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               document.getElementById("tasks").innerHTML =
                   this.responseText;
           }
       };
       xhttp.open("GET", "tasks_sorted_by_modpack.php?sort_by=" + sort_by, true);
       xhttp.send();
    }

 function searchTask(){
             var xhttp = new XMLHttpRequest();
             var search_text=document.getElementById("search_string").value;
             xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                document.getElementById("tasks").innerHTML =
                    this.responseText;
                       }
                    };
                xhttp.open("GET", "tasks_search.php?search="+search_text, true);
                xhttp.send();
                           
            }
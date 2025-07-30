
const taskTopBarButton = document.querySelector(".task_top_bar button");
const tasks = document.querySelector('.tasks');
const dialog_modpacks = document.querySelector('.dialog_modpacks');



document.querySelector(".search_wrap input").addEventListener("keyup", () => {
  searchTask(document.querySelector(".search_wrap input").value);
});


dialog_modpacks.addEventListener("click", function(event){
  if(event.target.tagName === "BUTTON"){
    const modpackId = event.target.getAttribute("modpack-id");
    const taskId = sessionStorage.getItem("task_id");
    //const taskId = sessionStorage.getItem("task_id");
    addModpackToTask(taskId, modpackId);
    dialog_modpacks.close();
  }
})


taskTopBarButton.addEventListener("click",function(){
    document.getElementById("new_task").style.display="none";
})

document.querySelector("#new_task form").addEventListener("submit", function(event){
  // Check if the textarea value is empty (no characters)
  if(document.querySelector("#new_task textarea").value === "") {
    alert("text cannot be empty!");  // Shortened the message a bit
    event.preventDefault(); // Prevent form submission
  } else {
    createTask();
  }
});


tasks.addEventListener('click', function(event) {
  // Nájde najbližší element s triedou .task a získa task-id
  
  const taskId = event.target.closest(".task").getAttribute("id");
  sessionStorage.setItem("task_id", taskId);
  
  if (event.target.tagName === 'BUTTON') {
    const buttonName = event.target.name;

    if (buttonName === "edit_task") {
      window.location.href = "task.php?task_id=" + taskId;
    }

    if (buttonName === "complete_task") {
      taskCompleted(taskId);
    }

    if (buttonName === "add_modpack" || buttonName === "assigned_modpack") {
      //check if task is not completed
      const isCompleted = document.querySelector(`.task[id="${taskId}"] .task_footer span`);//.textContent === "Complete";
      if(isCompleted) {
        alert("Task is completed!");
        return;
      } else {
        dialog_modpacks.showModal();  
      }
    }
  }
});

tasks.addEventListener('click', function(event) {
  //const taskId = event.target.closest(".task").getAttribute("id");
  if(event.target.classList.contains("task_body")) {
    const taskId = event.target.closest(".task").getAttribute("id");
     const taskBody = document.querySelector(`.task[id="${taskId}"] .task_body`);
      taskBody.setAttribute("contenteditable", "true");
      taskBody.focus();
    //switchToTextarea(taskId);
  }
});


tasks.addEventListener("blur", function(event) {
  const taskId = event.target.closest(".task").getAttribute("id");
  const taskBody = document.querySelector(`.task[id="${taskId}"] .task_body`);
  taskBody.setAttribute("contenteditable", "false");
  SaveTaskChanges(taskId, taskBody.innerText);
});

function taskCompleted(taskId) {
  const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            alert("Task completed!");
          }
          
        xhttp.open("POST", "task_completed.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "task_id="+encodeURIComponent(taskId);                
        xhttp.send(data);
}


var taskView = document.querySelector('.task_view');

    // Add a click event listener to the container
    taskView.addEventListener('click', function(event) {
        // Check if the clicked element is a button
        if (event.target.tagName === 'BUTTON'){
            // Get the name attribute of the clicked button
            var buttonName = event.target.getAttribute('name');
            
            sortTasksByStatus(buttonName);
            
            // Do something with the buttonName, for example, log it to the console
            console.log('Button clicked with name:', buttonName);
            //console.log('Button clicked with video-id:', videoId);
        }
    });



    // Add a click event listener to the container
    taskView.addEventListener('click', function(event) {
        // Check if the clicked element is a button
        if (event.target.tagName === 'DIV'){
            console.log(event.target.tagName);
            // Get the name attribute of the clicked button
            const taskId = document.querySelector(".task").getAttribute("id");
            window.href="task.php?task_id="+taskId;
        }
    });



var tabView = document.querySelector('.tab_view');

    // Add a click event listener to the container
    tabView.addEventListener('click', function(event) {
        // Check if the clicked element is a button
        if (event.target.tagName === 'BUTTON'){
            // Get the name attribute of the clicked button
            var buttonName = event.target.getAttribute('name');
            
            sortTasksByModif(buttonName);
            
            // Do something with the buttonName, for example, log it to the console
            console.log('Button clicked with name:', buttonName);
            //console.log('Button clicked with video-id:', videoId);
        }
    });

var modpackView = document.querySelector('.modpack_view');

    // Add a click event listener to the container
    modpackView.addEventListener('click', function(event) {
        // Check if the clicked element is a button
        if (event.target.tagName === 'BUTTON'){
            // Get the name attribute of the clicked button
            var buttonName = event.target.getAttribute('name');
            var modpack_id = event.target.getAttribute("modpack-id");
            console.log(modpack_id);
            sortTasksByModpack(modpack_id);
            
            // Do something with the buttonName, for example, log it to the console
            console.log('Button clicked with name:', buttonName);
            //console.log('Button clicked with video-id:', videoId);
        }
    });


    function sortTasksByStatus(status){

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


      function sortTasksByModif(sort_by){

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


      function sortTasksByModpack(sort_by){

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

function createTask(){
    
  const taskText = document.querySelector(`#new_task textarea[name="task_text"]`).value;
    const mod = document.querySelector(`#new_task select[name="category"]`).value;
    const modpack = document.querySelector(`#new_task select[name="modpack"]`).value;


    var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        alert("Task has been added");
                }
            };
        xhttp.open("POST", "task_add.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        const data = "task_text="+encodeURIComponent(taskText)+"&category="+encodeURIComponent(mod)+"&modpack="+encodeURIComponent(modpack);
        xhttp.send(data);
                    
}

function addModpackToTask(taskId, modpackId){
    
    var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        alert("Modpack has been updated / added");
                }
            };
        xhttp.open("POST", "task_update_modpack.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        const data = "task_id="+encodeURIComponent(taskId)+"&modpack_id="+encodeURIComponent(modpackId);
        xhttp.send(data);
}

function  SaveTaskChanges(taskId, taskBody){

    var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        alert("Task has been updated");
                }
            };
        xhttp.open("POST", "task_update_task_text.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        const data = "task_id="+encodeURIComponent(taskId)+"&task_text="+encodeURIComponent(taskBody);
        xhttp.send(data);
}
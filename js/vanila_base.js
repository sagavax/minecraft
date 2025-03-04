            // Initialize the default tab. This could also read from localStorage to remember the last selected tab.
            showTab("Notes");    

            function showTab(tabName) {
                tabName = tabName.toLowerCase(); // Ensure tabName is in lowercase
                localStorage.setItem("base_info_tab", tabName);

                const tabs = ["notes", "tasks", "ideas", "images"];
                tabs.forEach(tab => {
                    document.getElementById(tab).style.display = "none";
                });

                document.getElementById(tabName).style.display = "flex";
            }

             
				document.getElementById("notes").style.display="block";	
				document.getElementById("tasks").style.display="none";	
				document.getElementById("ideas").style.display="none";	
				document.getElementById("images").style.display="none";	

             //document.getElementById("new_note").style.display="none";
             //document.getElementById("new_task").style.display="none";
          
             add_note = document.getElementById("add_new_note");
             save_button  =document.getElementById("save_note");
             add_task = document.getElementById("add_new_task");
             save_button  =document.getElementById("save_task");
           


            document.querySelectorAll(".base_wall_tabs button").forEach(button => {
                button.addEventListener("click", function() {
                    showTab(this.getAttribute("data-tab"));
                });
            });



		//save base note
		var saveNoteBtn =document.querySelector(".new_base_note button");
		saveNoteBtn.addEventListener("click",function(){
			saveBaseNote();

		})

		var saveTaskBtn =document.querySelector(".new_base_task button");
		saveTaskBtn.addEventListener("click",function(){
			save_base_task();	
		})

		var saveIdeaBtn =document.querySelector(".new_base_idea button");
		saveIdeaBtn.addEventListener("click",function(){
			save_base_idea();
		})


     	 function save_base_idea(){

     	 	var idea_title = document.getElementById("base_idea_title").value;
 	        var idea_text = document.getElementById("base_idea_text").value;
            var ideas_container = document.querySelector('.base_ideas_list');
				
			var xhttp = new XMLHttpRequest();
             xhttp.onreadystatechange = function() {
                 if (this.readyState == 4 && this.status == 200) {
                       var max_idea_id = this.responseText.trim(); 
                       ideas_container.insertAdjacentHTML("afterbegin","<div class='idea vanilla_idea' idea-id="+max_idea_id+"><div class='base_idea_title'>"+idea_title+"</div><div class='base_idea_text'>"+idea_text+"</div><div class='base_idea_footer'><div class='vanila_note_act'><button class='button small_button' name='delete_idea';'><i class='fa fa-times' title='Delete idea'></i></button></div></div></div>"); 
                       document.getElementById("base_idea_text").value="";
                       document.getElementById("base_idea_title").value="";
                      }
                 };
          		
				xhttp.open("POST", "base_idea_create.php",true);
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                var base_id = sessionStorage.getItem('base_id');
			    var data = "idea_title="+encodeURIComponent(idea_title)+"&idea_text="+encodeURIComponent(idea_text)+"&base_id="+encodeURIComponent(base_id);
            	xhttp.send(data);
	
        }

        function save_base_task(){
 			var task_text = document.getElementById("base_task_text").value;
            var tasks_container = document.querySelector('.base_tasks_list');

 			var xhttp = new XMLHttpRequest();
                  xhttp.onreadystatechange = function() {
                     if (this.readyState == 4 && this.status == 200) {
                        var max_task_id = this.responseText.trim(); 
                        tasks_container.insertAdjacentHTML("afterbegin","<div class='task vanilla_task' task-id="+max_task_id+"><div class='task_body'>"+task_text+"</div><div class='task_footer'><div class='task_action'><button class='button small_button'><i class='fa fa-check' name='complete_task'></i></button></div></div></div>");   
                       document.getElementById("base_task_text").value="";
                      }
                    };
                  var base_id = sessionStorage.getItem('base_id');
                  var data = "task_text="+encodeURIComponent(task_text)+"&base_id="+encodeURIComponent(base_id);
                  xhttp.open("POST", "base_task_create.php", true);
                  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                  xhttp.send(data);
	         }

        async function saveBaseNote() {
                const noteText = document.getElementById("base_note_text").value;
                const noteTitle = document.getElementById("base_note_title").value;

                const baseId = sessionStorage.getItem('base_id');
                const data = new URLSearchParams({
                    'note_text': noteText,
                    'note_title': noteTitle,
                    'base_id': baseId
                });

                try {
                    const response = await fetch('base_create_note.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: data,
                    });

                    if (response.ok) {
                        const maxNoteId = await response.text();
                        notes_container.insertAdjacentHTML("afterbegin", `
                            <div class='base_note' note-id="${maxNoteId}">
                                <div class='vanila_note_title'>${noteTitle}</div>
                                <div class='vanila_note_text'>${noteText}</div>
                                <div class='vanila_note_act'>
                                    <button class='button small_button'><i class='fa fa-times' name='remove_note'></i></button>
                                </div>
                            </div>`
                        );

                        document.getElementById("base_note_text").value = "";
                        document.getElementById("base_note_title").value = "";
                    } else {
                        console.error('Failed to save base note');
                    }
                } catch (error) {
                    console.error('An error occurred while saving base note:', error);
                }
            }

        //ideas    
          var ideas_container = document.querySelector('.base_ideas_list');

        ideas_container.addEventListener('click', function(event) {
            // Check if the clicked element is a button with name 'remove_idea'
            if (event.target.tagName === 'BUTTON' || event.target.tagName==='I') {
                 var remove_button = event.target;

                // Find the closest .idea element and get its idea-id attribute
                var ideaId = remove_button.closest(".idea").getAttribute('idea-id');

                // Remove the idea by calling the removeIdea function and remove associated elements
                removeIdea(ideaId);
                ideas_container.querySelector('[idea-id="'+ideaId+'"]').remove();
            }
        });

          
            var notes_container = document.querySelector('.base_notes_list');

            // Add a click event listener to the container
            notes_container.addEventListener('click', function(event) {
                // Check if the clicked element is a button
                if (event.target.tagName === 'BUTTON' || event.target.tagName==='I'){
                    // Get the name attribute of the clicked button
                    //var buttonName = event.target.getAttribute('name');
                    var remove_button = event.target;
                    var top_div = remove_button.closest(".base_note");	
                    var noteId = top_div.getAttribute('note-id');
                    removeNote(noteId);

                    let childrenToRemove = Array.from(notes_container.querySelectorAll('[note-id="'+noteId+'"]'));
                    childrenToRemove.forEach(child => {
            			child.remove();
        			});
                    //console.log('Button clicked with video-id:', videoId);
                }
            });


            var tasks_container = document.querySelector('.base_tasks_list');

            // Add a click event listener to the container
            tasks_container.addEventListener('click', function(event) {
                // Check if the clicked element is a button
                if (event.target.tagName === 'BUTTON' |event.target.tagName === 'I' ){
                     
                        //alert("task to be competed");
                        var complete_button = event.target;
                        var top_div = complete_button.closest('.task')
                        var taskId = top_div.getAttribute('task-id');
                        //console.log(taskId);
                        taskComplete(taskId) ;
                   
                }
            });
         

              var images_container = document.querySelector('.base_images_list');

            // Add a click event listener to the container
            images_container.addEventListener('click', function(event) {
                // Check if the clicked element is a button
                if (event.target.tagName === 'BUTTON' |event.target.tagName === 'I' ){
                     const buttonName  = event.target.name;
                       if(buttonName==='add_tag'){
                        console.log("add tag...");
                        document.querySelector(".base_image_tag").showModal();
                       } else if(buttonName ==="add_comment"){
                        console.log("add comment...");
                        document.querySelector(".base_image_comment").showModal();
                       } else if(buttonName==="view_image"){
                        var dialog =  document.querySelector(".base_image_full_view")
                        dialog.showModal();
                        console.log("view image...");
                        if(dialog.open){
                            console.log("dialog je otvoreny");
                            //get imageid
                            var imageId = event.target.closest(".base_image").getAttribute("image-id");
                            //get image
                           getImage(imageId, function(image) {
                                console.log(image);
                                baseId = sessionStorage.getItem("base_id");
                                document.querySelector(".base_image_full_view img").src="gallery/base_"+baseId+"/"+image;
                              // tu môžete ďalej pracovať s hodnotou obrázka
                              });
                        }
                       } else if (buttonName ==="delete_image"){
                        console.log("delete image...");
                        //deleteImage()
                       }
                  }
            });
         

            function removeIdea(ideaId) {
                  var xhttp = new XMLHttpRequest();
                  xhttp.onreadystatechange = function() {
                      if (this.readyState == 4 && this.status == 200) {
                          alert("Idea deleted");
                      }
                  };

                  xhttp.open("POST", "base_idea_remove.php", true);
                  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                  var data = "&idea_id=" + encodeURIComponent(ideaId);
                  xhttp.send(data);
              }

           function taskComplete(taskId) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        alert("Task competed");
                    }
                };

                xhttp.open("POST", "base_task_complete.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                var data = "&task_id=" + encodeURIComponent(taskId);
                xhttp.send(data);

            }

            
            function removeNote(noteId) {
             var xhttp = new XMLHttpRequest();
             xhttp.onreadystatechange = function() {
                 if (this.readyState == 4 && this.status == 200) {
                     alert("Node deleted");
                 }
             };

             xhttp.open("POST", "base_note_remove.php", true);
             xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
             var data = "&note_id=" + encodeURIComponent(noteId);
             xhttp.send(data);
         }

            function removeImage(){

            }

                const coords = document.getElementById("base_location");
                coords.addEventListener("keyup", function(event){
                    if(event.target.tagName==="INPUT"){
                        console.log(event.target.value);
                        ChangeCoord(event.target.name,event.target.value);
                    }
                })


                const base_info = document.getElementById("basic_base_info");
                base_info.addEventListener("keyup",function(event){
                    if(event.target.tagName==="INPUT"){
                        UpdateBaseName(event.target.value);
                     }   

                    if (event.target.tagName==="TEXTAREA"){
                        UpdateBaseDescription(event.target.value);
                    }    
                  
                        
                })



            function ChangeCoord(location, coord){
                   var xhttp = new XMLHttpRequest();
             xhttp.onreadystatechange = function() {
                 if (this.readyState == 4 && this.status == 200) {
                    console.log("coordinate has been changed")
                 }
             };

             const base_id = sessionStorage.getItem("base_id");
             xhttp.open("POST", "vanilla_base_change_coordinate.php", true);
             xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
             var data = "&location=" + encodeURIComponent(location)+"&coordinate="+coord+
             "&base_id="+base_id;
             xhttp.send(data);
            }


              function UpdateBaseName(base_name){
                   var xhttp = new XMLHttpRequest();
             xhttp.onreadystatechange = function() {
                 if (this.readyState == 4 && this.status == 200) {
                    console.log("base_name has been changed")
                 }
             };

             const base_id = sessionStorage.getItem("base_id");
             xhttp.open("POST", "vanilla_base_update_name.php", true);
             xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
             var data = "&base_name=" + encodeURIComponent(base_name)+"&base_id="+base_id;
             xhttp.send(data);
            }


             function UpdateBaseDescription(base_description){
                   var xhttp = new XMLHttpRequest();
             xhttp.onreadystatechange = function() {
                 if (this.readyState == 4 && this.status == 200) {
                    
                 }
             };

             const base_id = sessionStorage.getItem("base_id");
             xhttp.open("POST", "vanilla_base_update_description.php", true);
             xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
             var data = "&base_description=" + encodeURIComponent(base_description)+"&base_id="+base_id;
             xhttp.send(data);
            }

            function getImage(imageId, callback){
                console.log(imageId);
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var image = this.responseText;
                        callback(image); // volanie callback funkcie s odpoveďou
                    }
                };
                xhttp.open("GET", "vanila_base_image.php?image_id="+imageId,true);
                xhttp.send();
            }


            function DeleteImage(imageId){
             
             var xhttp = new XMLHttpRequest();
             xhttp.onreadystatechange = function() {
                 if (this.readyState == 4 && this.status == 200) {
                       const images_container = document.querySelector(".base_images_list") 
                       images_container.querySelector('[image-id="'+imageId+'"]').remove(); 
                       alert("Image has been remove")        
                 }
             };

             baseId = sessionStorage.getItem("base_id");
             xhttp.open("POST", "vanilla_base_remove_image.php", true);
             xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
             var data = "&bimage_id="+imageId+"^base_id="+baseId;
             xhttp.send(data);
            
            }
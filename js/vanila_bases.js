     function add_new_note() {
        var element = document.getElementById("new_note_wrap");
        element.style.display="flex";
       }

       function hide_new_note(){
        var element = document.getElementById("new_note_wrap");
        element.style.display="none";
       }

       function update_info(base_id){

        var obj_id = "base-"+base_id;
        var element = document.getElementById(obj_id);
        var content = element.innerText;
        var url= "update_base_descr.php?base_id="+encodeURIComponent(base_id)+"&note_text="+encodeURIComponent(content);
        //var url= "update_base_descr.php?base_id="+encodeURIComponent(base_id);
        var xhttp = new XMLHttpRequest();
                xhttp.open("POST", url, true);
                xhttp.send();

        //ajax update content
       }


       function add_new_task(){
        var element = document.getElementById("new_note_wrap");
        element.style.display="flex";
       }


       function hide_task(){
        var element = document.getElementById("new_note_wrap");
        element.style.display="flex";
       }

        function delete_base(base_id){
            
				const xhttp = new XMLHttpRequest();
					xhttp.onload = function() {
		
                        reload_bases();
                    }    
                console.log(base_id);    
				xhttp.open("POST", "vanilla_delete_base.php",true);
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                var data = "&base_id="+encodeURIComponent(base_id);
                xhttp.send(data);
        }

        function reload_bases(){
                   const xhttp = new XMLHttpRequest();
					xhttp.onload = function() {
                        var bases = document.getElementById("vanilla_bases");
                        bases.innerHTML = this.responseText;
                    }
                    xhttp.open("GET", "vanilla_reload_bases.php", true);
                    xhttp.send();
          }

            function base_details(base_id){
                //alert(base_id);
                var url = "vanilla_base.php?base_id="+base_id;
                
                window.location.href = url;
            }

            function live_search(string){
                const xhttp = new XMLHttpRequest();
                    xhttp.onload = function() {
                        var bases = document.getElementById("vanilla_bases");
                        bases.innerHTML = this.responseText;
                    }
                    xhttp.open("GET", "base_search.php?search_string="+string, true);
                    xhttp.send();
            }

            function clear_input(){
                document.getElementById("search").value = "";
                reload_bases();
            }
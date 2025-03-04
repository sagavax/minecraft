 function search_log(text) {
      
       var xhttp = new XMLHttpRequest();
       //var search_text=document.getElementById("search_string").value;
       xhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               document.getElementById("applog_list").innerHTML =
                   this.responseText;
           }
       };
       xhttp.open("GET", "app_logs_search.php?search=" +text, true);
       xhttp.send();

   }
const ul = document.querySelector(".picture_tags ul"),
input = document.querySelector(".picture_tags ul input");
tagNumb = document.querySelector(".details span");
let maxTags = 10;

tags = [];
loadVideoTags()
//console.log(tags);
//countTags();
//createTag();
/*function countTags(){
    input.focus();
    tagNumb.innerText = maxTags - tags.length;
}*/
function createTag(){
    ul.querySelectorAll("li").forEach(li => li.remove());
    tags.slice().reverse().forEach(tag =>{
        let liTag = `<li>${tag} <i class="fa fa-times" onclick="remove(this, '${tag}')"></i></li>`;
        ul.insertAdjacentHTML("afterbegin", liTag);
    });
    //countTags();
}

function remove(element, tag){
    let index  = tags.indexOf(tag);
    tags = [...tags.slice(0, index), ...tags.slice(index + 1)];
    element.parentElement.remove();
    //countTags();
}

function addTag(e){
    if(e.key == "Enter"){
        let tag = e.target.value.replace(/\s+/g, ' ');
        if(tag.length > 1 && !tags.includes(tag)){
            if(tags.length < 10){
                tag.split(',').forEach(tag => {
                    tags.push(tag);
                    createTag();
                    createImageTag(tag)
                });
            }
        }
        e.target.value = "";
    }
}
input.addEventListener("keyup", addTag);
/*const removeBtn = document.querySelector(".details button");
removeBtn.addEventListener("click", () =>{
    tags.length = 0;
    ul.querySelectorAll("li").forEach(li => li.remove());
    countTags();
});*/


function loadVideoTags(){

	 var xhttp = new XMLHttpRequest();
       //var search_text=document.getElementById("search_string").value;
       xhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
              //var tags = [];
              tags = xhttp.responseText;
              
              ul.querySelectorAll("li").forEach(li => li.remove());

              var tags = JSON.parse(xhttp.responseText);

              for (var key in tags) {
				  if (tags.hasOwnProperty(key)) {
				    // Access the value using the key
				    var value = tags[key];
				     
        		let liTag = `<li>${value} <i class="fa fa-times" onclick="remove(this, '${value}')" data-id='${key}'></i></li>`;
        		ul.insertAdjacentHTML("afterbegin", liTag);
				    //console.log("Key: " + key + ", Value: " + value);
				  
				}
	             
    		};

           }
       };

       video_id = sessionStorage.getItem("video_id");

       xhttp.open("GET", "picture_tags.php?image_id=" + video_id, true);
       xhttp.send();

}

function createImageTag(tag_name){
	const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {

          }
        
        image_id = sessionStorage.getItem("image_id");

        xhttp.open("POST", "picture_create_tag.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "image_id="+encodeURIComponent(image_id)+"&tag_name="+encodeURIComponent(tag_name);                
        xhttp.send(data);
}

function remove_video_tag(){

}
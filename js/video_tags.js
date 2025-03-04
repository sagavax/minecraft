const ul = document.querySelector(".video_tags ul"),
input = document.querySelector(".video_tags ul input");
tagNumb = document.querySelector(".details span");
let maxTags = 20;

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
    RemoveVideoTag(tag);
    element.parentElement.remove();
    //countTags();
    //const tagId = element.getAttribute("data-id");
    
}

function addTag(e){
    if(e.key == "Enter"){
        let tag = e.target.value.replace(/\s+/g, ' ');
        if(tag.length > 1 && !tags.includes(tag)){
            if(tags.length < 10){
                tag.split(',').forEach(tag => {
                    tags.push(tag);
                    createTag();
                    createVideoTag(tag)
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


function loadVideoTags() {
  const videoId = sessionStorage.getItem("videoId");
  const url = `video_tags.php?video_id=${videoId}`;

  fetch(url)
    .then(response => response.json())
    .then(tags => {
      const ul = document.querySelector("ul");
      ul.innerHTML = ""; // Clear existing list items

      for (const tag of tags) {
        const liTag = `
          <li>
            ${tag}
            <i class="fa fa-times" onclick="remove(this, '${tag}')"></i>
          </li>
        `;
        ul.insertAdjacentHTML("afterbegin", liTag);
      }
    })
    .catch(error => console.error(error));
}


function createVideoTag(tag_name){
	const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {

          }
        
        video_id = sessionStorage.getItem("video_id");

        xhttp.open("POST", "video_create_tag.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "video_id="+encodeURIComponent(video_id)+"&tag_name="+encodeURIComponent(tag_name);                
        xhttp.send(data);
}

function RemoveVideoTag(tag){
    const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {

          }
        
        video_id = sessionStorage.getItem("video_id");

        xhttp.open("POST", "video_remove_tag.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "video_id="+encodeURIComponent(video_id)+"&tag="+encodeURIComponent(tag);                
        xhttp.send(data);
}

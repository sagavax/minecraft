const tags_list = document.querySelector("#tags_list");
const new_tag_form = document.querySelector("#new_tag form");

new_tag_form.addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission
    if(document.querySelector("#new_tag form input")===""){
        alert("Tag name cannot be empty!");
        return;
    }
});


tags_list.addEventListener("click", function(event) {
    if (event.target.tagName === "I") {
        //const tagName = event.target.closest(".tag_name").innerText;
        const tagId = event.target.closest(".tag").getAttribute("data-id");
        console.log(tagId, tagName);
        document.querySelector("#tags_list").removeChild(document.querySelector(`.tag[data-id='${tagId}']`));
        //removeTag(tagId, tagName);
    }
    
});

tags_list.addEventListener("click", function(event) {
    // Hľadáme najbližší rodičovský element s triedou "tag_name"
    let tagElement = event.target.closest(".tag_name");
    
    if (tagElement) {
        //let tagName = tagElement.innerText; // Získaj text zo správneho elementu
        //alert(tagName);
        tagElement.setAttribute("contenteditable", "true");
    }
});


function removeTag(tagId) {
    var xhttp = new XMLHttpRequest();
    var search_text = document.getElementById("search_string").value;
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(`.tag[data-id='${tagId}']`).removeChild(document.querySelector("tags_list"));
            //document.getElementById("notes_list").innerHTML = this.responseText;
        }
    };
    data = "tag_id="+tagId;
    xhttp.open("POST", "tags_remove.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);  
}


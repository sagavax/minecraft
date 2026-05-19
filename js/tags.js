const tags_list = document.querySelector("#tags_list");
const new_tag_form = document.querySelector("#new_tag form");
const letter_list = document.querySelector("#letter_list");
const new_tag = document.querySelector("#new_tag");
const new_tag_form_input = document.querySelector("#new_tag form input");


new_tag_form_input.addEventListener("input", function() {
    const search_text = new_tag_form_input.value;
    searchTags(search_text);
});


letter_list.addEventListener("click", function(event) {
     if(event.target.tagName ==="BUTTON") {
        if(event.target.name === "reload"){
            reloadTags();
            return;
        }
        if(event.target.name === "dupes"){
            findDuplicates();
            return;
        }

        if(/^[A-Z]$/i.test(event.target.innerText.trim())){
            const letter = event.target.innerText.trim();
            console.log(letter);
            SortTagsByLetter(letter);
            console.log("Sort by letter:", letter);
        }
     }
});




new_tag_form.addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission

    // Skontroluj hodnotu inputu, nie samotný element
    if (document.querySelector("#new_tag form input").value === "") {
        alert("Tag name cannot be empty!");
        return;
    } else {
        const tagName = document.querySelector("#new_tag form input").value;
        CreateTagInTagSphere(tagName);
        alert("Tag added successfully!");
    }
    
    // Ak je všetko v poriadku, pokračuj s formulárom
    // Napríklad tu môžeš pridať ďalší kód na odoslanie formuláru alebo prácu s dátami
});



tags_list.addEventListener("click", function(event) {
    if (event.target.tagName === "I") {
        //const tagName = event.target.closest(".tag_name").innerText;
        const tagId = event.target.closest(".tag").getAttribute("data-tag-id");
        const tagName = event.target.closest(".tag").innerText;
        console.log(tagId, tagName);
        document.querySelector("#tags_list").removeChild(document.querySelector(`.tag[data-tag-id='${tagId}']`));
        removeTag(tagId, tagName);
    }
    
});

tags_list.addEventListener("click", function(event) {
    // Hľadáme najbližší rodičovský element s triedou "tag_name"
    let tagElement = event.target.closest(".tag_name");
    const tagId = event.target.closest(".tag").getAttribute("data-id");
    if (tagElement) {
        tagElement.setAttribute("contenteditable", "true");
        //on blur save tag name
        tagElement.addEventListener("blur", function() {
            tagElement.setAttribute("contenteditable", "false");
            const tagName = tagElement.innerText;
            console.log(tagName);
            saveNewTagName(tagId, tagName);
        })
    }
});


function searchTags(search_text) {
    var xhttp = new XMLHttpRequest();
       xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector("#tags_list").innerHTML=this.responseText;
            //document.getElementById("notes_list").innerHTML = this.responseText;
        }
    };
    
    xhttp.open("GET", "tags_search.php?search_text=" + encodeURIComponent(search_text), true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();  
}


function removeTag(tagId, tagName) {
    console.log("Removing tag with ID:", tagId, "and Name:", tagName);
    var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert("Tag removed successfully!");
            //document.querySelector(`.tag[data-id='${tagId}']`).removeChild(document.querySelector("tags_list"));
            //document.getElementById("notes_list").innerHTML = this.responseText;
        }
    };
    const data = "tag_id="+tagId+"&tag_name="+tagName;
    xhttp.open("POST", "tags_remove.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);  
}

function SortTagsByLetter(letter){
    var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector("#tags_list").innerHTML=this.responseText;
            //document.getElementById("notes_list").innerHTML = this.responseText;
        }
    };
    
    xhttp.open("GET", "tags_sort_by_char.php?letter=" + encodeURIComponent(letter), true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();  
}

function findDuplicates(){
    var xhttp = new XMLHttpRequest();
    var search_text = document.getElementById("search_string").value;
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector("#tags_list").innerHTML=this.responseText;
            //document.getElementById("notes_list").innerHTML = this.responseText;
        }
    };
    xhttp.open("get", "tags_duplicates.php", true);
    xhttp.send();
}

function saveNewTagName(tagId, tagName){
    var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector("#tags_list").innerHTML=this.responseText;
            //document.getElementById("notes_list").innerHTML = this.responseText;
        }
    };
    const data = "tag_id="+tagId+"&tag_name="+tagName;
    xhttp.open("POST", "tags_change_tag_name.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);  
}

function CreateTagInTagSphere(tagName){
    console.log(tagName);
    var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //document.querySelector("#tags_list").innerHTML=this.responseText;
            //document.getElementById("notes_list").innerHTML = this.responseText;
        }
    };
    const data = "tag_name="+tagName+"&application_name=minecraft";
    xhttp.open("POST", "tags_add_new_tag.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);  
}


function reloadTags(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector("#tags_list").innerHTML=this.responseText;
            console.log("Tags reloaded");
        }
    };
    xhttp.open("get", "tags_reload.php", true);
    xhttp.send();
}
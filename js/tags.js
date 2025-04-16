const tags_list = document.querySelector("#tags_list");
const new_tag_form = document.querySelector("#new_tag form");
const letter_list = document.querySelector("#letter_list");




letter_list.addEventListener("click", function(event) {
     if(event.target.tagName ==="BUTTON") {
        const letter = event.target.innerText;
        //SortTagsByLetter(letter);
        console.log("Sort by letter:", letter);
    }
});




new_tag_form.addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission

    // Skontroluj hodnotu inputu, nie samotný element
    if (document.querySelector("#new_tag form input").value === "") {
        alert("Tag name cannot be empty!");
        return;
    }
    
    // Ak je všetko v poriadku, pokračuj s formulárom
    // Napríklad tu môžeš pridať ďalší kód na odoslanie formuláru alebo prácu s dátami
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
    const tagId = event.target.closest(".tag").getAttribute("data-id");
    
    if (tagElement) {
        //let tagName = tagElement.innerText; // Získaj text zo správneho elementu
        //alert(tagName);
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


function removeTag(tagId) {
    var xhttp = new XMLHttpRequest();
    var search_text = document.getElementById("search_string").value;
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(`.tag[data-id='${tagId}']`).removeChild(document.querySelector("tags_list"));
            //document.getElementById("notes_list").innerHTML = this.responseText;
        }
    };
    const data = "tag_id="+tagId;
    xhttp.open("POST", "tags_remove.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);  
}

function SortTagsByLetter(letter){
    var xhttp = new XMLHttpRequest();
    var search_text = document.getElementById("search_string").value;
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector("#tags_list").innerHTML=this.responseText;
            //document.getElementById("notes_list").innerHTML = this.responseText;
        }
    };
    const data = "letter="+letter;
    xhttp.open("POST", "tags_sort_by_char.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);  
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
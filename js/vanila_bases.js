const vanilla_bases = document.querySelector("#vanilla_bases");
const modal_new_base = document.getElementById('modal_new_base'); //modal_new_base
const search_wrap_input = document.querySelector(".search_wrap input");
const tab_view = document.querySelector(".tab_view");



tab_view.addEventListener("click", (e) => {
    if (event.target.tagName == "BUTTON") {
        if (e.target.name==="reload_bases") {
        console.log("reload bases");
        reloadBases();
    } else if ( e.target.name==="show_list") {
        console.log("list");
        document.querySelector("#vanilla_bases").style.flexDirection = "column";
        showBasesList();
    } else if (e.target.name==="show_grid") {
        console.log("grid");
        document.querySelector("#vanilla_bases").style.flexDirection = "row";
        document.querySelector("#vanilla_bases").style.flexWrap = "wrap";
        document.querySelector("#vanilla_bases").style.gap = "10px";
        showBasesGrid();
    }
    }
});



search_wrap_input.addEventListener("keyup", () => {
    searchBase(search_wrap_input.value);
});


modal_new_base.addEventListener("click", function(e) {
    if (e.target.tagName === "BUTTON" && e.target.name==="add_base") {
        const base_name = document.querySelector('input[name="base_name"]').value;
        const base_description = document.querySelector('textarea[name="base_description"]').value;
        const over_x = document.querySelector('input[name="over_x"]').value;
        const over_y = document.querySelector('input[name="over_y"]').value;
        const over_z = document.querySelector('input[name="over_z"]').value;
        if (base_name === "" || base_description === "" || over_x === "" || over_y === "" || over_z === "") {
            alert("Please fill in all the fields.");
            return;
        } 
           addNewBase(base_name, base_description, over_x, over_y, over_z);
     } else if (e.target.tagName === "BUTTON" && e.target.name==="return_to_vanilla") {
         document.querySelector('#modal_new_base').close();
     }
});


vanilla_bases.addEventListener("click", function(e) {
    if (e.target.tagName === "DIV" && e.target.classList.contains("base_name")) {
        console.log(e.target);

        const baseId = e.target.closest(".vanilla-base").getAttribute("base-id");
        console.log(baseId);

        e.target.contentEditable = true;
        e.target.focus();

        // Define blur handler on the editable element itself
        e.target.onblur = function() {
            e.target.contentEditable = false;
            updateBaseName(baseId, e.target.innerText);
        };
    } else if (e.target.tagName === "DIV" && e.target.classList.contains("base_description")) {
       // console.log(e.target);

        const baseId = e.target.closest(".vanilla-base").getAttribute("base-id");
        //console.log(baseId);

        e.target.contentEditable = true;
        e.target.focus();

        const originalText = e.target.innerText;

        e.target.onblur = function () {
            e.target.contentEditable = false;

        const newText = e.target.innerText.trim();

        if (newText.length > 0 && newText !== originalText) {
            updateBaseDescription(baseId, newText);
        } else {
            e.target.innerText = originalText; // revert if empty or unchanged
        }
     };
   } 
});


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

function deleteBase(base_id){
    
        const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {

                reloadBases();
            }    
        console.log(base_id);    
        xhttp.open("POST", "vanilla_delete_base.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "&base_id="+encodeURIComponent(base_id);
        xhttp.send(data);
}

function reloadBases(){
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                var bases = document.getElementById("vanilla_bases");
                bases.innerHTML = this.responseText;
            }
            xhttp.open("GET", "vanilla_reload_bases.php", true);
            xhttp.send();
    }

function baseDetails(base_id){
    //alert(base_id);
    var url = "vanilla_base.php?base_id="+base_id;
    
    window.location.href = url;
}

function SearchBase(string){
    const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            var bases = document.getElementById("vanilla_bases");
            bases.innerHTML = this.responseText;
        }
        xhttp.open("GET", "base_search.php?search_string="+string, true);
        xhttp.send();
}

function clearInput(){
    document.getElementById("search").value = "";
    reloadBases();
}


function updateBaseName(base_id, base_new_name) {
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            alert("Update successful");
        }    
    console.log(base_id);    
    xhttp.open("POST", "vanilla_base_update_name.php",true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var data = "&base_id="+encodeURIComponent(base_id)+"&base_name="+encodeURIComponent(base_new_name);
    xhttp.send(data);
}

function updateBaseDescription(base_id, base_new_description) {
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            alert("Update successful");
        }    
    console.log(base_id);    
    xhttp.open("POST", "vanilla_base_update_description.php",true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var data = "&base_id="+encodeURIComponent(base_id)+"&base_description="+encodeURIComponent(base_new_description);
    xhttp.send(data);
}


function addNewBase(base_name, base_description, over_x, over_y, over_z) {
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            alert("Update successful");
        }    
    console.log(base_name);    
    xhttp.open("POST", "vanilla_base_add.php",true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var data = "&base_name="+encodeURIComponent(base_name)+"&base_description="+encodeURIComponent(base_description)+"&over_x="+over_x+"&over_y="+over_y+"&over_z="+over_z;
    xhttp.send(data);
}


function showBasesList(){
    const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            var bases = document.getElementById("vanilla_bases");
            bases.innerHTML = this.responseText;
        }
        xhttp.open("GET", "vanilla_bases_list.php", true);
        xhttp.send();
}

function showBasesGrid(){
    const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            var bases = document.getElementById("vanilla_bases");
            bases.innerHTML = this.responseText;
        }
        xhttp.open("GET", "vanilla_bases_grid.php", true);
        xhttp.send();
}
localStorage.setItem("modpack_id", "");

const tab_view = document.querySelector(".tab_view");

const search_wrap_input = document.querySelector(".search_wrap input");
const new_modpack = document.querySelector("#new_modpack .action");

new_modpack.addEventListener("click", function (event){
  if(event.target.tagName==="BUTTON"){
    if(event.target.name ==="add_new_modpack"){
      create_modpack();
      new_modpack.close();
      } else if (event.target.name === "move_back"){
      console.log("Move back ...");
    }
  }
})



search_wrap_input.addEventListener("keyup", () => {
  search_modpack(search_wrap_input.value);
});

tab_view.addEventListener("click", (event) => {
  if (event.target.tagName == "BUTTON") {

    document.querySelectorAll(".tab_view button").forEach(button => { button.style.backgroundColor = "#aadd77"; });
    
    event.target.style.backgroundColor = "#52a535";
    show_modpacks(event.target.name);
  }
});

document.querySelectorAll(".is_active").forEach(a => {
  a.addEventListener("click", () => {
    var modpack_id = a.getAttribute("data-id");

    if (a.classList.contains("active")) {
      a.innerHTML = "<i class='fa fa-times'></i>";
      a.classList.remove("active");
      a.classList.add("inactive");
      console.log(modpack_id);
      modpack_status("inactive", modpack_id);
    } else if (a.classList.contains("inactive")) {
      a.innerHTML = "<i class='fa fa-check'></i>";
      a.classList.remove("inactive");
      a.classList.add("active");
      modpack_status("active", modpack_id);
    }
  });
});

function modpack_status(status, modpack_id) {
  var modpack_status = status;
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.onreadystatechange = function() {
    if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
      alert("Status zmenený!");
    }
  };
  xmlHttp.open("GET", "modpack_status.php?status=" + modpack_status + "&modpack_id=" + modpack_id);
  xmlHttp.send();
}

function search_modpack(modpack) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.querySelector(".modpack_list").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "modpacks_search.php?search=" + modpack, true);
  xhttp.send();
}

function create_modpack() {
  const modpack_name = document.querySelector('input[name="modpack_name"]').value;
  const modpack_version = document.querySelector('input[name="modpack_version"]').value;
  const modpack_author = document.querySelector('input[name="modpack_author"]').value;
  const modpack_description = document.querySelector('textarea[name="modpack_description"]').value;
  const modpack_url = document.querySelector('input[name="modpack_url"]').value;
  const modpack_image = document.querySelector('input[name="modpack_image"]').value;

  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("new_modpack").close();
    alert(modpack_name + " modpack has been added");
  };

  xhttp.open("POST", "modpack_create.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  const data = `modpack_name=${modpack_name}&modpack_version=${modpack_version}&modpack_author=${modpack_author}&modpack_description=${modpack_description}&modpack_url=${modpack_url}&modpack_image=${modpack_image}`;
  xhttp.send(data);
}

function show_modpacks(status) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.querySelector(".modpack_list").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "modpacks_filter.php?filter=" + status, true);
  xhttp.send();
}
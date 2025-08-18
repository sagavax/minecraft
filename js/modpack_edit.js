const modpack = document.querySelector(".modpack");
const modpack_description = document.querySelector(".modpack_description");
const modpack_status = document.querySelector("select[name='modpack_status']");
const modpack_image = document.querySelector("input[name='modpack_image']");


modpack_image.addEventListener("input", (e) => {
  const modpack_image = document.querySelector("input[name='modpack_image']").value; 
  console.log(modpack_image);
  modpackChangeImage(modpack_image);
  document.querySelector(".modpack_pic_wrap img").src = modpack_image;
  ShowMessage("Modpack image has been updated ...");
});

modpack_status.addEventListener("change", (e) => {
  const modpack_status = document.querySelector("select[name='modpack_status']").value; 
  modpackChangeStatus(modpack_status);
  ShowMessage("Modpack status has been updated ...");
});


modpack.addEventListener("click", (e) => {
  const el = e.target.closest(".modpack_description");
  if (!el) return;
  el.dataset.prev = el.textContent;
  el.contentEditable = "true";
  el.focus();
});

modpack.addEventListener("focusout", (e) => {
  const el = e.target.closest(".modpack_description");
  if (!el) return;
  el.contentEditable = "false";

  const prev = el.dataset.prev || "";
  const next = el.textContent;
  if (next !== prev) {
    SaveModPackDescription(next);
    ShowMessage("Modpack description has been updated ...");
  }
});


function SaveModPackDescription() {
    const modpack_description = document.querySelector(".modpack_description").innerText;
    
    const url = new URL(window.location.href);
    // získať query parameter
    const modpackId = url.searchParams.get("modpack_id");

    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "modpack_description_update.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var data = "modpack_id=" + encodeURIComponent(modpackId) + "&modpack_description=" + encodeURIComponent(modpack_description);
    xhttp.send(data);
}

function modpackChangeStatus(status){
  const url = new URL(window.location.href);
  // získať query parameter
  const modpackId = url.searchParams.get("modpack_id");
  const xhttp = new XMLHttpRequest();
  xhttp.open("POST", "modpack_status_update.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  var data = "modpack_id=" + encodeURIComponent(modpackId) + "&modpack_status=" + encodeURIComponent(status);
  xhttp.send(data);
}


function modpackChangeImage(modpack_image) {
  const url = new URL(window.location.href);
  // získať query parameter
  const modpackId = url.searchParams.get("modpack_id");
  const xhttp = new XMLHttpRequest();
  xhttp.open("POST", "modpack_image_update.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  var data = "modpack_id=" + encodeURIComponent(modpackId) + "&modpack_image=" + encodeURIComponent(modpack_image);
  xhttp.send(data);
}
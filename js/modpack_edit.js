const modpack = document.querySelector(".modpack");
const modpack_description = document.querySelector(".modpack_description");

/* modpack.addEventListener("click", function(event) {
    if (event.target.classList.contains("modpack_description")) {
        document.querySelector(".modpack_description").setAttribute("contenteditable", "true");
    }
});

modpack_description.addEventListener("blur", function(event) {
    if (event.target.classList.contains("modpack_description")) {
        document.querySelector(".modpack_description").setAttribute("contenteditable", "false");
        SaveModPackDescription();
        ShowMessage("Modpack description has been updated ...");
    }
});
 */

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
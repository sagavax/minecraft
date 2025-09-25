const new_influencer = document.querySelector("#new_influencer");
const influencer_list = document.querySelector(".influencer_list");
const modal_change_modpack = document.querySelector(".modal_change_modpack");
const new_influencer_input_influencer_name = document.querySelector("#new_influencer input[name='influencer_name']");
const new_influencer_input_influencer_link = document.querySelector("#new_influencer input[name='influencer_url']");



document.querySelector(".influencer_modpacks").style.background = "transparent";


// get influencer name from link
new_influencer_input_influencer_link.addEventListener("input", () => {
    new_influencer_input_influencer_name.value = (new_influencer_input_influencer_link.value).split("@")[1];
})


influencer_list.addEventListener("click", (event) => {
    if(event.target.tagName ==="IMG"){
        console.log("clicked");
        const influencerId = event.target.closest(".influencer").getAttribute("influencer-id");
        sessionStorage.setItem("influencer_id", influencerId);
        LoadInflencersModpacks(influencerId);
    } if (event.target.tagName === "BUTTON") {
        if(event.target.name === "add_modpack"){
            modal_change_modpack.style.top = "40%";
            modal_change_modpack.showModal();
        }
    }
})


new_influencer.addEventListener("submit", (event) => {
    const submitter = event.submitter;
    if(submitter && submitter.name === "add_new_influencer"){
        if(
            new_influencer_input_influencer_name.value === "" ||
            new_influencer_input_influencer_link.value === ""
        ) {
            event.preventDefault();
            ShowMessage("Please enter a name or a link for the influencer.");
            return;
        } 
    }
});

// add / change modpack
modal_change_modpack.addEventListener("click", (event) => {
    if(event.target.tagName === "BUTTON" && event.target.name === "close_modal"){
        modal_change_modpack.close();
    } else if (event.target.tagName === "BUTTON" && event.target.name === "add_modpack"){
                const modpackId = event.target.getAttribute("modpack-id");
        const modpackName = event.target.innerText;
        const influencerId = sessionStorage.getItem("influencer_id");
        InfluencerChangeModpack(influencerId, modpackId, modpackName);
        modal_change_modpack.close();
        ShowMessage("Modpack has been changed successfully!");
    }
})

/**
 * Loads all modpacks that are associated with the given influencer id.
 * The resulting html is inserted into the .influencer_modpacks div.
 * @param {number} influencerId
 */
function LoadInflencersModpacks(influencerId){
  const xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          document.querySelector(".influencer_modpacks").innerHTML = this.responseText;
          document.querySelector(".influencer_modpacks").style.background = "#fff";
      }
  };
  xhttp.open("POST", "influencer_modpacks.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  var params="influencer-id="+influencerId;
  xhttp.send(params);
}


/**
 * Adds the given modpack to the given influencer.
 * @param {number} influencerId
 * @param {number} modpackId
 * @param {string} modpackName
 */
function InfluencerChangeModpack(influencerId, modpackId, modpackName){ {
    //check if modpack assigned to influencer already exists
    //CheckExistingModpackForInfluencer(modpackId, influencerId);
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(".influencer_modpacks").innerHTML = "";
            LoadInflencersModpacks(influencerId);
            
        }
    };
    xhttp.open("POST", "influencer_change_modpack.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "influencer_id=" + influencerId + "&modpack_id=" + modpackId + "&modpack_name=" + modpackName;
    xhttp.send(params);
    }
}

function getInfluencerLists(influncer){
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(".influencer_modpacks").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "influencer_lists.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params="influencer-id="+influncer;
    xhttp.send(params);
}
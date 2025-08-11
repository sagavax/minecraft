const new_influencer = document.querySelector("#new_influencer");
const influencer_list = document.querySelector(".influencer_list");
const new_influencer_input_influencer_name = document.querySelector("#new_influencer input[name='influencer_name']");
const new_influencer_input_influencer_link = document.querySelector("#new_influencer input[name='influencer_url']");

new_influencer_input_influencer_link.addEventListener("input", () => {

    new_influencer_input_influencer_name.value = (new_influencer_input_influencer_link.value).split("@")[1];
})


influencer_list.addEventListener("click", (event) => {
    if(event.target.tagname ==="DIV" && event.target.classlist.conintains("influencer")){
        const influencerId = event.target.closest(".influencer").getAttribute("influencer-id");
        LoadInflencersModpacks(influencerId);
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

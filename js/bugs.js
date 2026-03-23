const bug_list = document.querySelector('.bug_list');
const modal_show_status = document.querySelector('.modal_show_status');
const modal_show_priority = document.querySelector('.modal_show_priority');
const new_bug_form = document.querySelector('.new_bug form'); // Assuming this is the form element for adding a new bug
const bug_footer = document.querySelector('.bug_footer');

//markdown editor



/* bug_footer.addEventListener('click', function(event) {
    if(event.target.classList.contains('bug_status')) {
        const bugId = event.target.closest(".bug").getAttribute('bug-id');
        sessionStorage.setItem('bug_id', bugId);
        console.log(bugId);
        modal_show_status.showModal();
    } else if(event.target.classList.contains('bug_priority')) {
        const bugId = event.target.closest(".bug").getAttribute('bug-id');
        sessionStorage.setItem('bug_id', bugId);
        console.log(bugId);
        modal_show_priority.showModal();
    } else if (event.target.classList.contains('nr_of_comments')) {
        const bugId = event.target.closest(".bug").getAttribute('bug-id');
        sessionStorage.setItem('bug_id', bugId);
        console.log(bugId);
        localBugComments(bugId);
    } else if (event.target.tagName === 'BUTTON') {
        if(event.target.name === "delete_bug"){
            const bugId = event.target.closest(".bug").getAttribute('bug-id');
            sessionStorage.setItem('bug_id', bugId);
            console.log(bugId);
            removeBug(bugId);
        } else if(event.target.name === "mark_fixed"){
            const bugId = event.target.closest(".bug").getAttribute('bug-id');
            sessionStorage.setItem('bug_id', bugId);
            console.log(bugId);
            markBugAsFixed(bugId);
        } else if(event.target.name === "see_bug_details"){
            const bugId = event.target.closest(".bug").getAttribute('bug-id');
            sessionStorage.setItem('bug_id', bugId);
            console.log(bugId);
            window.location.href = `bug.php?bug_id=${bugId}`;
        }
    }
}); */


new_bug_form.addEventListener('submit', function(event) {
    event.preventDefault();

    const bugTitle = document.querySelector('input[name="bug_title"]').value;
    const bugDescription = document.querySelector('textarea[name="bug_text"]').value;
    let bugPriority = document.querySelector('select[name="bug_priority"]').value;
    let bugStatus = document.querySelector('select[name="bug_status"]').value;
    
    if (bugDescription === "") {
        alert("Please fill in all required fields.");
        return;
    }

    if (bugPriority === "0") bugPriority = "medium";
    if (bugStatus === "0") bugStatus = "new";

    //console.log(`New bug added: ${bugTitle} - ${bugDescription} - ${bugPriority} - ${bugStatus}`);
    SaveBug(bugTitle, bugDescription, bugPriority, bugStatus);
});

bug_list.addEventListener('click', function(event) {
    const targetClass = event.target.classList;

    if (event.target.tagName === 'DIV' && (targetClass.contains("bug_status") || targetClass.contains("bug_priority"))) {
        const bugId = event.target.closest(".bug").getAttribute('bug-id');
        sessionStorage.setItem('bug_id', bugId);
        console.log(bugId);

        const modal = targetClass.contains("bug_status") ? modal_show_status : modal_show_priority;
        
        if (!modal) return;

        const rect = event.target.getBoundingClientRect();
        
        // Posunutie o 10px doľava
        modal.style.left = `${rect.left + rect.width / 2 - modal.offsetWidth / 2 - 10}px`;
        modal.style.top = `${rect.top - modal.offsetHeight - 20}px`;

        modal.showModal();
    } 
    
    if (event.target.tagName === 'BUTTON') {
        const bugId = event.target.closest(".bug")?.getAttribute('bug-id');
        sessionStorage.setItem('bug_id',bugId);
        if (!bugId) return;
    
        switch (event.target.name) {
            case "see_bug_details":
                window.location.href = `bug.php?bug_id=${bugId}`;
                break;
            case "bug_remove":
                alert("bug_remove");
                break;
            case "to_fixed":
                alert("mark bug as fixed");
                break;
            case "to_reopen":
                alert("reopen bug");
                break;
        }
    }
});


modal_show_status.addEventListener('click', function(event) {
if (event.target.tagName === 'LI') {    
    const bugId = sessionStorage.getItem('bug_id');
    const bugStatus = event.target.innerText;
    console.log(`Bug ${bugId} status updated to ${bugStatus}`);
    if(document.querySelector(`.bug[bug-id='${bugId}'] .bug_status`).innerText === "fixed"){
        alert("Cannot change status of a fixed bug.");
        modal_show_status.close();
        return;
        
    } else {
    changeBugStatus(bugId, bugStatus);
    modal_show_status.close();
    }
}
});

modal_show_priority.addEventListener('click', function(event) {
    if (event.target.tagName === 'LI') {    
        const bugId = sessionStorage.getItem('bug_id');
        const bugPriority = event.target.innerText;
        console.log(`Bug ${bugId} status updated to ${bugPriority}`);
        if(document.querySelector(`.bug[bug-id='${bugId}'] .bug_status`).innerText === "fixed"){
            alert("Cannot change priority of a fixed bug.");
            modal_show_priority.close();
            return;
            
        } else {
        changeBugPriority(bugId, bugPriority);
        modal_show_priority.close();
        }
    }
});


function changeBugStatus(bugId, bugStatus) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(`.bug[bug-id='${bugId}'] .bug_status`).innerText = bugStatus;
           
        }
    };
    xhttp.open("POST", "bugs_change_status.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Send the request with the videoId and modpackId
    var params = "bug_id=" + encodeURIComponent(bugId) + "&bug_status=" + encodeURIComponent(bugStatus);
    xhttp.send(params);
}

function changeBugPriority(bugId, bugPriority) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(`.bug[bug-id='${bugId}'] .bug_priority`).innerText = bugPriority;
            document.querySelector(`.bug[bug-id='${bugId}'] .bug_priority`).classList.remove("low", "medium", "high", "critical");
            document.querySelector(`.bug[bug-id='${bugId}'] .bug_priority`).classList.add(bugPriority);
            //document.querySelector(`.bug[bug-id='${bugId}'] .bug_priority`).style.border = "1px solid #d1d1d1"; 
        }
    };
    xhttp.open("POST", "bugs_change_priority.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Send the request with the videoId and modpackId
    var params = "bug_id=" + encodeURIComponent(bugId) + "&bug_priority=" + encodeURIComponent(bugPriority);
    xhttp.send(params);
}


function addNewComment(bugId) {
    document.queryselector('.modal_add_comment').showModal();
}

function SaveBug(bugTitle, bugDescription, bugPriority, bugStatus) {
    //console.log(`Saving bug: ${bugTitle} - ${bugDescription} - ${bugPriority} - ${bugStatus}`);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText === "Bug created successfully") {
                alert("Bug added successfully!");
                console.log("Bug added successfully!");
            }
        }
    };
    xhttp.open("POST", "bugs_create.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "bug_title=" + encodeURIComponent(bugTitle) + "&bug_description=" + encodeURIComponent(bugDescription) + "&bug_priority=" + encodeURIComponent(bugPriority) + "&bug_status=" + encodeURIComponent(bugStatus);
    xhttp.send(params);
}



function markBugAsFixed(bugId) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(`.bug[bug-id='${bugId}'] .bug_status`).innerText = "Fixed";    
        }
    }
    xhttp.open("POST", "bugs_mark_as_fixed.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "bug_id=" + encodeURIComponent(bugId);
    xhttp.send(params);
}
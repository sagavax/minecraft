const events = ['click', 'keydown', 'scroll', 'input', 'keyup'];

for (let i = 0; i < events.length; i++) {
    document.body.addEventListener(events[i], handleAnyEvent);
}

setInterval(checkLastEvent, 300000);

function handleAnyEvent(event) {
    //console.log("Zachycena libovolná událost:", event.type);
    writeEvent(event.type);
    // Additional actions based on the event can be performed here
}

function checkLastEvent() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            if (this.status == 200) {
                var latestEventDate = this.responseText;
                console.log(latestEventDate);
                const currentTime = Date.now();
                var dateObject = new Date(latestEventDate);
                var latestEventDate = dateObject.getTime();
                const timeDifference = currentTime - latestEventDate; // latestEventDate is not defined, you need to define it
                const differenceInMinutes = timeDifference / (1000 * 60);
                if (differenceInMinutes >= 2) {
                    logout();
                }
            } else {
                // Handle errors here
                console.error("Error: " + xhttp.statusText);
            }
        }
    };
    xhttp.open("GET", "video_check_event.php", true);
    xhttp.send();
}

function writeEvent(event) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            if (this.status != 200) {
                // Handle errors here
                console.error("Error: " + xhttp.statusText);
            }
        }
    };
    xhttp.open("POST", "videos_capture_event.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var data = "event=" + encodeURIComponent(event);
    xhttp.send(data);
}

function logout() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            if (this.status == 200) {
                window.location.href = "index.php";
            } else {
                // Handle logout failure here
                alert("Logout failed. Please try again.");
            }
        }
    };
    xhttp.open("POST", "logout.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

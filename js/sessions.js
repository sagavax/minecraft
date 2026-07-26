// game_sessions.php - sessions list page
const sessions_list = document.querySelector(".sessions_list");
const new_session = document.querySelector("#new_session");
const sessions_view_toggle = document.querySelector(".tab_view_list_grid");

if (sessions_view_toggle) {
    sessions_view_toggle.addEventListener("click", function (event) {
        const button = event.target.closest("button");
        if (!button) return;

        sessions_display_as(button.name);
    });
}

if (new_session) {
    new_session.addEventListener("click", function (event) {
        const button = event.target.closest("button");
        if (!button) return;

        if (button.name === "add_new_session") {
            const modpackId = document.querySelector("select[name='session_modpack_id']").value.trim();
            const seed = document.querySelector("input[name='session_seed']").value.trim();

            if (modpackId === "") {
                alert("Please select a modpack.");
                return;
            }

            if (seed === "") {
                alert("Please enter a seed.");
                return;
            }

            createSession(modpackId, seed);
        } else if (button.name === "move_back") {
            new_session.close();
        }
    });
}

if (sessions_list) {
    sessions_list.addEventListener("click", function (event) {
        const button = event.target.closest("button");
        if (!button) return;

        const card = button.closest("[session-id]");
        if (!card) return;

        const sessionId = card.getAttribute("session-id");

        if (button.name === "view_session") {
            window.location.href = "game_session.php?session_id=" + sessionId;
        } else if (button.name === "delete_session") {
            if (confirm("Delete this game session?")) {
                card.remove();
                deleteSession(sessionId);
            }
        }
    });
}

function sessions_display_as(source) {
    const xhttp = new XMLHttpRequest();
    const url = source === "list" ? "game_sessions_display_as_list.php" : "game_sessions_display_as_cards.php";
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("sessions_list").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", url, true);
    xhttp.send();
}

function createSession(modpackId, seed) {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            new_session.close();
            window.location.reload();
        }
    };
    xhttp.open("POST", "session_create.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    const data = "modpack_id=" + encodeURIComponent(modpackId) + "&seed=" + encodeURIComponent(seed);
    xhttp.send(data);
}

function deleteSession(sessionId) {
    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "session_delete.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    const data = "session_id=" + encodeURIComponent(sessionId);
    xhttp.send(data);
}


// game_session.php - session detail page
const session_wrap = document.querySelector(".session");

if (session_wrap) {

    const session_id = session_wrap.getAttribute("session-id");

    const session_wall_tabs = document.querySelector(".session_wall_tabs");
    const basic_session_info = document.getElementById("basic_session_info");
    const notes_container = document.querySelector("#notes");
    const tasks_container = document.querySelector("#tasks");
    const bases_container = document.querySelector("#bases");

    showSessionTab("notes");
    document.getElementById("tasks").style.display = "none";
    document.getElementById("bases").style.display = "none";

    session_wall_tabs.addEventListener("click", function (event) {
        if (event.target.tagName === "BUTTON") {
            session_wall_tabs.querySelectorAll("button").forEach(button => {
                button.classList.remove("jade_button");
            });
            event.target.classList.add("jade_button");
            showSessionTab(event.target.getAttribute("data-tab").toLowerCase());
        }
    });

    function showSessionTab(tabName) {
        const tabs = ["notes", "tasks", "bases"];
        tabs.forEach(tab => {
            document.getElementById(tab).style.display = "none";
        });
        document.getElementById(tabName).style.display = "flex";
    }

    basic_session_info.addEventListener("change", function (event) {
        if (event.target.name === "session_modpack_id") {
            updateSessionModpack(session_id, event.target.value);
        }
    });

    basic_session_info.addEventListener("keyup", function (event) {
        if (event.target.name === "session_seed") {
            updateSessionSeed(session_id, event.target.value);
        }
    });

    notes_container.addEventListener("click", function (event) {
        const button = event.target.closest("button");
        if (!button) return;

        if (button.name === "new_session_note") {
            const noteHeader = document.getElementById("session_note_header").value;
            const noteText = document.getElementById("session_note_text").value;

            if (noteText === "") {
                alert("Please enter note text.");
                return;
            }

            saveSessionNote(session_id, noteHeader, noteText);
        } else if (button.name === "remove_note") {
            const note = button.closest(".session_note");
            const noteId = note.getAttribute("note-id");
            note.remove();
            removeSessionNote(noteId);
        }
    });

    tasks_container.addEventListener("click", function (event) {
        const button = event.target.closest("button");
        if (!button) return;

        if (button.name === "new_session_task") {
            const taskText = document.getElementById("session_task_text").value;
            const priorita = document.getElementById("session_task_priorita").value;

            if (taskText === "") {
                alert("Please enter a task text.");
                return;
            }

            saveSessionTask(session_id, taskText, priorita);
        } else if (button.name === "complete_task") {
            const task = button.closest(".session_task");
            const taskId = task.getAttribute("task-id");
            completeSessionTask(taskId);

            const actionWrap = button.closest(".task_action");
            button.replaceWith(Object.assign(document.createElement("span"), {
                className: "span_task_completed",
                innerText: "done"
            }));
        } else if (button.name === "remove_task") {
            const task = button.closest(".session_task");
            const taskId = task.getAttribute("task-id");
            task.remove();
            removeSessionTask(taskId);
        }
    });

    bases_container.addEventListener("click", function (event) {
        const button = event.target.closest("button");
        if (!button) return;

        if (button.name === "new_session_base") {
            const coordX = document.getElementById("session_base_coord_x").value;
            const coordY = document.getElementById("session_base_coord_y").value;
            const coordZ = document.getElementById("session_base_coord_z").value;

            saveSessionBase(session_id, coordX, coordY, coordZ);
        } else if (button.name === "remove_base") {
            const base = button.closest(".session_base");
            const baseId = base.getAttribute("base-id");
            base.remove();
            removeSessionBase(baseId);
        }
    });
}

function updateSessionModpack(sessionId, modpackId) {
    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "session_modpack_update.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    const data = "session_id=" + encodeURIComponent(sessionId) + "&modpack_id=" + encodeURIComponent(modpackId);
    xhttp.send(data);
}

function updateSessionSeed(sessionId, seed) {
    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "session_seed_update.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    const data = "session_id=" + encodeURIComponent(sessionId) + "&seed=" + encodeURIComponent(seed);
    xhttp.send(data);
}

function saveSessionNote(sessionId, noteHeader, noteText) {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const noteId = this.responseText.trim();
            const notesList = document.querySelector(".session_notes_list");
            notesList.insertAdjacentHTML("afterbegin",
                "<div class='session_note' note-id='" + noteId + "'>" +
                "<div class='session_note_header'>" + noteHeader + "</div>" +
                "<div class='session_note_text'>" + noteText + "</div>" +
                "<div class='session_note_act'><button class='button small_button' name='remove_note' type='button'><i class='fa fa-times' title='Delete note'></i></button></div>" +
                "</div>"
            );
            document.getElementById("session_note_header").value = "";
            document.getElementById("session_note_text").value = "";
        }
    };
    xhttp.open("POST", "session_note_create.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    const data = "session_id=" + encodeURIComponent(sessionId) + "&note_header=" + encodeURIComponent(noteHeader) + "&note_text=" + encodeURIComponent(noteText);
    xhttp.send(data);
}

function removeSessionNote(noteId) {
    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "session_note_remove.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    const data = "note_id=" + encodeURIComponent(noteId);
    xhttp.send(data);
}

function saveSessionTask(sessionId, taskText, priorita) {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const taskId = this.responseText.trim();
            const tasksList = document.querySelector(".session_tasks_list");
            tasksList.insertAdjacentHTML("afterbegin",
                "<div class='session_task priorita_" + priorita + "' task-id='" + taskId + "'>" +
                "<div class='task_body'>" + taskText + "</div>" +
                "<div class='task_footer'>" +
                "<div class='task_priorita'>" + priorita + "</div>" +
                "<div class='task_action'>" +
                "<button type='button' name='complete_task' class='button small_button pull-right' title='Mark as done'><i class='fa fa-check'></i></button>" +
                "<button type='button' name='remove_task' class='button small_button pull-right' title='Delete task'><i class='fa fa-times'></i></button>" +
                "</div></div></div>"
            );
            document.getElementById("session_task_text").value = "";
        }
    };
    xhttp.open("POST", "session_task_create.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    const data = "session_id=" + encodeURIComponent(sessionId) + "&task_text=" + encodeURIComponent(taskText) + "&priorita=" + encodeURIComponent(priorita);
    xhttp.send(data);
}

function completeSessionTask(taskId) {
    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "session_task_status_update.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    const data = "task_id=" + encodeURIComponent(taskId) + "&status=done";
    xhttp.send(data);
}

function removeSessionTask(taskId) {
    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "session_task_remove.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    const data = "task_id=" + encodeURIComponent(taskId);
    xhttp.send(data);
}

function saveSessionBase(sessionId, coordX, coordY, coordZ) {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const base = JSON.parse(this.responseText);
            const basesList = document.querySelector(".session_bases_list");
            basesList.insertAdjacentHTML("afterbegin",
                "<div class='session_base' base-id='" + base.base_id + "'>" +
                "<div class='session_base_name'>" + base.base_name + "</div>" +
                "<div class='base_coord_card'><div class='coord tooltip' title='X'>" + coordX + "</div><div class='coord tooltip' title='Y'>" + coordY + "</div><div class='coord tooltip' title='Z'>" + coordZ + "</div></div>" +
                "<div class='session_base_act'><button class='button small_button' name='remove_base' type='button'><i class='fa fa-times' title='Delete base'></i></button></div>" +
                "</div>"
            );
            document.getElementById("session_base_coord_x").value = "";
            document.getElementById("session_base_coord_y").value = "";
            document.getElementById("session_base_coord_z").value = "";
        }
    };
    xhttp.open("POST", "session_base_create.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    const data = "session_id=" + encodeURIComponent(sessionId) + "&coord_x=" + encodeURIComponent(coordX) + "&coord_y=" + encodeURIComponent(coordY) + "&coord_z=" + encodeURIComponent(coordZ);
    xhttp.send(data);
}

function removeSessionBase(baseId) {
    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "session_base_remove.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    const data = "base_id=" + encodeURIComponent(baseId);
    xhttp.send(data);
}

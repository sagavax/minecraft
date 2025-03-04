//function had illegal parameter
function validateForm() {
            var result = true;
            var msg = "";
            if (document.ExamEntry.name.value == "") {
                msg += "You must enter your name \n";
                document.ExamEntry.name.focus();
                document.getElementById('name').style.color = "red";
                 // document.getElementById(‘name’).style.color = "red";--->Id should be in quotes
                result = false;
            }
            if (document.ExamEntry.subject.value == "") {
                msg += "You must enter the subject \n";
                document.ExamEntry.subject.focus();
                document.getElementById('subject').style.color = "red";
                // document.getElementById(‘subject’).style.color = "red";--->Id should be in quotes
                result = false;
            }
            if (msg == "") {
                return result;
            } {
                alert(msg);
                return result;
            }
        }
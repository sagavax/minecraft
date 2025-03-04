 assync function message(message_text, status){
 	var container = document.createElement("div");
 	container.classList.add("message_box");
 	container.innerHTML(message_text);
 	if(status==="success"){
 		container.classList.add("success")
 	} else if( status==="error"){
 		container.classList.add("error");
 	}
 	//create a meesage box
 	//animate it - show / hide
 	//destroy it


 }
function validateForm() {
	var x=document.forms["contactUs"]["firstname"].value;
	var ln=document.forms["contactUs"]["lastname"].value;
	var e=document.forms["contactUs"]["email"].value;
	var hv=document.forms["contactUs"]["hv"].value;
	
	if (x==null || x=="") {
  		alert("First name must be filled out");
  		return false;
  	}
  	if (ln==null || ln=="") {
  		alert("Last name must be filled out");
  		return false;
  	}
  	if (e==null || e=="") {
  		alert("Email address is required");
  		return false;
  	}
  	if (hv != "2") {
  		alert("Your human verification answer was incorrect!");
  		return false;
  	}
}
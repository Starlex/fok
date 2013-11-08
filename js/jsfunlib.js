function showDiv(cbID, divID){
	var chb = document.getElementById(cbID);
	var div = document.getElementById(divID);
	if(true === chb.checked){
		div.style.display = "block";
	}
	else{
		div.style.display = "none";
	}
}
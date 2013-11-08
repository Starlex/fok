function showDiv(chbID1, divID, chbID2){
	var chb1 = document.getElementById(chbID1).checked;
	var chb2 = document.getElementById(chbID2);
	var div = document.getElementById(divID).style;
	if(true === chb1){
		div.display = "block";
		chb2.disabled = true;
	}
	else{
		div.display = "none";
		chb2.disabled = false;
	}
}
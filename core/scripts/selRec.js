
function toggleCB() { // toggle array of checkboxes on and off
	var obj = document.getElementsByClassName("cb"),
	length = obj.length;

	while(length--) {
		obj[length].checked = ! obj[length].checked;
	}
}

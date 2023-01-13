
function toggleCB(cls) { // toggle array of checkboxes on and off
	var obj = document.getElementsByClassName(cls),
	length = obj.length;

	while(length--) {
		obj[length].checked = ! obj[length].checked;
	}
}


function setCaption() {
	inp = document.getElementById("upload");
	cnt = inp.files.length;
	cap = cnt + " file(s)"; if (cnt == 1) cap = inp.value.split( '\\' ).pop();
	lbl = document.getElementById("label");
	lbl.innerHTML = cap;
}

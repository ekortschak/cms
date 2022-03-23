
function chgDoc(obj) {
	fil = obj.options[obj.selectedIndex].value;
	dst = document.getElementById("pic");
	dst.setAttribute("src", fil);
	dst.Play();

	dst = document.getElementById("dlink");
	dst.setAttribute("href", fil);
}


function crinfo() {
	obj = document.getElementById("crinfo");
	vis = obj.style.visibility;

	if (vis != "visible") vis = "visible";
	else vis = "collapse";

	obj.style.visibility = vis;
}

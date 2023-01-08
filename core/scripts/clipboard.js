
function clip() { // copy to clipboard
	obj = document.getElementById("content");
	obj.select();
	obj.setSelectionRange(0, 99999); /* For mobile devices */
	document.execCommand("copy");
	obj.value = "Copied to clipboard ...";
}

function clipDiv() { // copy to clipboard
	obj = document.getElementById("content");
	rng = document.createRange();
	rng.selectNode(obj);
	window.getSelection().removeAllRanges(); // clear current selection
	window.getSelection().addRange(rng); // to select text
	document.execCommand("copy");
	window.getSelection().removeAllRanges();// to deselect
	obj.innerHTML = "Copied to clipboard ...";
}

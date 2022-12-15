// sample code for keyevents

function doKeys(e) {
	if (! e.ctrlKey) return;

	switch (e.key) {
		case "b": case "f": addTag("b"); break;
		case "i": case "k": addTag("i"); break;
		case "u":           addTag("u"); break;
		case "s": break;
		default: return;
	}
	e.preventDefault();
	e.stopPropagation();
	e.returnValue = false;

	if (e.key == "s") exSubmit();
	return e;
}

// sample code for mouse events

function allowDrop(ev) {
	ev.preventDefault();
}

function drag(ev) {
	ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
	ev.preventDefault();
	var data = ev.dataTransfer.getData("text");
	ev.target.appendChild(document.getElementById(data));
}


<img id="drag1" src="xy.gif" draggable="true" ondragstart="drag(event)">
<div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)"></div>



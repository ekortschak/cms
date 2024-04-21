
function exKey(e) {
	if (e.keyCode === 9) {
		console.log("9");
		insAny("\t");
		return;
	}

	if (e.shiftKey) {
		if (e.keyCode === 13) {
			insAny("<br>");
			return;
		}
	}

	if (! e.ctrlKey) return e;

	switch (e.key) {
		case "b": case "f": addTag("b"); break;
		case "i": case "k": addTag("i"); break;
		case "u":           addTag("u"); break;
		case "s":           exSubmit();  break;
		case "c":
		case "v": break;
		default: return e;
	}
	return stopEx(e);
}

function stopEx(e) {
	e.preventDefault();
	e.stopPropagation();
	e.returnValue = false;
	return e;
}

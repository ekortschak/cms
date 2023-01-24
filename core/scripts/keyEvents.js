
function exKey(e) {
	if (! e.ctrlKey) return e;

	switch (e.key) {
		case "b": case "f": addTag("b"); return stopDefault(e);
		case "i": case "k": addTag("i"); return stopDefault(e);
		case "u":           addTag("u"); return stopDefault(e);
		case "s":           exSubmit();
	}
	return e;
}

function stopDefault(e) {
	e.preventDefault();
	e.stopPropagation();
	e.returnValue = false;
	return e;
}

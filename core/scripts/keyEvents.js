function doTextKeys(e) {
	if (! e.ctrlKey) return;

	switch (e.key) {
		case "b": case "f": addTag("b"); break;
		case "i": case "k": addTag("i"); break;
		case "u":           addTag("u"); break;

		case "s": break;
		default: return e;
	}
	e.preventDefault();
	e.stopPropagation();
	e.returnValue = false;

	document.getElementById("inlineEdit").submit();
	return e;
}


function doHtmlKeys(e) {
	if (! e.ctrlKey) return;

	switch (e.key) {
		case "b": case "f": addTag("b"); break;
		case "i": case "k": addTag("i"); break;
		case "u":           addTag("u"); break;

		case "s": exSubmit();
		default: return e;
	}
	e.preventDefault();
	e.stopPropagation();
	e.returnValue = false;

	exSubmit();
	return e;
}


function exKey(e) {
	if (! e.ctrlKey) return e;

	switch (e.key) {
		case "b": case "f": addTag("b"); break;
		case "i": case "k": addTag("i"); break;
		case "u":           addTag("u"); break;
		case "s":           exSubmit();  break;
		default: return e;
	}

	e.preventDefault();
	e.stopPropagation();
	e.returnValue = false;
	return e;
}

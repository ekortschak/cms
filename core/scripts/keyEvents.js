
function exKey(e) {
	if (! e.ctrlKey) return e;

	f = e;
	f.preventDefault();
	f.stopPropagation();
	f.returnValue = false;

	switch (e.key) {
		case "b": case "f": addTag("b"); return f;
		case "i": case "k": addTag("i"); return f;
		case "u":           addTag("u"); return f;
		case "s":           exSubmit();
	}
	return e;
}

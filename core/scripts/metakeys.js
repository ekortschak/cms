function doKeys(e) {
	if (e.key == "F5") return e; e.preventDefault(); e.stopPropagation(); e.returnValue = false;
	if (e.key != "F4") return e;

	obj = document.getElementById("metaEdit");
	txt = obj.value;
	key = selHtml();

	if (txt.length > 0) obj.value = txt + ", " + key;
	else obj.value = key;

	return e;
}

function selHtml() {
	if (typeof window.getSelection != "undefined") {
		sel = window.getSelection();
		if (sel.rangeCount) {
			out = document.createElement("div");
			for (i = 0, len = sel.rangeCount; i < len; ++i) {
				out.appendChild(sel.getRangeAt(i).cloneContents());
			}
			return out.innerHTML;
		}
	} else if (typeof document.selection != "undefined") {
		if (document.selection.type == "Text") {
			return document.selection.createRange().htmlText;
		}
	}
	return "";
}

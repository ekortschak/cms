var hist = [];
var cols = 2;
var pwid = 200;


function getView() {
	chk = document.getElementById("divEdit"); if (chk == null) return false;
	chk = chk.style.display;
	return (chk != "none");
}

// **********************************************************
// modifying html code
// **********************************************************
function show() {
	htm = selString();
	alert(htm);
}
function addTag(tag) { // bracket selection by tag
	wlf = ".p.h1.h2.h3.h4.h5.h6.";
	wlf = wlf.includes("." + tag + ".");

	htm = selString(); if (! htm) htm = "¶";
	htm = cleanSel(htm);
	htm = "<" + tag + ">" + htm + "</" + tag + ">";

	if (wlf) htm = htm + "\n";
	if (tag.includes("h")) htm = htm + "\n<p>x</p>";

	repString(htm);
}
function insAny(txt) { // insert txt after selection
	htm = selString() + txt;
	repString(htm);
}
function repAny(txt) { // insert txt after selection
	repString(txt);
}

function insRef(typ) { // links
	htm = selString(); if (! htm) htm = "TEXT";
	url = prompt("URL:", "http://xy"); if (! url) return;
	out = "<a href='" + url + "'>" + htm + "</a>"; if (typ == "ax")
	out = "<a href='" + url + "' target='sf'>" + htm + "</a>";
	repString(out);
}

function clrTags() {
	htm = selString();
//	htm = htm.replace(/\r/g, "");
	htm = htm.replace(/\n/g, " ");
	htm = htm.replace(/(<([^>]+)>)/gi, "");
	repString(htm);
}

// **********************************************************
// images
// **********************************************************
function askWid() {
	pwid = prompt("Breite", pwid);
	if (pwid < 100) pwid = 100;
	if (pwid > 500) pwid = 500;
}

function insImg(typ) { // images
	switch (typ) {
		case "ico": htm = "HTW::image('./pic.png');";  break;
		case "ir":  htm = "HTW::thumbR('./pic.png');"; break;
		case "il":  htm = "HTW::thumbL('./pic.png');"; break;
		default:    htm = "HTW::img('./pic.png');";
	}
	htm = "<php>" + htm + "</php>";
	repString(htm);
}

// **********************************************************
// tables
// **********************************************************
function askCols() {
	cols = prompt("Spalten", cols);
	if (cols <  2) cols =  2;
	if (cols > 15) cols = 15;
}

function addTable(tag) {
	if (getView()) {
		if (tag == "tr") return;
		if (tag == "th") return;
		if (tag == "td") return;
	}
	htm = "";

	switch (tag) {
		case "tb":
			htm = "<table border=1>\n";
		    htm+= "\t<tr class='rh'>\n" + getRow("th") + "\t</tr>\n";
		    htm+= "\t<tr class='rw'>\n" + getRow("td") + "\t</tr>\n";
			htm+= "</table>\n";
			break;

		case "tr": htm+= "\t<tr class='rw'>\n"  + getRow("td") + "\t</tr>\n"; break;
		case "th": htm = getRow("th"); break;
		case "td": htm = getRow("td"); break;
		default: return;
	}
	repString(htm);
}
function getRow(tag = "td") {
	htm = "";
	for (i = 0; i < cols; i++) {
		htm += "\t\t<" + tag + ">xxxx</" + tag + ">\n";
	}
	return htm;
}

// **********************************************************
// listings
// **********************************************************
function addList(tag) {
	sel = selString(); if (! sel) sel = "xxxx";

	switch (tag) {
		case "ol": htm = "<ol>\n<li>" + sel + "</li>\n</ol>\n"; break;
		case "ul": htm = "<ul>\n<li>" + sel + "</li>\n</ul>\n"; break;
		case "dl": htm = "<dl>\n<dt>" + sel + "</dt>\n<dd>Data</dd>\n</dl>\n"; break;
		default: return;
	}
	repString(htm);
}

// **********************************************************
// retrieving selected text
// **********************************************************
function selString() {
	if (getView()) return selHtml();
	return selText();
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

function selText() {
    obj = document.getElementById("content");
    ein = obj.selectionStart;
    aus = obj.selectionEnd;
    htm = obj.value;
    return htm.substring(ein, aus);
}

// **********************************************************
// replacing selected text
// **********************************************************
function repString(html) {
	doStore();

	if (getView()) {
		updDivEdit(html);
		return;
	}
	obj = document.getElementById("content");
	updTxtEdit(obj, html);
}

function updTxtEdit (input, html) {
	if (document.execCommand("insertText", false, html)) return;

 // Firefox (non-standard method)
	const start = input.selectionStart;
	input.setRangeText(html);
	input.selectionStart = input.selectionEnd = start + html.length;

 // Notify any possible listeners of the change
	const e = document.createEvent("UIEvent");
	e.initEvent("input", true, false);
	input.dispatchEvent(e);
}

function updDivEdit(html) {
    if (sel = window.getSelection()) {
        if (sel.getRangeAt && sel.rangeCount) {
			range = sel.getRangeAt(0);
			range.deleteContents();

//			inf = document.createhtmlNode(html);
//			range.insert(inf);
//			return;
			inf = range.createContextualFragment(html);
			range.insertNode(inf);
			range.collapse(true);
        }
        return;
    }
    if (document.selection && document.selection.createRange) {
        document.selection.createRange().html = html;
    }
}

// **********************************************************
// editing functions
// **********************************************************
function copy() {
	obj = document.getElementById("copiedText");
	obj.setAttribute("value", selString());
	document.execCommand("copy");
}
function cut() {
	obj = document.getElementById("copiedText");
	obj.setAttribute("value", selString());
	repString("");
}
function paste() {
	htm = document.getElementById("copiedText").value;
	repString(htm);
}

function exIns(htm) {
	sel = selString();
	htm = htm.replace(/SEL.TEXT/g, sel);
	htm = htm.replace(/@DQ@/g, '"');
	repString(htm);
}

// **********************************************************
// storing and undoing edits
// **********************************************************
function doStore() {
	htm = getCurrent();
	hist.unshift(htm);
}

function doUndo() {
	if (! hist.length) return;
	if (hist.length > 1) htm = hist.shift();
	else htm = hist[0];

	if (getView())
	document.getElementById("divEdit").innerHTML = htm; else
	document.getElementById("content").value = htm;
}

function getCurrent() {
	if (getView())
	return document.getElementById("divEdit").innerHTML;
	return document.getElementById("content").value;
}

// **********************************************************
// saving data
// **********************************************************
function exSubmit() {
	mod = getView();

	if (mod) {
		obj = document.getElementById("content");
		htm = document.getElementById("divEdit").innerHTML;
		obj.value = htm;
	}
	document.getElementById("inlineEdit").submit();
}

// **********************************************************
// switching view from inline edit to source code edit
// **********************************************************
function toggleView() {
	doStore();

	if (getView()) toTxtEdit();
	else toDivEdit();
}

function toTxtEdit() {
	      document.getElementById("divEdit").style.display = "none";
	htm = document.getElementById("divEdit").innerHTML;
	      document.getElementById("content").value = htm;
	      document.getElementById("curEdit").style.display = "block";
}
function toDivEdit() {
	      document.getElementById("curEdit").style.display = "none";
	htm = document.getElementById("content").value;
	      document.getElementById("divEdit").innerHTML = htm;
	      document.getElementById("divEdit").style.display = "block";
}

// **********************************************************
// code tidying
// **********************************************************
function beautify(htm) {
	htm = clearLF(htm);

	htm = htm.replace(/<div(.*?)>/gi, "<p>");
	htm = htm.replace(/<\/div>/gi, "</p>");
	htm = htm.replace(/<p>(\s?)/gi, "<p>");

	htm = htm.replace(/<h/gi, "\n\n\n<h");
	htm = htm.replace(/<p>/gi, "\n\n<p>");

	htm = htm.replace(/(\s?)<br>(\s?)/gi, "<br>\n");
	htm = htm.replace(/<br>(\s?)<\//gi, "</");

	htm = htm.replace(/<([uod]+)l/gi, "\n\n<$1l"); // lists
	htm = htm.replace(/<li/gi, "\n<li");
	htm = htm.replace(/<d([dt]+)/gi, "\n<d$1");
	htm = htm.replace(/<\/([uod]+)l>/gi, "\n</$1l>"); // lists

	htm = htm.replace(/<block/gi, "\n\n<block"); // tables
	htm = htm.replace(/<\/block>/gi, "\n</block>"); // lists

	htm = htm.replace(/<table/gi, "\n\n<table"); // tables
	htm = htm.replace(/<\/table>/gi, "\n</table>"); // lists
	htm = htm.replace(/<t([rhd]+)/gi, "\n<t$1");

	htm = htm.replace(/REF::/gi, "\nREF::"); // tables
	htm = htm.replace(/<php>(\s+)REF::/gi, "\n\n<php>bblRef"); // bible refs
	htm = htm.replace(/\n<php>(\s+)REF::link(.*?)<\/php>/gi, "<php>REF::link$1</php>"); // bible links
	htm = htm.replace(/<php>(\s?)HT/gi, "\n\n<php>HT"); // ???
	return htm.trim();
}

function insertMarks(htm) {
	htm = htm.replace(/<p>/gi, "¶<p>");
	htm = htm.replace(/<h([1-6]+)>/gi, "¶<h$1>");
	htm = htm.replace(/<([uod]+)l>/gi, "¶<$1l>");

	htm = htm.replace(/<br>(\s?)/gi, "<br>");

	htm = "¶" + htm.trim() + "\n¶";
	htm = htm.replace(/¶(\s+)¶/gi, "¶");
	htm = htm.replace(/¶(¶+)/gi, "¶");
	return htm;
}

function clearLF(htm) {
	htm = htm.trim();
	htm = htm.replace(/(¶+)/gi, "");
	htm = htm.replace(/(\n+)/gi, "\n");
	return htm;
}

function cleanSel(txt, tag) {
	txt = txt.replace(/<div>/gi, "");
	txt = txt.replace(/<\/div>/gi, "");
	return txt;
}

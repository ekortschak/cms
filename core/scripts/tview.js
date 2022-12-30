
function toggleTv(qid) {
	rec = "tv[" + qid + "]";
	qid = qid * 1;

    obj = document.getElementsByClassName('tv');
    cur = document.getElementById(rec);
    vgl = cur.getAttribute('data-par');

    pos = cur.style.backgroundPositionY;
    vis = "hidden";

    if (pos == "bottom") { // change to top = collapse
        cur.style = "background-position-y: top; ";
    }
    else { // change to bottom = visible
        cur.style = "background-position-y: bottom; ";
        vis = "visible";
    }

    for (i = qid + 1; i < obj.length; i++) {
		cur = obj[i];
        lev = cur.getAttribute("data-par"); if (lev <= vgl) break;

     // whether closed or opened: subfolders will always be shown as closed
		cur.style = "background-position-y: top;";

        if ((lev == (vgl * 1 + 1)) && (vis == "visible")) {
		 // first grade sub level will be shown
			cur.style.display = "block";
        }
        else {
		 // deeper levels will be closed
			cur.style.display = "none";
        }
    }
}

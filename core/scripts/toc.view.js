function load(ref) { // add anchors to page
	obj = document.getElementById("scView");
	url = "?pge=" + ref;

	$(document).ready(function(){
		$.get(url, function(htm, status){
			obj.innerHTML = htm;
        });
    });
}

function toggleDiv(pfx, qid) {
	rec = pfx + "[" + qid + "]";

    cur = document.getElementById(rec);
    cls = cur.className;
    pos = cur.style.backgroundPositionY;

	vgl = getLevel(cls);
    vis = "hidden";

    if (pos == "bottom") { // change to top = collapse
		cur.classList.remove("open");
		cur.classList.add("closed");
    }
    else { // change to bottom = expand
		cur.classList.remove("closed");
		cur.classList.add("open");
        vis = "visible";
    }

    do { qid++;
		fnd = pfx + "[" + qid + "]";

		cur = document.getElementById(fnd); if (cur == null) break;
		cls = cur.className;
		lev = getLevel(cls); if (lev <= vgl) break;

console.debug(fnd);

     // whether closed or opened: subfolders will always be shown as closed
		cur.classList.remove("open");
		cur.classList.add("closed");

        if ((lev == (vgl * 1 + 1)) && (vis == "visible")) {
		 // first grade sub level will be shown
			cur.classList.remove("hide");
			cur.classList.add("show");
        }
        else {
		 // deeper levels will be closed
			cur.classList.remove("show");
			cur.classList.add("hide");
        }
    } while (1);
}

function getLevel(cls) {
	lev = cls.split("lev"); lev = lev[1];
	lev = lev.split(" ");   lev = lev[0];
	return lev;
}

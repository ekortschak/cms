
function load(ref) {
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
	qid = qid * 1;

    cur = document.getElementById(rec);
    cls = cur.className;
    pos = cur.style.backgroundPositionY;

	vgl = getLevel(cls);
    vis = "hidden";

    if (pos == "bottom") { // change to top = collapse
        cur.style = "background-position-y: top; ";
    }
    else { // change to bottom = expand
        cur.style = "background-position-y: bottom; ";
        vis = "visible";
    }

    do { qid++;
		nam = pfx + '_' + qid;
		cur = document.getElementsByName(nam);
		cur = cur[0];

		if (typeof cur !== "object") break;

		cls = cur.className;
		lev = getLevel(cls);

		if (lev <= vgl) break;

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
    } while (1);
}

function getLevel(cls) {
	lev = cls.split("lev"); lev = lev[1];
	lev = lev.split(" ");   lev = lev[0];
	return lev;
}

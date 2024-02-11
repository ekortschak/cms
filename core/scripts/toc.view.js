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
	hid = cls.includes("closed");

console.debug(cls);

	vgl = getLevel(cls);

    if (hid) { // change to top = collapse
		cur.classList.remove("closed");
		cur.classList.add("open");
    }
    else { // change to bottom = expand
		cur.classList.remove("open");
		cur.classList.add("closed");
    }

    do { qid++;
		fnd = pfx + "[" + qid + "]";
// console.debug(fnd);

		cur = document.getElementById(fnd); if (cur == null) break;
		cls = cur.className;
		lev = getLevel(cls); if (lev <= vgl) break;

     // whether closed or opened: subfolders will always be shown as closed
		cur.classList.remove("open");
 		cur.classList.add("closed");

        if ((lev == (vgl * 1 + 1)) && (hid)) {
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

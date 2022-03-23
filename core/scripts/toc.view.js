
function load(ref) {
	obj = document.getElementById("scView");
	url = "?pge=" + ref;

	$(document).ready(function(){
		$.get(url, function(htm, status){
			obj.innerHTML = htm;
        });
    });
}

function toggleDiv(qid) {
	rec = "q[" + qid + "]";

    obj = document.getElementsByClassName('mnu');
    cur = document.getElementById(rec);
    vgl = cur.getAttribute('data-par');

	fst = (qid * 1 + 1);
    pos = cur.style.backgroundPositionY;
    vis = "hidden";

    if (pos == "bottom") { // change to top = collapse
        cur.style = "background-position-y: top; ";
    }
    else { // change to bottom = visible
        cur.style = "background-position-y: bottom; ";
        vis = "visible";
    }

    for (i = fst; i < obj.length; i++) {
        lev = obj[i].getAttribute('data-par'); if (lev <= vgl) break;

     // whether closed or opened: subfolders will always be shown as closed
		obj[i].style = "background-position-y: top;";

        if ((lev == (vgl * 1 + 1)) && (vis == "visible")) {
		 // first grade sub level will be shown
			obj[i].style.display = "block";
        }
        else {
		 // deeper levels will be closed
			obj[i].style.display = "none";
        }
    }
}

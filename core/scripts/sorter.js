	var source; var fst = 0;
	var stored; var snd = 0;

function start(evt){
	source = evt.target;
	stored = evt.target.innerHTML;
	fst = evt.target.getAttribute("data-x") - 1;
	evt.dataTransfer.setData("text/plain", evt.target.innerHTML);
	evt.dataTransfer.effectAllowed = "move";
}

function check(evt){
	alert(evt.target.getAttribute("data-x"));
}

function hover(evt){
	evt.preventDefault();
}

function dropped(evt){
	evt.preventDefault();
	evt.stopPropagation();
	snd = evt.target.getAttribute("data-x") - 1;

	if (snd == fst) return; inc =  1;
	if (fst  > snd)         inc = -1;

    obj = document.getElementsByClassName("drag");
	tmp = obj[fst].innerHTML;
	src = obj[fst].getAttribute("data-fso");
	out = "";

	for (i = fst; i * inc < snd * inc; i += inc) {
		obj[i].innerHTML = obj[i + inc].innerHTML;
		obj[i].setAttribute("data-fso", obj[i + inc].getAttribute("data-fso"));
	}
	obj[snd].innerHTML = tmp;
	obj[snd].setAttribute("data-fso", src);

	for (i = 0; i < obj.length; i++) {
		out = out + obj[i].getAttribute("data-fso") + ";\n";
	}
 	dst = document.getElementById("slist");
 	dst.value = out;
}

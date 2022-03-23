
function createMap(fnm, cWid, rHgt) {
	div = document.getElementById("div." + fnm);
    obj = document.getElementById("img." + fnm);
    map = document.createElement("map");
    map.name = "map." + fnm;

	max = div.clientWidth / cWid;

	for (j = 0; j < max; j++) {
		area = document.createElement("area");
		koos = cWid * j + ",0," + cWid * (j + 1) + "," + rHgt;

		area.shape = "rect";
		area.coords = koos;
		area.href="javascript:setimgval('" + fnm + "', '" + (j + 1) + "')";
// 		area.onclick = function(){setimgval(img, j)}; // funkt nicht, weil j nach load immer 5

		map.appendChild(area);
	}
	div.appendChild(map);
	obj.setAttribute('usemap', "#" + map.name);
}


function setimgval(fnm, val) {
	obj = document.getElementById("div." + fnm);
	obj.style.backgroundPositionY = (-20 * val) + "px";

	hid = document.getElementById("val." + fnm);
	hid.value = val;
}

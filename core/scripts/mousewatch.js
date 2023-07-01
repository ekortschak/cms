
const mtrack = function(e) {
	x = e.clientX;

	fcs = getVar('--fcs');

	if (x < fcs) {
//		document.documentElement.style.setProperty('--aln', "");
	}
	else {
//		document.documentElement.style.setProperty('--aln', "0px");
	}
}

function getVar(cssvar) {
	return getComputedStyle(document.documentElement).getPropertyValue(cssvar);
}

document.addEventListener('mousemove', e => { mtrack(e); })

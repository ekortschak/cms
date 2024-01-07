<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create user input filters (forms)

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("other/pageAnalizer.php");

$obj = new pageAnalizer();

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class pageAnalizer {
	private $srv = "";

function __construct($server) {
	$this->srv = FSO::trim($server);
}

// ***********************************************************
// methods
// ***********************************************************
public function show($page, $what) {
	$pge = FSO::join($this->srv, $page);
	$htm = file_get_contents($pge);

	if ($what == "css") return $this->showStyles($htm);
	if ($what == "scr") return $this->showScripts($htm);
	if ($what == "med") return $this->showMedia($htm);
	if ($what == "pix") return $this->showPics($htm);
	if ($what == "nos") return $this->showNoScript($htm);

	$this->showHRef($htm);
}

// ***********************************************************
private function showHRef($htm) {
	$arr = STR::find($htm, "<a", "</a>"); sort($arr);
	$this->showLinks($arr, 'href="');
}
private function showStyles($htm) {
	$arr = STR::find($htm, "<link", ">");
	$this->showLinks($arr, 'href="');
	$this->showTag($htm, "style");
}

// ***********************************************************
private function showMedia($htm) {
	$arr = STR::find($htm, "<embed", "</embed>"); sort($arr);
	$this->showLinks($arr, 'src="');
}
private function showPics($htm) {
	$arr = STR::find($htm, "<img", ">"); sort($arr);
	$this->showLinks($arr, 'src="');
}

// ***********************************************************
private function showScripts($htm) {
	$arr = STR::find($htm, "src=", ".js");
	$this->showLinks($arr);
	$this->showTag($htm, "script");
}
private function showNoScript($htm) {
	$this->showTag($htm, "noscript");
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function showTag($htm, $tag) {
	$arr = STR::find($htm, "<$tag>", "</$tag>"); if (! $arr) return;

	foreach ($arr as $itm) {
		$txt = htmlspecialchars($itm);
		$txt = STR::replace($txt, "{", "{\n");
		$txt = STR::replace($txt, "}", "\n}\n");
		HTW::tag($txt, "code");
	}
}

private function showLinks($arr, $start = '"', $end = '"') {
	foreach ($arr as $itm) {
		$cap = STR::between($itm, $start, $end);
		$this->showLink($cap);
	}
}

private function showLink($cap) {
	if (strlen($cap) < 2) return;

	$lnk = $cap; if (STR::begins($cap, "/"))
	$lnk = FSO::join($this->srv, $cap);

	HTW::href($lnk, $cap, "analizer");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

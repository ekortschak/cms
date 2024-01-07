<?php
// used to add a chapter to a book

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class chapter extends tpl {
	private $err = false;
	private $skp = false;
	private $spc = 10;

	private $loc = false;

function __construct() {
	parent::__construct();
}

// ***********************************************************
// setting info
// ***********************************************************
public function init($dir) {
	$this->loc = $dir;
	$this->err = PRN::load($dir);
	$this->skp = PRN::skip();

	PGE::loadPFS($dir);
}

// ***********************************************************
// display methods
// ***********************************************************
public function show($sec = "main") {
	$out = $this->gc($sec);
	$out = $this->stripNotes($out);
	$out = CFG::apply($out);
	echo $out;
}

public function gc($sec = "main") {
	if ($this->err) return ""; $out = "";
	if ($this->skp) return "";

	$pbr = PRN::pbreak(); if ($pbr) $out = HTW::lf("pbr");
	$txt = PRN::content();
	$txt = $this->cnvHeads($txt);

	$this->spc = ($txt) ? 25 : 10;

	$this->set("head",  PRN::title());
	$this->set("level", PRN::level());
	$this->set("text",  $txt);

	$out.= parent::gc($sec);
	$out.= HTM::vspace($spc);
	return $out;
}

// ***********************************************************
// goodies
// ***********************************************************
public function addPic() {
	$pic = PRN::pic(); if (! $pic) return;

	$this->set("pic", $pic);
	return parent::gc("pic");
}

public function addQR() {
	$pic = FSO::join($this->loc, "qr.png"); #if (! $pic) return;
	$qrc = APP::file($pic);

	$this->set("qr", $qrc);
}

// ***********************************************************
// handling footnotes
// ***********************************************************
private function stripNotes($txt) {
	$rba = "<refbox>";  $rca = "<refbody>";
	$rbe = "</refbox>"; $rce = "</refbody>";
	$lst = array();

	$arr = STR::find ($txt,  $rba,   $rbe);  // find refboxes
	$txt = PRG::clear($txt, "$rca@ANY$rce"); // clear refbodies

	foreach ($arr as $itm) {
		$key = STR::before( $itm, $rca);
		$val = STR::between($itm, $rca, $rce);
		$lst[$key] = trim($val);
	}

	$tpl = new tpl();
	$tpl->load("xsite/footnote.tpl");

	foreach ($lst as $key => $val) {
		$idx = PRN::note($key);

		if (! $idx) { // foot note unknown so far
			$tpl->set("idx", $idx);
			$tpl->set("key", $key);
			$tpl->set("val", $val);

			$idx = PRN::noteAdd($idx, $tpl->gc("fnote"));
		}
		$txt = PRG::replace($txt, $rba.$key.$rbe, "$key<sup><fnote>$idx</fnote></sup>");
	}
	return $txt;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function cnvHeads($txt) {
	$txt = STR::replace($txt, "h1>", "hx>");
	$txt = STR::replace($txt, "h2>", "hx>");
	$txt = STR::replace($txt, "h3>", "hx>");
	$txt = STR::replace($txt, "h4>", "hx>");
	$txt = STR::replace($txt, "h5>", "hy>");
	$txt = STR::replace($txt, "h6>", "hz>");
	return $txt;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

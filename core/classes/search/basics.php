<?php
/* ***********************************************************
// INFO
// ***********************************************************
search web files for content

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("search/basics.php");

$bbl = new basics();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class basics extends objects {
	protected $dir = TAB_PATH;
	protected $vis = true;
	protected $sep = "<h4>";
	protected $lim = "<h";

function __construct($dir = TAB_PATH) {
	$this->dir = $dir;
	$this->setSep(ENV::get("Search.Sep", "h4"));
}

// ***********************************************************
// react to user input
// ***********************************************************
public function getIt() {
	$ref = ENV::getParm("ref"); $this->set("ref", $ref);
	$fil = ENV::getParm("prv"); $this->set("prv", $fil);
	$fnd = ENV::get("search");  $this->set("fnd", $fnd);

	$out = $this->getRef($ref);           if ($out) return $out;
	$out = $this->getPreview($fil, $fnd); if ($out) return $out;
	return false;
}

// ***********************************************************
protected function getRef($ref) {
	return false;
}

// ***********************************************************
protected function getPreview($fil, $fnd) {
	if (! $fil) return false; $txt = $this->getFile($fil);
	if (! $fnd) return $txt;

	$out = $this->getMatches($txt, $fnd, 1);
	return VEC::implode($out);
}

protected function getMatches($txt, $find, $dbg = 0) {
	$arr = STR::split($txt, $this->sep); if (! $arr)
	$arr = array($txt);
	$out = array();

	foreach ($arr as $pgf) {
		$chk = strip_tags($pgf); if (! STR::matches($chk, $find)) continue;
		$out[] = $pgf;
	}
	return $out;
}

// ***********************************************************
// retrieve file content
// ***********************************************************
public function getFile($file) {
	$out = APP::gcFil($file); if (! $out) return false;
	$arr = STR::find($out, "<a href", "</a>");
	$loc = PFS::getLoc();

	foreach ($arr as $lnk) {
		$ref = STR::after($lnk, ">");
		$out = str_replace($lnk, "=\"?ref=$ref\">$ref</a>", $out);
	}
	return $out;
}

// ***********************************************************
// find file
// ***********************************************************
public function getInfo($file) {
	$ful = FSO::clearRoot($file);
	$fil = basename($file);

	$out = array(
		"tab" => $this->dir, "file" => $fil,
		"url" => dirname($ful)
	);
	return $out;
}

protected function getTitle($fil) {
	$ini = new ini(dirname($fil));
	return $ini->getHead();
}

// ***********************************************************
// handling properties
// ***********************************************************
public function setVis($value) {
	$vis = (bool) $value; if ($value == "invisible") $vis = false;
	$this->vis = $vis;
}

protected function setSep($sep) {
	switch ($sep) {
		case "p": case "verse":
			$this->sep = "<$sep>"; $this->lim = "</$sep>";
			return;

		case "h": $this->lim = "\n<h"; return;
			$this->sep = "<h4>"; $this->lim = "</h4>";
			return;

		case "*":
			$this->sep = $this->lim = "";
			return;
	}
	$this->setSep("*");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

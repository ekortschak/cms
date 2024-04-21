<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for redirected input files
* i.e. "virtual" directories seemlessly integrated
* into given base dir fs

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/redirector.php");

$red = new redirector();
$arr = $red->load($dir, $top);
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class redirector extends objects {
	private $top = ""; // base dir
	private $col = ""; // last collection
	private $ofs = 0;  // top level

function __construct($dir, $ofs) {
	$this->top = APP::dir($dir);
	$this->ofs = $ofs;

	if (PGE::type($this->top) == "col") {
		$this->col = $this->top;
	 }
}

// ***********************************************************
// methods
// ***********************************************************
public function load($dir, $top) {
	$vdr = $this->vDir($dir, $top);

	$this->set("vdir",  $vdr);
	$this->set("level", FSO::level($vdr, $this->ofs));
	$this->set("type",  $this->type($dir));
	$this->set("iscol", $this->isCol($dir));

	return $this->values();
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function vDir($dir, $top) {
	$trl = STR::clear($dir, $this->top); // calc trailing elements
	return FSO::join($top, $trl); // calc virtual dir
}

private function type($dir) {
	$ini = new ini($dir);
	$typ = $ini->type();

	switch ($typ) {
		case "col": $this->col = $dir; break;
		case "red": $trg = $this->set("target", $ini->target()); break;
	}
	return $typ;
}

private function isCol($dir) {
	$par = $this->col; if (! $par) return false;

	if ($dir == $par) return 1; // physical dir
	if (STR::begins($dir, $par)) return 2;
	return false;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

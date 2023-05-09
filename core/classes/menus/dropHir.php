<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used for multilevel dropBoxes (hierarchical structures)

// ***********************************************************
// HOW TO USE
// ***********************************************************
$box = new dropHir("menu");
$arr = $box->read("files/file.opt");
$out = $box->build("hir.dirs");
$xxx = $box->show();

*/

incCls("menus/dropBox.php");
incCls("files/dirMaker.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class dropHir extends dropBox {
	private $dat = array();
	private $top = array();

function __construct($suit = "combo") {
	parent::__construct($suit);

	$this->hideDesc();
	$this->set("align", "right");
}

// ***********************************************************
// overruled methods
// ***********************************************************
public function gc($sec = "main") {
	if (! $this->top) return;
    return parent::gc($sec);
}

// ***********************************************************
// work through hierarchy
// ***********************************************************
public function build($qid) {
	if ( ! $this->top) return false; $this->top["andere"] = "andere";

	$top = $this->getKey($qid, $this->top);
	return $this->subSet($qid, $top);
}

public function subSet($qid, $pfd) {
	$and = FSO::join($pfd, "andere");
	$arr = $this->find($pfd);
	if (! $arr) return $pfd;
	$arr[$and] = "andere";
	$qid.= ".x";

	$nxt = $this->getKey($qid, $arr);
	return $this->subSet($qid, $nxt);
}

private function find($pfd) {
	$out = array();

	foreach ($this->dat as $key => $val) {
		if (! STR::begins($key, $pfd.DIR_SEP)) continue;
		$chk = STR::after($key, $pfd.DIR_SEP); if (STR::contains($chk, DIR_SEP)) continue;
		$out[$key] = $val;
	}
	return $out;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
public function read($file) {
	$arr = file($file); $out = $itm = array();

	foreach ($arr as $lin) {
		if (STR::begins($lin, "#")) continue;

		$lev = STR::count($lin, "\t");
		$key = trim($lin); if (! $key) continue;

		$itm[$lev] = $key;
		$itm = array_slice($itm, 0, $lev + 1);
		$pfd = implode(DIR_SEP, $itm);

		$this->dat[$pfd] = $key; if ($lev < 1)
		$this->top[$pfd] = $key;
	}
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

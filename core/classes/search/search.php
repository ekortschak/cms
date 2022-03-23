<?php
/* ***********************************************************
// INFO
// ***********************************************************
dient zum Suchen nach Bibelstellen

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("search/search.php");

$bbl = new search();
*/

incCls("search/basics.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class search extends basics {

function __construct($dir = TAB_PATH) {
	parent::__construct($dir);
}

// ***********************************************************
// search for corresponding files
// ***********************************************************
public function getResults($what) {
	$psg = $this->search($what); if (! $psg) return "no.data";
	$out = array();

	foreach ($psg as $fil => $txt) {
		$ref = $this->getInfo($fil); if (! $ref) continue;
		$tit = $this->getTitle($fil, $ref);
		$out[$fil] = $tit;
	}
	return $out;
}

public function getTitle($fil) {
	$ini = new ini(dirname($fil));
	return $ini->getHead();
}

// ***********************************************************
protected function search($what) { // $what expected as string
	if (strlen($what) < 2) return false;

	$drs = FSO::tree($this->dir);
	return $this->exSearch($drs, $what);
}

protected function exSearch($arr, $what) {
	$loc = PFS::getLoc(); $out = array();

	foreach ($arr as $dir => $nam) {
		$fls = FSO::files("$dir/*.*"); if (! $fls) continue;
		$xxx = ENV::set("loc", $dir);

		foreach ($fls as $fil => $nam) {
			if (! LNG::isCurLang($fil)) continue;

			$src = $this->getSource($fil);
			$txt = $this->getContent($src); if (! $txt) continue;
			$psg = $this->getMatches($txt, $what); if (! $psg) continue;
			$out[$fil] = $psg;
		}
	}
	ENV::set("loc", $loc);
	return $out;
}

// ***********************************************************
// variable parts
// ***********************************************************
protected function getSource($fil) {
	return $fil;
}

private function getContent($fil) {
	$ext = FSO::ext($fil); if (! STR::contains(".php.htm.", $ext)) return false;
	$out = APP::gcFil($fil);
	$out = PRG::clrTag($out, "refbox");
	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

<?php
/* ***********************************************************
// INFO
// ***********************************************************
search web files for content

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("search/search.php");

$obj = new search();

*/

incCls("menus/dropBox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class search {
	protected $dir = TAB_PATH;
	protected $vis = true;
	protected $sep = "@Q@";
	protected $mod = "p";

function __construct($dir = TAB_PATH) {
	$this->dir = ENV::get("search.dir", $dir);
	$this->mod = ENV::get("search.mod", $this->mod);
}

// ***********************************************************
// show search options
// ***********************************************************
public function getOpts() {
	$drs = array(
		TAB_ROOT => "All Topics",
		TAB_PATH => "Current Topic"
	);
	$arr = array(
		"h" => "Sections",
		"p" => "Paragraphs",
	);
	$box = new dropBox();
	$this->dir = $box->getKey("search.dir", $drs, TAB_PATH);
	$this->mod = $box->getKey("search.mod", $arr, "h");

	return $box->gc();
}

// ***********************************************************
// search file system for $what
// ***********************************************************
public function getResults($what) {
	$out = $this->isSame($what); if (  $out) return $out;
	$psg = $this->search($what); if (! $psg) return DIC::get("no.match");
	$out = array();

	foreach ($psg as $fil => $txt) {
		$ref = $this->getInfo($fil); if (! $ref) continue;
		$tit = $this->getTitle($fil, $ref);
		$tab = $ref["tab"];

		$out[$tab][$fil] = $tit;
	}
	ENV::set("last.search", $out);
	return $out;
}

// ***********************************************************
protected function isSame($what) {
	$chk = $this->getParms($what);
	$lst = ENV::get("last.parms");

	if ($lst != $chk) {
		ENV::set("last.parms", $chk);
		return false;
	}
	return ENV::get("last.search");
}

protected function getParms($what) {
	return STR::join($this->dir, $this->mod, $what);
}

// ***********************************************************
protected function search($what) { // $what expected as string
	if (strlen($what) < 2) return false;

	$arr = FSO::tree($this->dir);
	$loc = PFS::getLoc();
	$out = array();

	foreach ($arr as $dir => $nam) {
		$fls = FSO::files("$dir/*.*"); if (! $fls) continue;
		$xxx = ENV::set("loc", $dir);

		foreach ($fls as $fil => $nam) {
			if (! LNG::isCurLang($fil)) continue;

			$src = $this->getSource($fil);
			$txt = $this->getContent($src); if (! $txt) continue;
			$txt = $this->prepare($txt);
			$psg = $this->getMatches($txt, $what); if (! $psg) continue;
			$out[$fil] = $psg;
		}
	}
	ENV::set("loc", $loc);
	return $out;
}

// ***********************************************************
protected function getMatches($txt, $find) {
	$arr = STR::split($txt, $this->sep); $out = array();

	foreach ($arr as $pgf) {
		$chk = strip_tags($pgf); if (! STR::matches($chk, $find)) continue;
		$out[] = $pgf;
	}
	return $out;
}

// ***********************************************************
// split text
// ***********************************************************
protected function prepare($txt) {
	$txt = $this->prepare_h($txt); if ($this->mod == "h") return $txt;
	$txt = $this->prepare_p($txt);
	return $txt;
}

protected function prepare_h($txt) {
	for ($i = 1; $i < 6; $i++) {
		$txt = STR::replace($txt, "<h$i>", $this->sep."<h$i>");
	}
	return $txt;
}

protected function prepare_p($txt) {
	$txt = STR::replace($txt, "<p>", $this->sep."<p>");
#	$txt = STR::replace($txt, "<p ", $this->sep."<p ");
	return $txt;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
public function getInfo($file) {
	$ful = APP::relPath($file);
	$fil = basename($file);
	$dir = dirname($ful);
	$tab = STR::between($dir, TAB_ROOT, DIR_SEP);

	$out = array(
		"tab" => TAB_ROOT.$tab, "file" => $fil,
		"url" => $dir
	);
	return $out;
}

public function getTitle($file) {
	$ini = new ini(dirname($file));
	return $ini->getHead();
}

// ***********************************************************
public function getContent($file) {
	$ext = FSO::ext($file);	if (! STR::contains(".php.htm.", $ext)) return false;
	$out = APP::gcFil($file);
	$out = PRG::clrTag($out, "refbox");
	return $out;
}

// ***********************************************************
public function getSnips($file, $what) {
	$txt = $this->getContent($file);
	$txt = $this->prepare($txt);
	$arr = $this->getMatches($txt, $what);

	$out = implode("<hr class=\"search\">\n", $arr);
	$out = STR::clear($out, $this->sep);
	return $out;
}

// ***********************************************************
// dummy methods for derived classes
// ***********************************************************
protected function getSource($file) { // dummy method for derived classes
	return $file;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

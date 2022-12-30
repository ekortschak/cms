<?php
/* ***********************************************************
// INFO
// ***********************************************************
serves to display pics along with text in a slide show

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("other/slides.php");

$slides = new slides();
*/

incCls("dbase/recEdit.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class slides extends tpl {

function __construct() {
	parent::__construct();
	$this->load("modules/slide.tpl");

	$this->set("perm",   "r");
	$this->set("qid",    -1);
	$this->set("owner",  CUR_USER);
	$this->set("holder", "Unknown");
}

// ***********************************************************
// show current slide
// ***********************************************************
public function show($dir = NV) {
	if ($dir == NV) $dir = PFS::getLoc();

	$arr = $this->getPics($dir);

	if (! $arr) {
		return $this->show("dir.empty");
	}
	$max = count($arr);
	$cur = $this->getCurrent($max);
	$sec = $this->setCR($arr[$cur]);

	$this->set("prev",   $cur - 1);
	$this->set("cur",    $cur + 1); // optical representation
	$this->set("next",   $cur + 1); // physical value
	$this->set("last",   $max - 1);
	$this->set("count",  $max);

	$this->substitute("cr", $sec);
	parent::show();
}

// ***********************************************************
// copyright
// ***********************************************************
private function setCR($pic) {
	if (! DB_CON) return "cr.nodb";

	$this->set("pfile", $pic);
	$this->set("text", $this->getText($pic));
	$md5 = md5_file($pic);

	$dbe = new recEdit(NV, "copyright");
	$dbe->setDefault("md5", $md5);
	$dbe->findRec("md5='$md5'");

	$rec = $dbe->getRec(); extract($rec);
	$this->merge($rec);

	$rgt = $this->getPerm($owner);
	$dbe->permit($rgt);

	if ($ID) {
		if (! $memo)
		return "cr.short"; $this->set("cinfo", $memo);
		return "cr.known";
	}
	$this->set("cinfo", $dbe->gc());

	if (DB_LOGIN) return "cr.user";
	return "cr.unknown";
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function getPics($dir) {
	$ptn = FSO::join($dir, "*");
	$arr = FSO::files($ptn);
	$arr = FSO::filter($arr, "pics");
	return array_keys($arr);
}

private function getCurrent($max) {
	$act = ENV::getParm("act", 0);
	return CHK::range($act, $max - 1);
}

private function getText($pic) {
	$dir = dirname($pic);
	$fnm = basename($pic); $fnm = STR::before($fnm, ".");
	return APP::gc($dir, $fnm);
}

private function getPerm($usr) {
	if ($usr == CUR_USER) return "e";
	if (DB_LOGIN) return "a";
	return "r";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

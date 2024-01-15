<?php
/* ***********************************************************
// INFO
// ***********************************************************
used to handle project setup tasks

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/prjMgr.php");

$obj = new prjMgr();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class prjMgr {

function __construct() {
#	$this->cms = rtrim(APP_FBK, DIR_SEP);
}

// ***********************************************************
// create project files
// ***********************************************************
public function addProj($dir, $prj, $tpc) {
	if (is_dir($dir)) MSG::now("prj.exists");
	else {
		$this->addFiles($dir, $tpc);
		$this->reconfig($dir, $prj, $tpc);
	}
	$this->showLink($prj);
}

// ***********************************************************
private function addFiles($dir, $tpc) {
	$tpl = APP::fbkFile("design/setup");
	$hme = FSO::join($dir, "pages/$tpc");
	$cms = APP_FBK;

	FSO::copy("$cms/index.php",  "$dir/index.php");
	FSO::copy("$cms/seo.php",    "$dir/seo.php");
	FSO::copy("$cms/x.sync.php", "$dir/x.sync.php");
	FSO::copy("$cms/x.css.php",  "$dir/x.css.php");
	FSO::copy("$cms/robots.txt", "$dir/robots.txt");

	FSO::copyDir("$tpl/config",  "$dir/config");
	FSO::copyDir("$tpl/1stpage", "$hme/1stpage");
}

// ***********************************************************
// update infiles
// ***********************************************************
private function reconfig($dir, $prj, $tpc) {
	$hme = FSO::join($dir, "pages", $tpc);

	$this->wConfig($dir, $prj);
	$this->wTabIni($hme, $prj, $tpc);
	$this->wPgeIni($hme, $tpc);
}

// ***********************************************************
private function wConfig($dir, $prj) {
	$fil = FSO::join($dir, "config/config.ini");
	$ver = CFG::iniVal("config:app.version", "?");

	$txt = APP::read($fil);
	$txt = STR::replace($txt, "*project*", $prj);
	$txt = STR::replace($txt, "*version*", $ver);
	APP::write($fil, $txt);
}

private function wTabIni($hme, $prj, $tpc) {
	$txt = APP::read("$hme/tab.ini");
	$txt = STR::replace($txt, "*project*", $prj);
	$txt = STR::replace($txt, "*home*", $tpc);

	APP::write("$hme/tab.ini",  $txt);
}

private function wPgeIni($hme, $uid) {
	$txt = APP::read("$hme/page.ini");
	$txt = STR::replace($txt, "*uid*", $uid);

	APP::write("$hme/page.ini", $txt);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function showLink($prj) {
	$top = dirname(APP_DIR);
	$top = basename($top);

	$dir = FSO::join($top, $prj);
	$url = "/$dir?vmode=view";

	echo "<a href='$url' target='newprj'>Show project</a>";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

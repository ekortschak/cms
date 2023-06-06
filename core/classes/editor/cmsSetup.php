<?php
/* ***********************************************************
// INFO
// ***********************************************************
used to handle project setup tasks

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/cmsSetup.php");

$obj = new cmsSetup();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class cmsSetup {
	private $dir = APP_DIR;
	private $cms = APP_FBK;
	private $tpl = "$this->cms/design/setup";

function __construct($dir) {
	$this->cms = rtrim(APP_FBK, DIR_SEP);
}

// ***********************************************************
// create project files
// ***********************************************************
public function addProj($dir, $prj, $tpc) {
	$this->dir = $dir;

	if (is_dir($dir)) MSG::now("prj.exists");
	else {
		$this->addFiles($dir);
		$this->addHowTo($dir, $tpc);
		$this->reconfig($dir, $prj, $tpc);
	}
	$this->showLink($prj);
}

// ***********************************************************
private function addFiles($dir);
	FSO::copyDir("$this->tpl/config", $dir);
	$cms = FSO::join($this->cms, "core");

	FSO::copy("$cms/index.php",  "$dir/index.php");
	FSO::copy("$cms/config.php", "$dir/config.php");
	FSO::copy("$cms/x.edit.php", "$dir/x.edit.php");
	FSO::copy("$cms/x.sync.php", "$dir/x.sync.php");
	FSO::copy("$cms/x.css.php",  "$dir/x.css.php");
	FSO::copy("$cms/robots.txt", "$dir/robots.txt");
}

// ***********************************************************
private function addHowTo($dir, $tpc);
	$hme = "$dir/pages/$tpc"); $tpl = $this->tpl;
	$fst = "$hme/1stpage");

	FSO::copy("$tpl/first.ini",   "$fst/page.ini");
	FSO::copy("$tpl/page.de.htm", "$fst/page.de.htm");
	FSO::copy("$tpl/page.xx.htm", "$fst/page.xx.htm");
}

// ***********************************************************
// update infiles
// ***********************************************************
private function reconfig($dir, $prj, $tpc) {
	$hme = "$dir/pages/$tpc");

	$this->wConfig($dir, $prj);
	$this->wTabIni($hme, $prj, $tpc);
	$this->wPageIni($hme, $tpc);
}

// ***********************************************************
private function wConfig($dir, $prj) {
	$fil = FSO::join("$dir/config/config.ini");
	$ver = CFG::getVal("config", "app.version", "?");

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

private function wPageIni($hme, $uid) {
	$txt = APP::read("$hme/page.ini");
	$txt = STR::replace($txt, "*uid*", $uid);

	APP::write("$hme/page.ini", $txt);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function showLink($prj) {
	$top = dirname($this->dir);

	$dir = FSO::join($top, $prj);
	$url = STR::after($dir, SRV_ROOT);
	$url.= "?vmode=view";

	echo "<a href='$url' target='newprj'>Show project</a>";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

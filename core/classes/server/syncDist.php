<?php
/* ***********************************************************
// INFO
// ***********************************************************
Designed to sync local project to server ...
* settings: config/ftp.ini

// ***********************************************************
// HOW TO USE
// ***********************************************************
$snc = new syncUp();
$snc->read("ftp.ini");
$snc->publish();
*/

incCls("server/syncUp.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class syncDist extends syncUp {

function __construct() {
	parent::__construct();
}

// ***********************************************************
// find versions
// ***********************************************************
protected function getVersions() {
	$ver = APP::arcDir(SRV_ROOT, "ver");
	$ver = STR::replace($ver, APP_NAME, "cms"); // force to cms

	$drs = FSO::folders($ver);
	$arr = array(APP_FBK => "Current state"); // force to cms
	
	foreach ($drs as $key => $val) {
		$arr[$key] = "Version $val";
	}
	$box = new dropBox();
	$xxx = $box->suit("menu");
	$src = $box->getKey("sync.src", $arr);
	$mnu = $box->gc();

	$this->set("choices", $mnu);
	$this->setSource($src);
}

protected function verTarget() {
	$out = $this->htp->query(APP_FBK, "ver"); // force to cms
	$out = implode(" - ", $out);
	return ($out) ? $out : "?";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

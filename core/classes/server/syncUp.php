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
$snc->connect("ftp.ini");
$snc->publish();
*/

incCls("server/syncServer.php");
incCls("menus/dropBox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class syncUp extends syncServer {

function __construct() {
	parent::__construct();

	$this->load("modules/xfer.syncUp.tpl");
}

// ***********************************************************
// run jobs
// ***********************************************************
public function connect($ftp) {
	$srv = parent::connect($ftp);
	$this->setTarget($srv);
}

public function publish() {
	return parent::run();
}

// **********************************************************
// retrieving data for action
// **********************************************************
protected function getTree($src, $dst) {
	if ($this->err) return;

TMR::punch("in");
	$src = $this->lclFiles($src);
TMR::punch("lcl");
	$dst = $this->srvFiles();
TMR::punch("srv");
	$out = $this->getNewer($src, $dst);
TMR::punch("comp");

	$out = $this->chkProtect($out);
	$out = $this->chkRename($out);
	$out = $this->chkCount($out);
TMR::punch("comp");
	return $out;
}

// **********************************************************
protected function aggregate($data) { // prepare for webexec(), reducing pay load
	if (! $this->htp) return $data; $out = array();

	foreach ($data as $act => $lst) {
		if (STR::contains("nwr.man", $act)) continue; // do nothing
		if (STR::contains("cpf", $act)) { // no bulk operations
			$out[$act] = $lst; continue;
		}
		$arr = array(); $str = ""; $idx = 0;

		foreach ($lst as $fso) {
			if (strlen("$str;$fso") < 2000) $str.= "$fso;";
			else { $str = "$fso;"; $idx++; }

			$arr[$idx] = trim($str);
		}
		if ($arr) $out[$act] = $arr;
	}
	return $out;
}

// **********************************************************
// overruled methods
// **********************************************************
protected function manage($act, $fso) {
	if (! $this->htp) return;

	switch ($act) {
		case "cpf":	$out = $this->htp->upload($fso); break;
		default:    $out = $this->htp->query($act, $fso);
	}
	return $this->stripInf($out);
}

protected function getCat($act) {
	if (STR::features("ren.rmd.dpf.mkd", $act))
	return "block(s)";
	return parent::getCat($act);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

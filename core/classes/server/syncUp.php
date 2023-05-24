<?php
/* ***********************************************************
// INFO
// ***********************************************************
Designed to sync local project to server ...
* settings: config/ftp.ini

// ***********************************************************
// HOW TO USE
// ***********************************************************
$snc = new syncUp("ftp.ini");
$snc->publish();
*/

incCls("server/syncServer.php");
incCls("menus/dropBox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class syncUp extends syncServer {

function __construct($inifile) {
	parent::__construct(false);

	$this->load("modules/xfer.syncUp.tpl");
	$this->read($inifile);

	$this->setSource(APP_DIR);
	$this->setTarget($this->get("ftp.froot", "???"));

	$this->set("target", $this->get("web.url", "???"));
	$this->set("vtrg", $this->srvVersion());
}

// ***********************************************************
// run jobs
// ***********************************************************
public function publish() {
	parent::run();
}

// **********************************************************
// retrieving data for action
// **********************************************************
protected function getTree($src, $dst) {
	if ($this->err) return;

	$src = $this->lclFiles($src);
	$dst = $this->srvFiles();
	$out = $this->getNewer($src, $dst);

	$out = $this->chkProtect($out);
	$out = $this->chkRename($out);
	$out = $this->chkCount($out);
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

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

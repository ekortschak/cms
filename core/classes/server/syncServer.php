<?php
/* ***********************************************************
// INFO
// ***********************************************************
Designed to sync local project to server ...
* settings: config/ftp.ini

// ***********************************************************
// HOW TO USE
// ***********************************************************
for internal use only
*/

incCls("server/SSL.php");  // string encryption
incCls("server/sync.php");
incCls("server/http.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class syncServer extends sync {
	protected $htp = false; // http object
	protected $srv = "???"; // remote host

function __construct() {
	$this->err = "no.connection"; // prophylaktisch
	parent::__construct();
}

// ***********************************************************
public function connect($ftp) {
	$ini = new ini($ftp);
	$vls = $ini->values(); $this->merge($vls);
	$prt = $ini->getSec("protect");
	$pcl = $ini->get("web.pcl", "https");
	$srv = $ini->get("web.url");

	if ($srv) {
		$this->htp = new http($srv, $pcl);
		$this->srv = $srv;
	}
	return $srv;
}

// ***********************************************************
protected function run($info = "info") {
	if (! NET::isCon()) return MSG::now("no.connection");
	$this->err = false;

	return parent::run($info);
}

// ***********************************************************
// run jobs
// ***********************************************************
protected function srvFiles() {
	$out = $this->query("get");
	return $this->conv($out);
}

protected function verNum($dir) {
	if (is_dir($dir)) return parent::verNum($dir);

	$out = $this->query("ver");
	return ($out) ? $out : "?";
}

protected function query($act) {
	if ( ! $this->htp) return "";

	$out = $this->htp->query($act);
	return $this->stripInf($out);
}

// **********************************************************
// check for protected files
// **********************************************************
protected function chkProtect($arr) {
	$grd = $this->values("protect"); if (! $grd) return $arr;
	$grd = array_keys($grd); $out = array();
	$obj = DiC::get("objects");
	$chk = 0;

	foreach ($arr as $act => $itm) {
		foreach ($itm as $key => $fso) {
			if (STR::misses($fso, $grd)) {
				$out[$act][] = $fso;
				continue;
			}
			$chk++;
		}
	}
	if ($chk) {
		$out["man"] = $grd;
		$out["man"][] = "<green>$chk $obj</green>";
	}
	return $out;
}

// **********************************************************
// auxilliary methods
// **********************************************************
protected function stripInf($txt) {
	return STR::between($txt, "<body><pre>", "</pre></body>", false);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

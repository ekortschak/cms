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

function __construct($dev) {
	$this->err = "no.connection"; // prophylaktisch

	parent::__construct($dev);
}

// ***********************************************************
public function read($inifile) {
	$ini = new ini($inifile);
	$vls = $ini->getValues(); $this->merge($vls);
	$prt = $ini->getSec("protect");

	$pcl = $this->get("web.pcl", "https");
	$srv = $this->get("web.url");
	$xxx = $this->set("protect", $prt);

	if ($srv) {
		$this->htp = new http($srv, $pcl);
	}
}

// ***********************************************************
protected function run($info = "info") {
	if (! NET::isCon()) return MSG::now("no.connection");
	$this->err = false;
	parent::run($info);
}

// ***********************************************************
// run jobs
// ***********************************************************
protected function srvFiles() {
	$out = $this->query("get");
	return $this->conv($out);
}

protected function srvVersion() {
	$out = $this->query("ver");
	return ($out) ? $out : "?.x";
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
	$grd = $this->get("protect"); if (! $grd) return $arr;
	$grd = VEC::explode($grd, "\n"); $out = array();
	$obj = DiC::get("objects");
	$chk = 0;

	foreach ($arr as $act => $itm) {
		foreach ($itm as $key => $fso) {
			if (! STR::contains($fso, $grd)) {
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

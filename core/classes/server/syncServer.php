<?php
/* ***********************************************************
// INFO
// ***********************************************************
Designed to sync local project to server ...
* settings: config/ftp.ini

// ***********************************************************
// HOW TO USE
// ***********************************************************
$snc = new syncServer();
$snc->read("ftp.ini");
$snc->publish();
*/

incCls("server/sync.php");
incCls("server/http.php");
incCls("server/curl.php");
incCls("server/ftp.php");
incCls("server/SSL.php");

incCls("menus/dropBox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class syncServer extends sync {
	protected $htp = false; // http object
	protected $crl = false; // curl object (upload only)
	protected $ftp = false; // ftp object

function __construct() {
	parent::__construct();
	$this->read("config/ftp.ini");
}

// ***********************************************************
public function read($inifile) {
	$ini = new ini($inifile);
	$vls = $ini->getValues(); $this->merge($vls);
	$prt = $ini->getSec("protect"); $this->set("protect", $prt);

	$ftp = $ini->get("module.FTP_MODE", "none");
	$pcl = $ini->get("web.pcl", "http");
	$srv = $ini->get("web.url", NV);

	if ($srv !== NV) {
		$this->htp = new http($srv);
		$this->crl = new curl("$pcl://$srv");
	}
	if ($ftp == "passive") {
		$this->ftp = new ftp();
		$this->ftp->merge($vls);
	}
	$this->err = "no.connection"; // prophylaktisch
}

// ***********************************************************
protected function run($info = "info") {
	if (! $this->ftp) return;
	if (! $this->ftp->test()) return;

	$this->err = false;
	$this->ftp->connect(); parent::run($info);
	$this->ftp->disconnect();
}

// ***********************************************************
// run jobs
// ***********************************************************
protected function isGood() {
	return NET::isCon();
}

protected function FSremote() {
	if ( ! $this->htp) return;
	return $this->htp->query(".", "get");
}

// **********************************************************
// check for protected files
// **********************************************************
protected function chkProtect($arr) {
	$grd = $this->get("protect"); if (! $grd) return $arr;
	$grd = "\n$grd\n";

	foreach ($arr as $act => $itm) {
		foreach ($itm as $fso) {
			if (! STR::contains($grd, "\n$fso")) continue;
			$arr[$act] = VEC::drop($arr[$act], $fso);
			$arr["man"][] = $fso;
		}
	}
	return $arr;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function remoteVersion() {
	if ( ! $this->htp) return "?";

	$out = $this->htp->query(".", "ver");
	$out = implode(" - ", $out);
	return ($out) ? $out : "?";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

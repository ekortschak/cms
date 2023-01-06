<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for synchronizing fs via http

// ***********************************************************
// HOW TO USE
// ***********************************************************
$htp = new http();
$dat = $htp->aggregate($arr);
$erg = $htp->query($dir, $act);

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class http {
	private $url = "";
	private $dbg = 0;

function __construct($url) {
	$this->url = "https://$url/x.sync.php";
}

// ***********************************************************
public function query($dir, $act = "get") {
	$cmd = $this->getUrl($act, $dir);
	return $this->getPage($cmd);
}

// ***********************************************************
protected function getUrl($act, $fso) {
	$tim = date("YmdGis"); if (is_file($fso))
	$tim = filemtime($fso);
	$prm = "w:=$act &f:=$fso &t:=$tim";

	$md5 = SSL::md5($fso);
	$prm = SSL::encrypt($prm." &c:=$md5");
	$url = $this->url."?p=$prm";

	if ($this->dbg) {
#		HTW::tag("$prm &c:=$md5", "p");
		$lnk = HTM::href("$url&d=1", "Debug Server Response for $act", "dbg");
		$xxx = HTW::tag($lnk, "p");
	}
	return $url;
}

// ***********************************************************
private function getPage($cmd) {
 // get data from server
	$ssl = $this->sslInfo();
	$out = file($cmd, false, stream_context_create($ssl));

	foreach ($out as $key => $val) {

		if (STR::begins($val, "ERROR")) {
			MSG::now($val);
			unset($out[$key]);
			continue;
		}
		$val = utf8_decode($val);
		$val = STR::afterX($val, "?"); // because of utf8_decode();
		$out[$key] = trim($val);
	}
	return $out;
}

// ***********************************************************
// checking dirs
// ***********************************************************
public function isDir($dir) {
	return $this->query($dir, "dir");
}

// ***********************************************************
// reducing pay load
// ***********************************************************
public function aggregate($data) { // prepare for webexec()
	$out = array();

	foreach ($data as $act => $lst) {
		if (! is_array($lst)) continue;

		if (STR::contains(".mkd.cpf.", $act)) { // no bulk operations
			$out[$act] = $lst;
			continue;
		}
		$arr = array(); $str = ""; $idx = 0;

		foreach ($lst as $fso) {
			if (strlen("$str;$fso") < 2000) $str.= "$fso;";
			else {
				$str = "$fso;";
				$idx++;
			}
			$arr[$idx] = trim($str);
		}
		if ($arr) $out[$act] = $arr;
	}
	return $out;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function sslInfo() {
	return array( // cheating on ssl
		"ssl" => array(
			"verify_peer"      => false,
			"verify_peer_name" => false
		)
	);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>


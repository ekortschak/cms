<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for synchronizing fs via http

// ***********************************************************
// HOW TO USE
// ***********************************************************
$htp = new htp();

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
	$ssl = array( // cheating on ssl
		"ssl" => array(
			"verify_peer" => false,
			"verify_peer_name" => false
		)
	);
 // get data from server
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

public function copy($file) {
	$trg = "http://server:port/xxxxx.php";

	$fil = new CURLFile(realpath($file));
	$fls = array ("file" => $fil);
	$opt = array("Content-Type: multipart/form-data");

	$chn = curl_init();
	curl_setopt($chn, CURLOPT_URL, $trg);
	curl_setopt($chn, CURLOPT_POST, 1);
	curl_setopt($chn, CURLOPT_HEADER, 0);
	curl_setopt($chn, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($chn, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
	curl_setopt($chn, CURLOPT_HTTPHEADER, $opt);
	curl_setopt($chn, CURLOPT_FRESH_CONNECT, 1);
	curl_setopt($chn, CURLOPT_FORBID_REUSE, 1);
	curl_setopt($chn, CURLOPT_TIMEOUT, 100);
	curl_setopt($chn, CURLOPT_POSTFIELDS, $fls);

	$erg = curl_exec ($chn);
	return ($erg === false);
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
} // END OF CLASS
// ***********************************************************
?>


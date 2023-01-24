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

function __construct($url) {
	$this->url = "https://$url/x.sync.php";
}

// ***********************************************************
public function query($dir, $act) {
	$cmd = $this->getUrl($act, $dir);
	return $this->getPage($cmd);
}

// ***********************************************************
public function getUrl($act, $fso) {
	$tim = date("YmdGis"); if (is_file($fso))
	$tim = filemtime($fso);
	$prm = "w:=$act &f:=$fso &t:=$tim";

	$md5 = SSL::md5($fso); // uses SECRET
	$prm = SSL::encrypt($prm." &c:=$md5");
	return $this->url."?p=$prm";
}

// ***********************************************************
private function getPage($cmd) {
 // get data from server
	$out = file_get_contents($cmd);
	$out = $this->getNewFmt($out); if (! is_array($out))
	$out = $this->getOldFmt($out);
	
	foreach ($out as $key => $val) {
		if (STR::begins($val, "ERROR")) {
			MSG::now($val);
			unset($out[$key]);
			continue;
		}
		$out[$key] = trim($val);
	}
	return $out;
}

private function getNewFmt($out) {
	if (! STR::contains($out, "<body>")) return $out;

	$out = STR::between($out, "<pre>", "</pre>");
	return STR::split($out, "\n");
}

private function getOldFmt($out) {
	$out = STR::before($out, "<hr>");
	$out = STR::split($out, "\n");
	
	foreach ($out as $key => $val) {
		$val = STR::utf8decode($val); 
		
		switch ($key) {
			case 0:  $dir = $val; break;
			default: $val = STR::replace($val, $dir, "");
		}
		$out[$key] = $val;
	}
	return $out;
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
	$arr = array( // cheating on ssl
		"ssl" => array(
			"verify_peer"      => false,
			"verify_peer_name" => false
		)
	);
	return stream_context_create($arr);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>


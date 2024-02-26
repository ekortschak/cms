<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for synchronizing fs via http

// ***********************************************************
// HOW TO USE
// ***********************************************************
$htp = new http();
$res = $htp->query($act, $dir);

*/

incCls("server/SSL.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class http {
	private $url = "";

function __construct($server, $pcl = "https") {
	$this->url = "$pcl://$server/x.sync.php";
}

// ***********************************************************
// querying remote server
// ***********************************************************
public function query($act, $dir = ".") {
	$cmd = $this->getUrl($act, $dir);
#	$xxx = $this->debug($cmd);
	$out = NET::read($cmd);
	return $out;
}

// ***********************************************************
public function getUrl($act, $fso = ".") { // create acceptable command
	$tim = date("YmdGis"); if (is_file($fso))
	$tim = filemtime($fso);
	$prm = "w:=$act &f:=$fso &t:=$tim";

	$md5 = SSL::md5($fso); // uses SECRET from config.ini
	$prm = SSL::encrypt($prm." &c:=$md5");
	return $this->url."?p=$prm";
}

// ***********************************************************
// cURL upload
// ***********************************************************
public function upload($fso, $dir = "") {
	$cmd = $this->getUrl("cpf", $fso);
#	$xxx = $this->debug($cmd, $fso);

	$fil = FSO::join($dir, $fso);
	$fil = APP::file($fil); if (! $fil) return false;
	$con = curl_init();

	$dat = array(
		'file_contents' => curl_file_create($fil),
		'extra_info' => '123456'
	);
	curl_setopt($con, CURLOPT_URL, $cmd);
	curl_setopt($con, CURLOPT_POST, 1);
	curl_setopt($con, CURLOPT_POSTFIELDS, $dat);
	curl_setopt($con, CURLOPT_RETURNTRANSFER, 1);
	$res = curl_exec($con);

	if (curl_errno($con)) {
		ERR::msg(curl_error($con));
	}
	curl_close($con);

	return $res;
}

// ***********************************************************
// debugging
// ***********************************************************
public static function debug($url, $inf = "dbg") {
	HTW::href($url, "<div>$inf</div>");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>


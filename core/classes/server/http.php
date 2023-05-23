<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for synchronizing fs via http

// ***********************************************************
// HOW TO USE
// ***********************************************************
$htp = new http();
$erg = $htp->query($act, $dir);

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
	return NET::read($cmd);
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

public function upload($fso) {
	$cmd = $this->getUrl("cpf", $fso);

	$fil = APP::file($fso); if (! $fil) return false;
	$fil = curl_file_create($fil);
	$con = curl_init();

	$dat = array(
		'file_contents' => $fil,
		'extra_info' => '123456'
	);
	curl_setopt($con, CURLOPT_URL, $cmd);
	curl_setopt($con, CURLOPT_POST, 1);
	curl_setopt($con, CURLOPT_POSTFIELDS, $dat);
	curl_setopt($con, CURLOPT_RETURNTRANSFER, 1);

	$res = curl_exec($con);
	curl_close($con);

	return $res;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>


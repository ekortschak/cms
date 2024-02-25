<?php
/* ***********************************************************
// INFO
// ***********************************************************
Designed to sync local cms to server ...
* settings: config/ftp.ini

// ***********************************************************
// HOW TO USE
// ***********************************************************
see parent class ...
*/

incCls("server/syncUp.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class syncDist extends syncUp {

function __construct() {
	parent::__construct();

	$this->setSource(FBK_DIR);
}

// **********************************************************
// overruled methods
// **********************************************************
protected function manage($act, $fso) {
	if (! $this->htp) return;

	switch ($act) {
		case "cpf":	$out = $this->htp->upload($fso, $this->srcPath); break;
		default:    $out = $this->htp->query($act, $fso);
	}
	return $this->stripInf($out);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

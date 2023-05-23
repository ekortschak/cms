<?php
/* ***********************************************************
// INFO
// ***********************************************************
currently used only for db transactions

used to ask for user confirmation before
execution of sensible tasks

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("forms/confirm.php");

$cnf = new confirm();
$cnf->add($msg);
$cnf->dic($msg);
$cnf->show();

if ($cnf->act()) ...
*/

incCls("input/ptracker.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class confirm extends tpl {
	private $msg = array();
	private $val = "done";

function __construct() {
	parent::__construct();
	$this->load("input/confirm.tpl");
	$this->set("oid", OID::register());
}

// ***********************************************************
// methods
// ***********************************************************
public function head($msg) {
	$this->msg[] = "<b>".trim($msg)."</b>";
}

public function add($msg, $prm = NV) {
	$prm = $this->chkParm($msg, $prm);
	$msg = trim($msg).$prm;

	$this->msg[] = $msg;
}
public function dic($msg, $prm = NV) {
	$msg = DIC::get($msg);
	$this->add($msg, $prm);
}


private static function chkParm($msg, $prm) {
	if ($prm === NV) return "";
	if (strlen(trim($prm)) < 1) return ": '$prm'";
	if (strlen($msg.$prm) > 75) return ":<br>$prm";
	return ": $prm";
}

public function button($msg, $value) {
	$this->set("button", DIC::get($msg));
	$this->val = $value;
}

// ***********************************************************
// output
// ***********************************************************
public function gc($sec = "main") {
	if ($this->act()) {
		return $this->getSection("Done");
	}
	$tpl = "$sec.item"; $out = "";

	foreach ($this->msg as $key => $msg) {
		$xxx = $this->set("msg", $msg);
		$out.= $this->getSection($tpl);
	}
	$this->set("items", $out);
	return $this->getSection($sec);
}

// ***********************************************************
public function act() {
	$vgl = ENV::getPost("oid");	    if (! $vgl) return false;
	$act = ENV::getPost("cnf.act"); if (! $act) return false;
	return $this->val;
}
public function checked() {
	$vgl = ENV::getPost("oid");	    if (! $vgl) return false;
	$act = ENV::getPost("cnf_chk"); if (! $act) return false;
	return true;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

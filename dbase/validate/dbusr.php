<?php

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class val_dbusr extends recProof {

function __construct($dbase, $table) {
	parent::__construct($dbase, $table);
}

// ***********************************************************
// checking values before writing to DB
// ***********************************************************
public function checkVals($vls)  {
	$pwd = VEC::get($vls, "pwd"); if (strlen($pwd) < 6)
	return ERR::msg("pwd.short");

	$vls["pwd"] = STR::maskPwd($pwd);
	return $vls;
}

// ***********************************************************
// checking dependencies
// ***********************************************************
public function b4Ins($vls) {
	$usr = VEC::get($vls, "uname");
	$arr = array("uname" => $usr);

	$chk = $this->isRecord($arr); if ($chk)
	return ERR::msg("usr.known", $usr);
	return $vls;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

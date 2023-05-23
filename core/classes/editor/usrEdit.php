<?php
/* ***********************************************************
// INFO
// ***********************************************************
needed to write changes to users.ini files

// ***********************************************************
// HOW TO USE
// ***********************************************************
$mgr = new usrEdit();
$mgr->save();

*/

incCls("editor/tabEdit.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class usrEdit extends tabEdit {
	private $grp = "";
	private $usr = "";

function __construct($inifile = "config/users.ini") {
	$this->ini = new ini($inifile);
}

// ***********************************************************
// methods
// ***********************************************************
public function setScope($mode = "") {
	$gps = $this->ini->getSecs();

	if (STR::contains($mode, "R")) {
		unset($gps["admin"]);
		unset($gps["user"]);
	}
	$box = new dropBox("menu");
	$this->grp = $box->getKey("group", $gps);

	if (STR::contains($mode, "U")) {
		$acs = $this->ini->getKeys($this->grp);
		$this->usr = $box->getKey("user", $acs);
	}
	$box->show();
}

public function get($qid) {
	if ($qid == "group") return $this->grp;
	return false;
}

// ***********************************************************
// confirmation
// ***********************************************************
public function cnfGroup($msg) {
	if (! $this->grp) return MSG::now("no.grps.edit");
	$this->act = $this->confirm($msg, $this->grp);
}
public function cnfUser($msg) {
	if (! $this->usr) return MSG::now("no.user.edit");
	$this->act = $this->confirm($msg, $this->usr);
}

public function chkGroup($usr) {
	if ($usr) return true;
	return MSG::now("grp.bad");
}

public function chkUser($usr) {
	if ($usr) return true;
	return MSG::now("usr.bad");
}

public function chkPwd($pwd, $chk) {
	if (CHK::pwd($pwd, $chk)) return true;
	return MSG::now("pwd.bad");
}

// ***********************************************************
// act on groups
// ***********************************************************
public function grpAdd($grp, $usr, $pwd) {
	if (! $this->act) return;
	$this->ini->addSec($grp);
	$this->ini->set("$grp.$usr", md5($pwd));
	$this->ini->save();
}
public function grpDrop($grp) {
	if (! $this->act) return;
	$this->ini->dropSec($grp);
	$this->ini->save();
}

// ***********************************************************
// act on accounts
// ***********************************************************
public function usrAdd($usr, $pwd) {
	if (! $this->act) return;
	$this->ini->set("$this->grp.$usr", md5($pwd));
	$this->ini->save();
}
public function usrEdit($pwd) {
	$this->usrAdd($this->usr, $pwd);
}

public function usrDrop() {
	if (! $this->act) return;
	$this->ini->drop($this->grp, $this->usr);
	$this->ini->save();
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

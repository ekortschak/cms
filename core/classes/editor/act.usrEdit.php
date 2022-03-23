<?php
/* ***********************************************************
// INFO
// ***********************************************************
dbo editor, used to manage dbo properties

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("editor/usrEdit.php");

$obj = new usrEdit();
$obj->exec();
*
*/

incCls("editor/usrWriter.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class usrEdit {

function __construct() {}

// ***********************************************************
// methods
// ***********************************************************
public function exec() {
	$act = ENV::getPost("val_user");    if ($act != "usrEdit") return;
	$usr = ENV::getPost("val_account"); if (! $usr) return;
	$pwd = ENV::getPost("val_pwd");

	if (strlen($pwd) < 6) {
		return ERR::msg("pwd.short");
	}
	$ini = new iniWriter("design/config/users.ini");
	$ini->read("config/users.ini");
	$ini->set("users.$usr", STR::maskPwd($pwd));
	$ini->save();
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>


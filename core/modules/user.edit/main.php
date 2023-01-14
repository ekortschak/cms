<?php

incCls("menus/buttons.php");

// ***********************************************************
HTW::xtag("usr.opts", "h3");
// ***********************************************************
$nav = new buttons("usr", "L", __DIR__);

if (CUR_USER == "www") {
		$nav->add("L", "doLogin");

	if (MAILMODE != "none") {
		$nav->add("F", "doForgot");
	}
	if (DB_CON) {
		$nav->add("R", "doReg");
		$nav->add("C", "doConfirm");
	}
}
// ***********************************************************
else {
// ***********************************************************
	$nav->add("L", "doLogout");
	$nav->add("E", "doData");
	$nav->add("R", "doReset");
	$nav->add("D", "doDrop");
}

// ***********************************************************
$nav->show();

?>

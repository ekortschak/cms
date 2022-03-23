<?php

include_once("core/inc.css.php");

// ***********************************************************
HTM::tag("pfs.static");
HTM::tag("pfs.info", "p");

// ***********************************************************
if (ENV::getPost("cnf_act")) {
	PFS::toggle();
}

switch (PFS::isStatic()) {
	case true: $msg = "pfs.thaw"; break;
	default:   $msg = "pfs.freeze";
}

$msg = DIC::get($msg);

// ***********************************************************
// ask for confirmation
// ***********************************************************
$cnf = new confirm();
$cnf->add($msg);
$cnf->add("&rarr; ".TOP_PATH);
$cnf->show();

?>

<?php

incCls("menus/dropBox.php");
incCls("editor/iniMgr.php");

// ***********************************************************
// select destination
// ***********************************************************
$arr = array(
	"ini" => "Localhost",
);

$nav = new dropBox("menu");
$ext = $nav->getKey("scope", $arr);
$nav->show();

// ***********************************************************
// read and write data
// ***********************************************************
$ful = "config/ftp.ini";
incCls("server/ftp.php");

HTW::tag("file = $ful", "small");

$ini = new iniMgr("LOC_CFG/ftp.def");
$ini->exec($ful);
$ini->show();

// ***********************************************************
HTW::xtag("ftp.check");
// ***********************************************************
$ftp = new ftp();
$chk = $ftp->test();

?>

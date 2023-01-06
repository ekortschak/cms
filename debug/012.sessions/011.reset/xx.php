<?php

$lst = SSV::myFiles();
ksort($lst);

// ***********************************************************
incCls("menus/dropMenu.php");
// ***********************************************************
$box = new dropMenu();
$idx = $box->getKey("idx", $lst);
$xxx = $box->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
incCls("input/confirm.php");

$cnf = new confirm();
$cnf->add("session.reset", $idx);
$cnf->show();

if (! $cnf->act()) return;

// ***********************************************************
$_SESSION[$idx] = array();

?>

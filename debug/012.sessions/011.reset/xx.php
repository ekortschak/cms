<?php

$lst = SSV::myFiles();
ksort($lst);

// ***********************************************************
incCls("menus/localMenu.php");
// ***********************************************************
$box = new localMenu();
$idx = $box->getKey("idx", $lst);
$xxx = $box->show("compact");

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

<?php

incCls("menus/dropbox.php");
incCls("input/confirm.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dbox();
$usr = $box->getKey("group", array("new_group" => "*"));
$box->show("menu");

$usr = $box->getInput("usr.account", "new_group");
$pwd = $box->getInput("usr.pwd", "password");
$xxx = $box->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
$cnf = new confirm();
$cnf->add("group.add");
$cnf->show();

?>

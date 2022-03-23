<?php

incCls("menus/dropbox.php");
incCls("input/confirm.php");

// ***********************************************************
// read ini
// ***********************************************************
$ini = new ini("config/users.ini");
$arr = $ini->getValues("user");
$arr = array_keys($arr);
$arr = array_combine($arr, $arr);

// ***********************************************************
// show menu
// ***********************************************************
$box = new dbox();
$usr = $box->getKey("group", $arr);
$box->show("menu");

// ***********************************************************
// ask for confirmation
// ***********************************************************
$cnf = new confirm();
$cnf->add("group.drop");
$cnf->show();

?>

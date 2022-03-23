<?php

incCls("menus/dropbox.php");
incCls("input/confirm.php");
incCls("input/selector.php");

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

$sel = new selector();
$xxx = $sel->hidden("user", "usrEdit");
$usr = $sel->hidden("account", $usr);
$pwd = $sel->pwd("pwd");
$act = $sel->show();

?>

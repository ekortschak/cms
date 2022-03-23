<?php

if (DB_ADMIN) return;

// ***********************************************************
$sec = DBS::getState();
if ($sec == "nouser") $sec = "admin";

$tpl = new tpl();
$tpl->read("design/templates/user/login.tpl");
$tpl->show($sec);

ENV::set("blockme", true);

?>

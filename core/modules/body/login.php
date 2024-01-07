<?php

DBG::file(__FILE__);

// ***********************************************************
$sec = "main"; # if (DB_ADMIN)
#$sec = "nologin";

$tpl = new tpl();
$tpl->load("user/login.tpl");
$tpl->show($sec);

?>

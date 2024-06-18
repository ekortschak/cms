<?php

if (DB_ADMIN) return;

// ***********************************************************
$sec = CFG::dbState();
if ($sec == "nouser") return;
if ($sec == "main") return;

// ***********************************************************
$tpl = new tpl();
$tpl->load("user/login.tpl");
$tpl->show($sec);

// ***********************************************************
APP::block();

?>

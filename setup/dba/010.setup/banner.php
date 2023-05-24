<?php

if (DB_ADMIN) return;

// ***********************************************************
$sec = ENV::dbState();
if ($sec == "nouser") return;
if ($sec == "main") return;

// ***********************************************************
$tpl = new tpl();
$tpl->load("user/login.tpl");
$tpl->show($sec);

// ***********************************************************
ENV::set("blockme", true);

?>

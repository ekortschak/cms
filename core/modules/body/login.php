<?php

$sec = "main"; # if (DB_ADMIN)
#$sec = "nologin";

$tpl = new tpl();
$tpl->load("user/login.tpl");
$tpl->show($sec);

?>

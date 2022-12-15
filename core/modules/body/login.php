<?php

$sec = "main"; # if (DB_ADMIN)
#$sec = "nologin";

$tpl = new tpl();
$tpl->read("design/templates/user/login.tpl");
$tpl->show($sec);

?>

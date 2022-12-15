<?php

$dir = FSO::mySep(__DIR__);

// ***********************************************************
$cfg = new ini("config/mods.ini");

$tpl = new tpl();
$tpl->read("$dir/main.tpl");

// ***********************************************************
include(APP::file("$dir/banner.php"));
include(APP::file("$dir/edit.php"));
include(APP::file("$dir/opts.php"));
include(APP::file("$dir/user.php"));

?>

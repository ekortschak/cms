<?php

$dir = FSO::mySep(__DIR__);

// ***********************************************************
$cfg = new ini("config/mods.ini"); if (! IS_LOCAL)
$cfg->read("config/mods.srv");

$tpl = new tpl();
$tpl->read("$dir/deco.tpl");

// ***********************************************************
include(APP::file("$dir/banner.php"));
include(APP::file("$dir/edit.php"));
include(APP::file("$dir/opts.php"));

?>

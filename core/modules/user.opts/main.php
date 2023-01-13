<?php

$cfg = CFG::recall("mods");
$dir = APP::relPath(__DIR__);

// ***********************************************************
$tpl = new tpl();
$tpl->read("$dir/main.tpl");

// ***********************************************************
include(APP::file("$dir/banner.php"));
include(APP::file("$dir/edit.php"));
include(APP::file("$dir/opts.php"));
include(APP::file("$dir/user.php"));

?>

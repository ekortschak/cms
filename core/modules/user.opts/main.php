<?php

$cfg = CFG::recall("mods");
$dir = APP::relPath(__DIR__);

// ***********************************************************
$tpl = new tpl();
$tpl->read("$dir/main.tpl");

// ***********************************************************
include "$dir/banner.php";
include "$dir/edit.php";
include "$dir/opts.php";
include "$dir/user.php";

?>

<?php

$dir = FSO::mySep(__DIR__);

// ***********************************************************
$cfg = new ini("config/mods.ini");

$tpl = new tpl();
$tpl->read("$dir/options.tpl");

// ***********************************************************
include(APP::file("$dir/options.php"));
include(APP::file("$dir/edit.php"));
include(APP::file("$dir/feedback.php"));

?>

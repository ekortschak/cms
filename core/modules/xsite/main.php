<?php
// script is used to generate a single html from the folder structure
// which can then be saved as a pdf by the browser functionality.

# DBG::file(__FILE__);

incCls("system/PRN.php");
incCls("xsite/bind.php");

// ***********************************************************
// what's up
// ***********************************************************
$dir = ENV::get("xsite.top", TAB_HOME);
$opt = ENV::get("xsite.opt", "doc");
$dst = ENV::get("xsite.dst", "scr");

// ***********************************************************
// assemble pages into single doc
// ***********************************************************
$buk = new bind();
$buk->read($dir);
$buk->exec($dst, $opt);

// ***********************************************************
PGE::restore();

?>

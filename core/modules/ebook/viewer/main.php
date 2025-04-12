<?php
// script is used to generate a single html from the folder structure
// which can then be saved as a pdf by the browser functionality.

# DBG::file(__FILE__);

incCls("system/PRN.php");
incCls("ebook/bind.php");

// ***********************************************************
// what's up
// ***********************************************************
$dir = ENV::get("ebook.top", TAB_HOME);
$opt = ENV::get("ebook.opt", "doc");
$dst = ENV::get("ebook.dst", "scr");

// ***********************************************************
// assemble pages into single doc
// ***********************************************************
$buk = new bind();
$buk->read($dir);
$buk->exec($dst, $opt);

// ***********************************************************
PGE::restore();

?>

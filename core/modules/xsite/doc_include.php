<?php

$loc = PGE::dir(); if (! $loc) return;
#$loc = PGE::$dir; if (! $loc) return;

if (FSO::isHidden($loc)) return;

// ***********************************************************
// show item as default chapter
// ***********************************************************
incCls("xsite/chapter.php");

$kap = new chapter();
$kap->init($loc);
$kap->show();

?>

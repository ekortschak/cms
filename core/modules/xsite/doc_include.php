<?php

$loc = PGE::dir(); if (! $loc) return;
// ***********************************************************

$kap = new chapter();
$kap->init($loc);
$kap->show();

?>

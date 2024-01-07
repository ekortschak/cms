<?php

$loc = PGE::dir();

$kap = new chapter();
$kap->load("xsite/main.tpl");
$kap->init($loc);
$kap->show();

?>

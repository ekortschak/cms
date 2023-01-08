<?php

$dir = "teaser";

// ***********************************************************
incCls("files/teaser.php");

$tsr = new teaser();
$tsr->load("modules/fview.teaser.tpl");
$tsr->setPics($dir);
$tsr->show();

?>


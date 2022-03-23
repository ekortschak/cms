<?php

$dir = ".teaser";

// ***********************************************************
incCls("files/teaser.php");

$tsr = new teaser();
$tsr->setPics($dir);
$tsr->show();

?>


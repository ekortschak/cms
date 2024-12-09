<?php

DBG::file(__FILE__);

// ***********************************************************
incCls("files/teaser.php");
// ***********************************************************
$tsr = new teaser();
$tsr->load("modules/fview.teaser.tpl");
$tsr->setPics("teaser");
$tsr->show();

?>


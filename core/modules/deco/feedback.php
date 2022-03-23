<?php

if (! APP::isView()) return;
if (! DB_CON) return;

incCls("menus/qikLink.php");

// ***********************************************************
HTM::tag("Feedback");
// ***********************************************************
$qik = new qikLink();
$qik->getVal("opt.feedback");
$qik->show();

?>

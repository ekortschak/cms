<?php

incCls("ebook/toctool.php");

// ***********************************************************
$key = PGE::get("pfs.chnum");

$toc = new toctool();
$num = $toc->get("toc.$key");

echo $num;

?>

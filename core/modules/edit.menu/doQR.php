<?php

HTW::tag("QR-Codes erstellen", "h4");
$loc = PGE::$dir;


incCls("other/qrCode.php");

$qrc = new qrCode();
$qrc->url("?tpc=pages/home&pge=passover");
$qrc->url("www.krone.at");
$qrc->save($loc, "hugo");
#$qrc->send();


?>

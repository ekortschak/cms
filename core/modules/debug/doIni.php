<?php

$ful = FSO::join(CUR_PAGE, "page.ini");
$txt = APP::read($ful);

incCls("other/tutorial.php");

$cod = new tutorial();
$txt = $cod->markGroups($txt);
$txt = trim($txt); if (! $txt)
$txt = NV;

echo "<pre>";
echo $txt;
echo "</pre>";

?>

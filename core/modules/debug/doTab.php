<?php

$ful = FSO::join(TAB_ROOT, "tab.ini");
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

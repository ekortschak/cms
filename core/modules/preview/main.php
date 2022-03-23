????? OBSOLETE ?????

<?php

$fil = ENV::getParm("file"); if (! $fil) return;
$ful = APP::file($fil); if (! $ful) return;

include $ful;

?>

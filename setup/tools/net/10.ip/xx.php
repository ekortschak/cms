<?php

if (! IS_LOCAL) return MSG::now("edit.deny");

// ***********************************************************
$dir = FSO::mySep(__DIR__);
$ipa = $_SERVER["SERVER_ADDR"];

HTW::tag($dir, "p");
HTW::tag($ipa, "p");

?>

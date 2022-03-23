<?php

if (! IS_LOCAL) return MSG::now("edit.deny");

// ***********************************************************
$dir = FSO::mySep(__DIR__);
$ipa = $_SERVER["SERVER_ADDR"];

echo "<p>$dir</p>";
echo "<p>$ipa</p>";

?>

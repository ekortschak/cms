<?php

$ini = new ini();
$ipa = $ini->get("props.ip"); if (! $ipa) return;

incCls("files/stream.php");

$stream = new VideoStream($ipa);
$stream->start();

?>
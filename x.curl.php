<?php

ob_start();

include_once("config/basics.php");
include_once("core/inc.min.php");

echo ob_get_clean();

// ***********************************************************
$lst = print_r($_FILES, true);

LOG::write("curl.log", $lst);

?>

<hr>
<p>CMS: FX complete</p>

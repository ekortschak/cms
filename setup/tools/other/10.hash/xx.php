
<?php

incCls("input/selector.php");
// ***********************************************************
$arr = array("md5" => "MD5", "sha1" => "SHA1");

// ***********************************************************
$sel = new selector();
$fnc = $sel->combo("tools.fnc", $arr);
$txt = $sel->input("Text", "Anything");
$sel->show();

HTM::tag("result", "h5");
HTM::cap("$fnc($txt) = ".$fnc($txt), "p");

?>

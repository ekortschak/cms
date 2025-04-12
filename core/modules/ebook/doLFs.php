<?php

incCls("input/selector.php");
$lng = CUR_LANG;

// ***********************************************************
// show form
// ***********************************************************
HTW::xtag("Printing Properties");

$dir = PGE::$dir;
$prn = PGE::get("props.noprint");
$pbr = PGE::get("$lng.pbreak");
$pbi = PGE::hasPbr($dir);

$sel = new selector();
$sel->forget();
$sel->check("noprint", $prn);
$sel->check("pbrB4", $pbr);
$sel->hold("dir", PGE::$dir);
$sel->show();

?>

<h4>Info</h4>
<p>Any modification to pagebreak setting will remove all pagebreaks within the chapter.</p>

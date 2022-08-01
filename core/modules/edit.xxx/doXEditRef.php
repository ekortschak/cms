<?php

return;

$fnd = "bblRef(";
$cls = ");";

$txt = APP::read($fil);
$arr = STR::find($txt, $fnd, $cls); if (! $arr) return;

#if (! STR::contains($fil, "de.htm")) return;
#if (! STR::contains($txt, "5:29f")) return;

foreach ($arr as $key) {
	$rep = $key;
	$rep = STR::replace($rep, "<b> ", " <b>");

	$rep = STR::replace($rep, " </b>", "</b> ");
	$rep = STR::replace($rep, "</b>.", ".</b>");
	$rep = STR::replace($rep, "</b>,", ",</b>");
	$rep = STR::replace($rep, "</b>;", ";</b>");
	$rep = STR::replace($rep, "</b>:", ":</b>");
	$rep = STR::replace($rep, "</b>!", "!</b>");
	$rep = STR::replace($rep, "</b>?", "?</b>");

	$rep = STR::replace($rep, "<b><br>", "<br><b>");

	$txt = STR::replace($txt, $key, $rep);
}

file_put_contents($fil, $txt);

?>

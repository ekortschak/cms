
<hr>
<a href="https://www.w3schools.com/colors/colors_picker.asp" target="blank">
	Color Picker @ w3schools.com
</a>
<hr>



<?php

incCls("system/colors.php");
incCls("input/selector.php");

// ***********************************************************
// show options
// ***********************************************************
$clr = new color();
$col = $clr->getNames();
$mds = array("bg" => "Background", "fc" => "Font");
$stp = array("0.05" => "  5%", "0.075" => "  7%", "0.1" => "10%", "0.15" => "15%");

$sel = new selector();
$col = $sel->combo("color.names", $col);
$mds = $sel->combo("color.fixed", $mds);
$sat = $sel->range("color.chroma", 5, 0, 10) / 10;
$stp = $sel->combo("color.step", $stp, "0.15");
$sel->show();

// ***********************************************************
// show color table
// ***********************************************************
$dir = APP::dir(__DIR__);

$tpl = new tpl();
$tpl->read("$dir/colors.tpl");
$tpl->set("fixedColor", $col);
$tpl->show("main");
$tpl->show("tbl.open");

for ($i = 0.99; $i > 0; $i -= $stp) {
	$tpl->show("tr.open");

	for ($j = 0; $j <= 1; $j += $stp) {
		$rgb = $clr->findColor($j, $sat, $i);
		$col = $clr->setColor($rgb);

		$tpl->set("changingColor", $col);
		$tpl->show("lin.$mds");
	}
	$tpl->show("tr.close");
}
$tpl->show("tbl.close");

?>

<?php

incCls("input/button.php");

$btn = new button();
$btn->set("link", "?act=rewrite");
$btn->set("caption", "ReWrite");
$btn->show();

echo "Sort entries within current language";
echo "<br>";

$btn->set("link", "?act=spawn");
$btn->set("caption", "Spawn ".strtoupper(CUR_LANG));
$btn->show();

echo "Transfer entries to other languages";
echo "<br>";

$act = ENV::getParm("act");

switch($act) {
	case "rewrite": reWrite(); break;
	case "spawn":   spawn();   break;
}

return;

// ***********************************************************
// options
// ***********************************************************
function reWrite() {
	$lng = CUR_LANG;
 	$ptn = FSO::join(APP_FBK, LOC_DIC, $lng, "*.dic");
	$fls = FSO::files($ptn);
	$sec = "[dic.$lng]";

 	foreach ($fls as $fil => $nam) {
		$txt = APP::read($fil);
		$arr = explode("\n", $txt); sort($arr);
		$out = array();

		foreach ($arr as $lin) {
			if (! STR::contains($lin, "="))  continue;

			if (STR::begins($lin, "prop."))  continue;
			if (STR::begins($lin, "btn."))   continue;
			if (STR::begins($lin, "§"))      continue;
			if (substr_count($lin, "/") > 1) continue;
			if (substr_count($lin, "=") > 1) continue;
			$out[] = $lin;
		}
		$txt = "$sec\n".implode("\n", $out);
		$xxx = APP::write($fil, "$txt\n");
	}
}

// ***********************************************************
function spawn() {
	$lng = CUR_LANG;
 	$ptn = FSO::join(APP_FBK, LOC_DIC, $lng, "*.dic");
	$fls = FSO::files($ptn);

	foreach ($fls as $fil => $nam) {
		$lns = file($fil); $out = array();

		foreach (LNG::get() as $itm) {
			if ($itm == $lng) continue;

			$rep = DIC::get($itm); if (! $rep) continue;

			foreach ($lns as $lin) {
				if (STR::contains($lin, "[dic.$lng]")) {
					$out[] = "[dic.$itm]";
					continue;
				}
				if (! STR::contains($lin, "=")) {
					$out[] = $lin;
					continue;
				}
				$key = STR::before($lin, "=");
				$val = STR::after($lin, "=");

				$xlt = VEC::get($rep, $key); if (! $xlt) $xlt = "$val*";
				$out[] = "$key = $xlt";
			}
			$txt = implode("\n", $out);
			$sav = FSO::join(APP_FBK, LOC_DIC, $itm, $nam);
			$xxx = APP::write($sav, "$txt\n");
		}
	}
}

?>

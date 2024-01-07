<?php

incCls("menus/dropBox.php");

// ***********************************************************
// show options
// ***********************************************************
$lng = CUR_LANG;
$arr = array(
	"write" => "Sort entries within current language",
	"spawn" => "Transfer entries from '$lng' to other languages",
);

$box = new dropBox("menu");
$act = $box->getKey("dict.act", $arr);
$xxx = $box->show();


switch($act) {
	case "write": reWrite(); break;
	case "spawn": spawn();   break;
}

// TODO: confirm action

return;

// ***********************************************************
// options
// ***********************************************************
function reWrite() {
	$lng = CUR_LANG;
 	$ptn = APP::fbkFile(LOC_DIC, $lng);
	$fls = FSO::files($ptn, "*.dic");
	$sec = "[dic.$lng]";

 	foreach ($fls as $fil => $nam) {
		$txt = APP::read($fil);
		$arr = STR::split($txt); sort($arr);
		$out = array();

		foreach ($arr as $lin) {
			if (STR::misses($lin, "="))  continue;

			if (STR::begins($lin, "prop."))  continue;
			if (STR::begins($lin, "btn."))   continue;
			if (STR::begins($lin, "§"))      continue;
			if (FSO::level($lin) > 1)        continue;
			if (STR::count($lin, "=") > 1)   continue;
			$out[] = $lin;
		}
		$txt = "$sec\n".implode("\n", $out);
		$xxx = APP::write($fil, "$txt\n");
	}
}

// ***********************************************************
function spawn() { // create missing language entries from [dic.CUR_LANG]
 	$ptn = APP::fbkFile(LOC_DIC, CUR_LANG);
	$fls = FSO::files($ptn, "*.dic");

	foreach ($fls as $fil => $nam) {
		$lns = file($fil); $out = array();

		foreach (LNG::get() as $lng) {
			if ($lng == CUR_LANG) continue;
			$out[] = "[dic.$lng]";

			$rep = DIC::get($lng); if (! $rep) continue;

			foreach ($lns as $lin) {
				if (STR::misses($lin, "=")) continue;

				$key = STR::before($lin, "=");
				$val = STR::after($lin, "=");
				$xlt = DIC::get($key, $lng, "$val*");

				$out[] = "$key = $xlt";
			}
			$txt = implode("\n", $out);
			$sav = APP::fbkFile(LOC_DIC, "$lng/$nam");
			$xxx = APP::write($sav, $txt);
		}
	}
}

?>

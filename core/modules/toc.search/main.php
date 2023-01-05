<?php

incCls("search/swrap.php");

// ***********************************************************
// get parameters
// ***********************************************************
$obj = new swrap();
$opt = $obj->getScope();

$fnd = ENV::get("search");
$fnd = str_replace('"', "'", $fnd);

$lst = $obj->getResults($fnd); if($lst) ksort($lst);
$res = "";

// ***********************************************************
// get results
// ***********************************************************
$tpl = new tpl();
$tpl->load("modules/search.tpl");

if (! is_array($lst)) $res = DIC::get("no.match");
else {
	foreach ($lst as $tab => $inf) {
		$tpc = PGE::getTitle($tab);
		$xxx = $tpl->set("topic", $tpc);
		$xxx = $tpl->set("dir", $tab);
		$res.= $tpl->getSection("topic");

		foreach ($inf as $lnk => $cap) {
			$xxx = $tpl->set("title", $cap);
			$xxx = $tpl->set("key", $lnk);
			$res.= $tpl->getSection("item");
		}
	}
}

// ***********************************************************
// show modules
// ***********************************************************
$sec = "result"; if (strlen($fnd) < 2)
$sec = "err.short";

$tpl->set("range", $opt);
$tpl->set("search", $fnd);
$tpl->set("items", $res);
$tpl->set("result", "<!SEC:$sec!>");
$tpl->show();

?>

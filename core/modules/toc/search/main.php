<?php

DBG::file(__FILE__);

// ***********************************************************
// get parameters
// ***********************************************************
incCls("search/search.php");

$obj = new search();
$opt = $obj->getScope();

$fnd = ENV::get("search.what");
$fnd = str_replace('"', "'", $fnd);

$lst = $obj->getResults($fnd);
$lst = VEC::sort($lst);
$res = "";

// ***********************************************************
// get results
// ***********************************************************
$tpl = new tpl();
$tpl->load("modules/search.tpl");

if (! is_array($lst)) $res = DIC::get("no.match");
else {
	foreach ($lst as $tab => $inf) {
		$tpc = PGE::title($tab);
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

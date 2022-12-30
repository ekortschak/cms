<?php

$fnd = ENV::get("search");
$fnd = str_replace('"', "'", $fnd);

// ***********************************************************
// get results
// ***********************************************************
incCls("search/swrap.php");

$obj = new swrap();
$opt = $obj->getScope();
$lst = $obj->getResults($fnd);
$res = "";

$tpl = new tpl();
$tpl->load("modules/search.tpl");

if (! is_array($lst)) {
	$res = DIC::xlate($lst);
}
else {
	foreach ($lst as $tab => $inf) {
		$tpc = HTM::pgeTitle($tab);
		$xxx = $tpl->set("tab", $tab);
		$xxx = $tpl->set("topic", $tpc);
		$res.= $tpl->getSection("topic");

		foreach ($inf as $lnk => $cap) {
			$xxx = $tpl->set("title", $cap);
			$xxx = $tpl->set("key", $lnk);
			$res.= $tpl->getSection("item");
		}
	}
}

// ***********************************************************
// show module
// ***********************************************************
$sec = "result"; if (strlen($fnd) < 2)
$sec = "err.short";

$tpl->set("range", $opt);
$tpl->set("search", $fnd);
$tpl->set("items", $res);
$tpl->set("result", "<!SEC:$sec!>");
$tpl->show();

?>

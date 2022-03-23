<?php

$fnd = ENV::get("search");
$fnd = str_replace('"', "'", $fnd);

// ***********************************************************
// show search details in body pane
// ***********************************************************
incCls("menus/dropbox.php");

$arr = array(
	"*" => "Whole Document",
	"h" => "Sections",
	"p" => "Paragraphs",
);
$box = new dbox();
$sep = $box->getKey("Search.Sep", $arr, "h");
$box = $box->gc();

// ***********************************************************
// get results
// ***********************************************************
incCls("search/swrap.php");

$obj = new swrap();
$lst = $obj->getResults($fnd);
$res = "";

$tpl = new tpl();
$tpl->read("design/templates/modules/search.tpl");
$tpl->set("range", $box);

if (! is_array($lst)) {
	$res = $lst;
}
else {
	foreach ($lst as $lnk => $cap) {
		$xxx = $tpl->set("title", $cap);
		$xxx = $tpl->set("link", $lnk);
		$res.= $tpl->getSection("item");
	}
}

// ***********************************************************
// show module
// ***********************************************************
$sec = "result"; if (strlen($fnd) < 2)
$sec = "errShort";

$tpl->set("search", $fnd);
$tpl->set("items", $res);
$tpl->set("result", "<!SEC:$sec!>");
$tpl->show();

?>

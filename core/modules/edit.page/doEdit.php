<?php

incCls("menus/qikScript.php");

$snp = new ini("config/snips.ini");
$arr = $snp->getValues("html");
$arr = array_flip($arr);

// ***********************************************************
// toolbar code snips - if needed
// ***********************************************************
$box = new qikScript();
$xxx = $box->getCode("snip", $arr);
$snp = $box->gc();

// ***********************************************************
// editable content
// ***********************************************************
$htm = APP::read($fil);

switch ($sec) {
	case "code": case "xtern": break;

	case "ck4": case "ck5":
		if (STR::contains($htm, "<?php")) $sec = "ckError"; break;

	default:
		$htm = PRG::replace($htm, "<\?php(\s*?)(\S+)", "<php>$2");
		$htm = PRG::replace($htm, "(\s*?)\?>", "</php>");
}

switch ($sec) {
	case "xedit":
		$htm = htmlspecialchars($htm); break;

	case "html": // clean up code
		$htm = STR::replace($htm, "<table>", "¶<table border=1>");

		$htm = STR::replace($htm, "<h", "¶<h");
		$htm = STR::replace($htm, "<p>", "¶<p>");
		$htm = STR::replace($htm, "<ul>", "¶<ul>");
		$htm = STR::replace($htm, "<ol>", "¶<ol>");
		$htm = STR::replace($htm, "<dl>", "¶<dl>");
		$htm = STR::replace($htm, "<blockquote>", "¶<blockquote>");
		$htm = "¶".$htm."¶";

		$htm = PRG::replace($htm, "<br></p>", "</p>");
		$htm = PRG::replace($htm, "<br></h([1-9]?)>", "</h$1>");
		$htm = PRG::replace($htm, "<p>(\s*?)</p>", "");
		$htm = PRG::replace($htm, "¶(\s*)¶", "¶");
		$htm = PRG::replace($htm, "¶(\s*)¶", "¶");

		if (! STR::ends($htm, "¶")) $htm.= "¶";
		break;
}

// ***********************************************************
// required size
// ***********************************************************
$rws = substr_count($htm, "\n") + 3;
$rws = CHK::range($rws, 35, 7);

// ***********************************************************
// show editor
// ***********************************************************
$tpl = new tpl();
$tpl->load("editor/edit.$sec.tpl");
$tpl->set("file", APP::relPath($fil));
$tpl->set("path", APP::tempDir("curedit"));
$tpl->set("snips", $snp);
$tpl->set("rows", $rws);
$tpl->set("content", $htm);
$tpl->show();

?>

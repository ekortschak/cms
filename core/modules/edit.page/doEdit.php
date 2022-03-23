<?php

// ***********************************************************
// show toolbar - if needed
// ***********************************************************
if ($bar) {
	$snp = new ini("config/snips.ini");
	$arr = $snp->getValues("html");
	$arr = array_flip($arr);

	$box = new qikScript();
	$xxx = $box->getCode("snip", $arr);
	$snp = $box->gc("combo");

	$tpl = new tpl();
	$tpl->read("design/templates/editor/toolbar.tpl");
	$tpl->set("snips", $snp);
	$tpl->set("file", $fil);
	$tpl->set("path", APP::tempDir("curedit"));
	$tpl->show("$bar.edit");
}

// ***********************************************************
// show editor
// ***********************************************************
$tpl = new tpl();
$tpl->read("design/templates/editor/viewEdit.tpl");
$tpl->set("file", FSO::clearRoot($fil));

switch ($sec) {
	case "code":
		$tpl->set("content", APP::gc($fil)); break;

	case "ck4": case "ck5":
	case "text":
		$htm = APP::read($fil);
		$tpl->set("content", $htm); break;

// ***********************************************************
	case "html": // prepare for editor
// ***********************************************************
		$htm = APP::read($fil);
		$htm = PRG::replace($htm, "<\?php(\s*?)(\S+)", "<php>$2");
		$htm = PRG::replace($htm, "(\s*?)\?>", "</php>");
		$htm = STR::replace($htm, "<table>", "¶<table border=1>");

		$htm = STR::replace($htm, "<h", "¶<h");
		$htm = STR::replace($htm, "<p>", "¶<p>");
		$htm = STR::replace($htm, "<ul>", "¶<ul>");
		$htm = STR::replace($htm, "<ol>", "¶<ol>");
		$htm = STR::replace($htm, "<dl>", "¶<dl>");
		$htm = STR::replace($htm, "<blockquote>", "¶<blockquote>");
		$htm = "¶".$htm."¶";

		$htm = PRG::replace($htm, "<br></p>", "</p>");
		$htm = PRG::replace($htm, "<p>(\s*?)</p>", "");
		$htm = PRG::replace($htm, "¶(\s*)¶", "¶");
		$htm = PRG::replace($htm, "¶(\s*)¶", "¶");

		$rws = substr_count($htm, "\n") + 5;
		$rws = CHK::range($rws, 35, 7);

		$tpl->set("rows", $rws);
		$tpl->set("content", $htm); break;

// ***********************************************************
	case "pic":
// ***********************************************************
		$ini = new ini(dirname($fil));
		$uid = $ini->getUID();
		$tpl->set("title", $uid);

		incCls("dbase/recEdit.php");

		$md5 = md5($fil);

		$dbe = new recEdit(NV, "copyright");
		$dbe->findRec("md5='$md5'");
		$dbe->setProp("md5", "fstd", $md5);
		$dbe->setProp("owner", "fstd", CUR_USER);
		$dbe->setProp("holder", "fstd", "Glaube ist mehr");
		$dbe->setProp("source", "fstd", "glaubeistmehr.at");
		$dbe->setProp("perms", "fstd", "free");
		$dbe->setProp("verified", "fstd", 1);
		$dbe->show();
		break;
}
// ***********************************************************
$tpl->show($sec);
// ***********************************************************

?>

<?php
/* ***********************************************************
// INFO
// ***********************************************************
This class is designed to replace strings by their translated values.
* Translation is not automatic since it would require a paid service.
* Instead a string will be provided that is to be pasted into an online translator.
* The translation will then be pasted into the same form
* from which the replacements will be effected.

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/xlator.php");

$xlt = new xlator();
$htm = $xlt->getTags($fil);
$htm = $xlt->getRepText($rep);
$xxx = $xlt->save($fil, $htm, $lang);
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class xlator {
	private $tgs = array(); // tags that need to be translated
	private $php = array(); // code snips
	private $dic = array(); // text snips

	private $rep = "";      // text with place holders
	private $act = "";      // text to translate

function __construct() {
	$tgs = "php.h1.h2.h3.h4.h5.h6.p.li.dt.dd.div.td";
	$this->tgs = STR::toArray($tgs);
}

// ***********************************************************
// analize structure
// ***********************************************************
public function getTags($txt) { // passing file or text
	if (is_file($txt)) $txt = APP::read($txt);
	$this->dir = $this->php = array(); $out = "";

	$txt = $this->secure($txt);
	$txt = $this->clearBreaks($txt);
	$rep = $this->analize($txt);
	$this->rep = $rep;

	foreach ($this->dic as $key => $itm) {
		$rep = STR::replace($rep, $itm, "[$key]");
		$out.= "[$key] = $itm\n";
	}
	$out = $this->restore($out);
	return $out;
}

// ***********************************************************
// replace text by translations - preserving php snips
// ***********************************************************
public function getRepText($text) {
	$arr = STR::find($text, "[", "] ="); $lst = array();

	foreach ($arr as $key) {
		$val = STR::after($text, "[$key] =");
		$val = STR::before($val, "\n[");

		$lst[$key] = $this->cleanTags($val);
	}
	$out = $this->rep;
	$out = $this->repKeys($out, $lst);
	$out = $this->repKeys($out, $this->php);
	$out = $this->restore($out);
	return $out;
}

private function repKeys($out, $arr) {
	foreach ($arr as $key => $val) {
		if (! $key) continue;
		$out = STR::replace($out, "[$key]", $val);
	}
	return $out;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function analize($txt) {
	foreach($this->tgs as $tag) {
		$arr = STR::find($txt, "<$tag>", "</$tag>"); if (! $arr) continue;

		foreach ($arr as $val) {
			$key = md5($val); if (! $val) continue;

			if ($tag == "php")
			$this->php[$key] = $val; else
			$this->dic[$key] = $val;

			$txt = STR::replace($txt, "<$tag>$val</$tag>", "<$tag>[$key]</$tag>");
		}
	}
	return $txt;
}

// ***********************************************************
private function clearBreaks($txt) {
	$brk = '<hr class="pbr">';
	$txt = STR::clear($txt, "$brk\n\n");
	$txt = STR::clear($txt, "$brk\n");
	$txt = STR::clear($txt,  $brk);
	return $txt;
}

private function cleanTags($txt) {
	$out = $this->cleanTag($txt, "b");
	$out = $this->cleanTag($out, "u");
	$out = $this->cleanTag($out, "i");
	return $out;
}

private function cleanTag($txt, $tag) {
	$out = STR::replace($txt, "<$tag> ",  "<$tag>");
	$out = STR::replace($out, " </$tag>", "</$tag>");
	return $out;
}

// ***********************************************************
private function secure($txt) {
	$txt = STR::replace($txt, "\n", "§lf§");
	$txt = STR::replace($txt, "<?php ", "<php>");
	$txt = STR::replace($txt, " ?>", "</php>");
	return $txt;
}
private function restore($txt) {
	$txt = STR::replace($txt, "§lf§", "\n");
	return $txt;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
